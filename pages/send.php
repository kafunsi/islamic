<div class="islamic-divider">
    <span>★</span> <span>☪</span> <span>📤</span> <span>Tuma Ujumbe</span> <span>📤</span> <span>☪</span> <span>★</span>
</div>

<div style="background:#e8f5e9; padding:12px; border-radius:12px; margin-bottom:20px;">
    <p>⭐ Salio: <strong><?php echo $beemBalance; ?></strong> | ✏️ Andika ujumbe wako mwenyewe
    <?php if(!SMS_ENABLED): ?> <span style="color:#ff9800;">⭐ TEST MODE ⭐</span> <?php endif; ?>
    </p>
</div>

<form method="POST" onsubmit="return validateForm()">
    <select name="recipient_type" id="recType" onchange="toggleDivs()" class="form-control" style="width:100%; padding:12px; margin-bottom:15px; border-radius:10px;">
        <option value="all">🌟 Waumini Wote (<?php echo $total_members; ?>)</option>
        <option value="group">📁 Kikundi</option>
        <option value="custom">✏️ Nambari Maalum</option>
    </select>
    
    <div id="groupDiv" style="display:none; margin-bottom:15px;">
        <select name="group_id" class="form-control" style="width:100%; padding:12px; border-radius:10px;">
            <option value="">-- Chagua --</option>
            <?php $grps = $conn->query("SELECT g.*, COUNT(mg.member_id) as cnt FROM groups g LEFT JOIN member_groups mg ON g.id=mg.group_id GROUP BY g.id");
            while($g = $grps->fetch_assoc()): ?>
                <option value="<?php echo $g['id']; ?>"><?php echo htmlspecialchars($g['name']); ?> (<?php echo $g['cnt']; ?>)</option>
            <?php endwhile; ?>
        </select>
    </div>
    
    <div id="customDiv" style="display:none; margin-bottom:15px;">
        <input type="tel" name="custom_phone" id="customPhone" placeholder="0712345678" style="width:100%; padding:12px; border-radius:10px;">
    </div>
    
    <div style="margin-bottom:15px;">
        <label><input type="checkbox" name="save_to_db" value="1" checked> 💾 Hifadhi kumbukumbu</label>
    </div>
    
    <div style="margin-bottom:15px;">
        <textarea name="message" id="smsMsg" required rows="6" placeholder="Andika ujumbe wako hapa..." style="width:100%; padding:12px; border-radius:10px;"></textarea>
        <div id="charCount" style="text-align:right; font-size:12px; margin-top:5px;"></div>
    </div>
    
    <button type="submit" name="send_sms" class="btn" id="sendBtn">📤 Tuma Ujumbe</button>
</form>

<script>
function toggleDivs() {
    let val = document.getElementById('recType').value;
    document.getElementById('groupDiv').style.display = val == 'group' ? 'block' : 'none';
    document.getElementById('customDiv').style.display = val == 'custom' ? 'block' : 'none';
}

function validateForm() {
    let msg = document.getElementById('smsMsg').value.trim();
    if(msg === '') { alert('★ Andika ujumbe ★'); return false; }
    let type = document.getElementById('recType').value;
    if(type === 'group') {
        let sel = document.querySelector('select[name="group_id"]');
        if(sel.value === '') { alert('★ Chagua kikundi ★'); return false; }
    }
    if(type === 'custom') {
        let phone = document.getElementById('customPhone').value.trim();
        if(phone === '') { alert('★ Weka nambari ★'); return false; }
        let clean = phone.replace(/[^0-9]/g, '');
        let valid = (clean.length === 9 && (clean[0]==='6'||clean[0]==='7')) || (clean.length===10 && clean[0]==='0' && (clean[1]==='6'||clean[1]==='7'));
        if(!valid) { alert('★ Nambari si sahihi! Mfano: 0712345678 ★'); return false; }
    }
    document.getElementById('sendBtn').disabled = true;
    document.getElementById('sendBtn').innerHTML = '⏳ Inatuma...';
    return true;
}

let ta = document.getElementById('smsMsg');
let cc = document.getElementById('charCount');
function updateCount() {
    let len = ta.value.length;
    cc.innerHTML = len <= 160 ? `★ Herufi: ${len}/160 ★` : `⚠️ Sehemu: ${Math.ceil(len/153)} ⚠️`;
}
ta.addEventListener('input', updateCount);
updateCount();
toggleDivs();
</script>