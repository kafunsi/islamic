<?php
$balance_cache = null;
$balance_cache_time = 0;

function getAllAnnouncementsForRotate() {
    $conn = db();
    $result = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");
    $announcements = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $announcements[] = $row;
        }
    }
    return $announcements;
}

function sendSMSBeem($phone, $message, &$requestId = null) {
    if (!SMS_ENABLED) {
        $requestId = 'test_' . time();
        return true;
    }

    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    if (strlen($phone) == 10 && $phone[0] == '0') {
        $phone = '255' . substr($phone, 1);
    } elseif (strlen($phone) == 9 && ($phone[0] == '6' || $phone[0] == '7')) {
        $phone = '255' . $phone;
    } elseif (strlen($phone) == 12 && substr($phone, 0, 3) == '255') {
        $phone = $phone;
    } else {
        return false;
    }

    if (!preg_match('/^255[67][0-9]{8}$/', $phone)) {
        return false;
    }

    $postData = [
        "source_addr" => BEEM_SENDER_ID,
        "encoding" => 0,
        "message" => $message,
        "recipients" => [["recipient_id" => 1, "dest_addr" => $phone]]
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://apisms.beem.africa/v1/send");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Basic " . base64_encode(BEEM_API_KEY . ":" . BEEM_SECRET_KEY)
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response && ($httpCode == 200 || $httpCode == 201)) {
        $result = json_decode($response, true);
        if (isset($result['request_id']) || (isset($result['successful']) && $result['successful'] === true)) {
            $requestId = $result['request_id'] ?? time();
            return true;
        }
    }
    return false;
}

function checkBeemBalance() {
    global $balance_cache, $balance_cache_time;
    
    if (!SMS_ENABLED) return 'Test Mode';
    if ($balance_cache !== null && (time() - $balance_cache_time) < 600) {
        return $balance_cache;
    }
    
    $ch = curl_init("https://apisms.beem.africa/public/v1/vendors/balance");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . base64_encode(BEEM_API_KEY . ':' . BEEM_SECRET_KEY)]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $result = json_decode($response, true);
    if (isset($result['data']['credit_balance'])) {
        $balance_cache = $result['data']['credit_balance'] . ' sms';
        $balance_cache_time = time();
        return $balance_cache;
    }
    return $balance_cache ?? 'Unavailable';
}

function validatePhoneNumber($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    if (strlen($phone) == 10 && $phone[0] == '0') {
        $last = $phone[1];
        return ($last == '6' || $last == '7');
    }
    if (strlen($phone) == 9) {
        return ($phone[0] == '6' || $phone[0] == '7');
    }
    return false;
}

function formatPhoneForDisplay($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    if (strlen($phone) == 12 && substr($phone, 0, 3) == '255') return '0' . substr($phone, 3);
    if (strlen($phone) == 9) return '0' . $phone;
    if (strlen($phone) == 10 && $phone[0] == '0') return $phone;
    return $phone;
}
?>