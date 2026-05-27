<?php
// Check if there's an announcement to send
if (!isset($_SESSION['temp_announcement'])) {
    // Check if using existing announcement
    if (isset($_GET['use_existing']) && is_numeric($_GET['use_existing'])) {
        $id = intval($_GET['use_existing']);
        $result = $conn->query("SELECT message, type FROM announcements WHERE id = $id");
        if ($result && $row = $result->fetch_assoc()) {
            $_SESSION['temp_announcement'] = $row['message'];
            $_SESSION['announcement_type'] = $row['type'];
        } else {
            $_SESSION['msg'] = "⚠️ Hakuna tangazo la kutuma!";
            header("Location: index.php?page=announcements");
            exit();
        }
    } else {
        $_SESSION['msg'] = "⚠️ Hakuna tangazo la kutuma! Tafadhali tangaza msiba au harusi kwanza.";
        header("Location: index.php?page=announcements");
        exit();
    }
}

$predefined_message = $_SESSION['temp_announcement'];
$type = $_SESSION['announcement_type'] ?? 'general';

// Don't clear session yet - we need it for the form
// But we'll clear after sending in send.php
?>

<div class="islamic-divider">
    <span>★</span> <span>☪</span> <span>📤</span> <span>Tuma Tangazo</span> <span>📤</span> <span>☪</span> <span>★</span>
</div>

<div style="background: <?php echo $type == 'msiba' ? '#e3f2fd' : '#fff3e0'; ?>; border-radius: 20px; padding: 20px; margin-bottom: 25px;">
    <h3 style="color: #1e3c32; margin-bottom: 10px;">
        <?php echo $type == 'msiba' ? '🌙 TANGAZO LA MSIBA' : '🎉 TANGAZO LA HARUSI'; ?>
    </h3>
    <p style="color: #666; font-size: 14px;">Ujumbe huu utaonekana kwenye ukurasa wa LOGIN na pia utatumwa kwa wapokeaji</p>
</div>

<form method="POST" action="?page=send">
    <div class="form-group">
        <label>📊 Wapokeaji</label>
        <select name="recipient_type" id="recType" onchange="toggleRecipients()">
            <option value="all">🌟 Waumini Wote (<?php echo $total_members; ?> waumini)</option>
            <option value="group">📁 Kikundi</option>
            <option value="custom">✏️ Nambari Maalum</option>
        </select>
    </div>
    
    <div id="groupDiv" class="form-group" style="display:none;">
        <label>📁 Chagua Kikundi</label>
        <select name="group_id">
            <option value="">-- Chagua Kikundi --</option>
            <?php 
            $groups = $conn->query("SELECT g.*, COUNT(mg.member_id) as member_count FROM groups g LEFT JOIN member_groups mg ON g.id=mg.group_id GROUP BY g.id");
            if($groups && $groups->num_rows > 0){
                while($g = $groups->fetch_assoc()): ?>
                <option value="<?php echo $g['id']; ?>">★ <?php echo htmlspecialchars($g['name']); ?> ★ (<?php echo $g['member_count']; ?> waumini)</option>
            <?php endwhile; } ?>
        </select>
    </div>
    
    <div id="customDiv" class="form-group" style="display:none;">
        <label>📞 Nambari ya Simu</label>
        <input type="tel" name="custom_phone" placeholder="Mfano: 0712345678">
        <small style="color: #666;">Nambari lazima iwe tarakimu 9 kuanzia 6 au 7</small>
    </div>
    
    <div class="form-group">
        <label>📝 UJUMBE (Unaweza kubadilisha kabla ya kutuma)</label>
        <textarea name="message" required rows="10" id="smsMessage" style="font-family: monospace;"><?php echo htmlspecialchars($predefined_message); ?></textarea>
        <div id="charCounter" style="text-align: right; margin-top: 5px; font-size: 12px;"></div>
    </div>
    
    <div class="form-group">
        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
            <input type="checkbox" name="save_to_db" value="1" checked style="width: 18px; height: 18px;">
            <span>💾 Hifadhi kwenye kumbukumbu</span>
        </label>
    </div>
    
    <button type="submit" name="send_sms" class="btn" id="sendBtn">
        📤 Tuma Ujumbe kwa Wapokeaji
    </button>
    
    <a href="?page=announcements" class="btn" style="background: #6c757d; text-decoration: none; margin-left: 10px;">
        ↩️ Rudi na Badilisha
    </a>
</form>

<script>
function toggleRecipients() {
    let val = document.getElementById('recType').value;
    let groupDiv = document.getElementById('groupDiv');
    let customDiv = document.getElementById('customDiv');
    if(groupDiv) groupDiv.style.display = val == 'group' ? 'block' : 'none';
    if(customDiv) customDiv.style.display = val == 'custom' ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    toggleRecipients();
    
    const textarea = document.getElementById('smsMessage');
    if(textarea){
        const counter = document.getElementById('charCounter');
        
        function updateCharCount() {
            const length = textarea.value.length;
            const remaining = 160 - length;
            if (length <= 160) {
                counter.innerHTML = `★ Herufi: ${length}/160 (zimesalia: ${remaining}) ★`;
                counter.style.color = remaining < 20 ? 'orange' : '#666';
            } else {
                const parts = Math.ceil(length / 153);
                counter.innerHTML = `⚠️ Ujumbe utagawanyika katika sehemu ${parts} (jumla: ${length}) ⚠️`;
                counter.style.color = 'red';
            }
        }
        
        textarea.addEventListener('input', updateCharCount);
        updateCharCount();
    }
});
</script>