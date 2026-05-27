<?php
ob_start();
require_once 'config.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require_once 'functions.php';
autoDeleteOldAnnouncements();

$conn = db();
$page = $_GET['page'] ?? 'dashboard';

// ============ TANGAZA MSIBA ============
if (isset($_POST['tangaza_msiba'])) {
    $custom = trim($_POST['custom_message_msiba'] ?? '');
    if (!empty($custom)) {
        $final_message = $custom;
    } else {
        $jina = $conn->real_escape_string($_POST['jina_maiti']);
        $maelezo = $conn->real_escape_string($_POST['maelezo_msiba']);
        $tarehe = $conn->real_escape_string($_POST['tarehe_mazishi']);
        $mahali = $conn->real_escape_string($_POST['mahali_msiba']);
        $mahali_dua = $conn->real_escape_string($_POST['mahali_dua'] ?? $mahali);
        
        // FORMAT RAHISI - JINA LITAONEKANA MOJA KWA MOJA
        $final_message = "📛 $jina\n";
        $final_message .= "📝 $maelezo\n";
        $final_message .= "📅 $tarehe\n";
        $final_message .= "📍 $mahali\n";
        $final_message .= "🕌 $mahali_dua\n";
        $final_message .= "📿 Al-Fatiha kwa roho ya marehemu.\n";
        $final_message .= "★ Tunawakaribisha wote kwenye mazishi.";
    }
    
    $stmt = $conn->prepare("INSERT INTO announcements (type, title, message) VALUES ('msiba', ?, ?)");
    $title = "Msiba wa " . ($_POST['jina_maiti'] ?? '');
    $stmt->bind_param("ss", $title, $final_message);
    $stmt->execute();
    $_SESSION['msg'] = "✓ Tangazo la msiba limehifadhiwa!";
    header("Location: index.php?page=announcements");
    exit();
}

// ============ TANGAZA HARUSI ============
if (isset($_POST['tangaza_harusi'])) {
    $custom = trim($_POST['custom_message_harusi'] ?? '');
    if (!empty($custom)) {
        $final_message = $custom;
    } else {
        $bwana = $conn->real_escape_string($_POST['jina_mwanaume']);
        $bibi = $conn->real_escape_string($_POST['jina_mwanamke']);
        $tarehe = $conn->real_escape_string($_POST['tarehe_harusi']);
        $mahali = $conn->real_escape_string($_POST['mahali_harusi']);
        $muda = $conn->real_escape_string($_POST['muda_harusi'] ?? 'Saa 2 Mchana');
        $maelezo = $conn->real_escape_string($_POST['maelezo_harusi'] ?? '');
        
        $final_message = "ALHAMDULILLAH!\n\n";
        $final_message .= "👨‍🎓 $bwana\n";
        $final_message .= "👩‍🎓 $bibi\n\n";
        $final_message .= "📅 $tarehe\n";
        $final_message .= "⏰ $muda\n";
        $final_message .= "📍 $mahali\n\n";
        if (!empty($maelezo)) {
            $final_message .= "📝 $maelezo\n\n";
        }
        $final_message .= "★ Karibuni wote kwa furaha na baraka! ★\n\n";
        $final_message .= "─ ESTQAMA UVZ ─";
    }
    
    $stmt = $conn->prepare("INSERT INTO announcements (type, title, message) VALUES ('harusi', ?, ?)");
    $title = "Harusi ya " . ($_POST['jina_mwanaume'] ?? '') . " na " . ($_POST['jina_mwanamke'] ?? '');
    $stmt->bind_param("ss", $title, $final_message);
    $stmt->execute();
    $_SESSION['msg'] = "✓ Tangazo la harusi limehifadhiwa!";
    header("Location: index.php?page=announcements");
    exit();
}

// ============ Tuma SMS (Admin) ============
if (isset($_POST['send_sms'])) {
    $message = trim($_POST['message']);
    $recipient_type = $_POST['recipient_type'];
    $save_to_db = isset($_POST['save_to_db']);
    $numbers = [];
    
    if (empty($message)) {
        $_SESSION['msg'] = "⚠️ Andika ujumbe!";
        header("Location: index.php?page=send");
        exit();
    }
    
    if ($recipient_type == 'all') {
        $result = $conn->query("SELECT phone, name FROM members WHERE status='active'");
        while ($row = $result->fetch_assoc()) $numbers[] = $row;
    } elseif ($recipient_type == 'group' && !empty($_POST['group_id'])) {
        $gid = intval($_POST['group_id']);
        $result = $conn->query("SELECT m.phone, m.name FROM members m JOIN member_groups mg ON m.id=mg.member_id WHERE mg.group_id=$gid AND m.status='active'");
        while ($row = $result->fetch_assoc()) $numbers[] = $row;
    } elseif ($recipient_type == 'custom' && !empty($_POST['custom_phone'])) {
        $phone = preg_replace('/[^0-9]/', '', $_POST['custom_phone']);
        if (validatePhoneNumber($phone)) {
            $numbers[] = ['phone' => formatPhoneForDisplay($phone), 'name' => 'Nambari Maalum'];
        }
    }
    
    $sent = $failed = 0;
    foreach ($numbers as $r) {
        $requestId = null;
        if (SMS_ENABLED) {
            $success = sendSMSBeem($r['phone'], $message, $requestId);
            $success ? $sent++ : $failed++;
            $status = $success ? 'sent' : 'failed';
        } else {
            $requestId = 'TEST_' . time();
            $sent++;
            $status = 'sent';
        }
        if ($save_to_db) {
            $stmt = $conn->prepare("INSERT INTO sms_history (phone, name, message, status, request_id, sent_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("sssss", $r['phone'], $r['name'], $message, $status, $requestId);
            $stmt->execute();
        }
    }
    $_SESSION['msg'] = "✓ SMS: $sent zimetumwa" . ($failed ? " | $failed zimeshindwa" : "");
    header("Location: index.php?page=send");
    exit();
}

// ============ Futa Tangazo ============
if (isset($_GET['delete_announcement']) && isset($_GET['id'])) {
    $conn->query("DELETE FROM announcements WHERE id = " . intval($_GET['id']));
    $_SESSION['msg'] = "✓ Tangazo limefutwa!";
    header("Location: index.php?page=announcements");
    exit();
}

// ============ LOGOUT ============
if (isset($_GET['logout']) || $page === 'logout') {
    session_destroy();
    header("Location: login.php");
    exit();
}

require_once 'header.php';
require_once 'sidebar.php';

$total_members = (int)$conn->query("SELECT COUNT(*) FROM members WHERE status='active'")->fetch_row()[0];
$total_sent = (int)$conn->query("SELECT COUNT(*) FROM sms_history WHERE status='sent'")->fetch_row()[0];
$beemBalance = checkBeemBalance();

$pageFile = __DIR__ . '/pages/' . $page . '.php';
if (file_exists($pageFile)) {
    include $pageFile;
} else {
    include __DIR__ . '/pages/dashboard.php';
}

$conn->close();
require_once 'footer.php';
ob_end_flush();
?>