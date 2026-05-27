<?php
$announcements_list = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");
?>

<div class="islamic-divider">
    <span>★</span> <span>☪</span> <span>📢</span> <span>Tangaza Msiba au Harusi</span> <span>📢</span> <span>☪</span> <span>★</span>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
    <!-- MSIBA FORM -->
    <div style="background: linear-gradient(135deg, #f5f5f5, #ececec); border-radius: 20px; padding: 25px; border: 2px solid #2a5a4a;">
        <h2 style="color: #1e3c32; text-align: center; margin-bottom: 20px;">🌙 TANGAZA MSIBA 🌙</h2>
        <form method="POST" action="index.php">
            <div class="form-group">
                <label>📛 Jina la Marehemu</label>
                <input type="text" name="jina_maiti" required placeholder="Mfano: Ali Hassan Juma">
            </div>
            <div class="form-group">
                <label>📝 Maelezo ya Marehemu</label>
                <textarea name="maelezo_msiba" rows="2" required placeholder="Mfano: Aliyefariki dunia tarehe 15/01/2024, alikuwa mjumbe wetu"></textarea>
            </div>
            <div class="form-group">
                <label>📅 Tarehe ya Mazishi</label>
                <input type="text" name="tarehe_mazishi" required placeholder="Mfano: Jumatano tarehe 15/05/2024 saa 4 asubuhi">
            </div>
            <div class="form-group">
                <label>📍 Mahali pa Mazishi</label>
                <input type="text" name="mahali_msiba" required placeholder="Mfano: Makaburi ya Kinondoni">
            </div>
            <div class="form-group">
                <label>🕌 Mahali pa Kusomea Dua</label>
                <input type="text" name="mahali_dua" placeholder="Mfano: Nyumbani kwa marehemu, Kinondoni">
            </div>
            <div class="form-group" style="background: #fff3e0; padding: 15px; border-radius: 12px;">
                <label>✏️ UJUMBE WAKO MWENYEWE (Hiari)</label>
                <textarea name="custom_message_msiba" rows="4" placeholder="Andika ujumbe wako mwenyewe hapa...\nMfano: Tunawakaribisha wote kwenye mazishi..."></textarea>
                <small>★ Ukiandika hapa, utatumwa kama ulivyo, na utaonekana kwenye ukurasa wa kuingia</small>
            </div>
            <button type="submit" name="tangaza_msiba" class="btn" style="background: #6c757d; width: 100%;">📢 Tangaza Msiba</button>
        </form>
    </div>
    
    <!-- HARUSI FORM -->
    <div style="background: linear-gradient(135deg, #fffef5, #fff9e6); border-radius: 20px; padding: 25px; border: 2px solid #ffd700;">
        <h2 style="color: #1e3c32; text-align: center; margin-bottom: 20px;">🎉 TANGAZA HARUSI 🎉</h2>
        <form method="POST" action="index.php">
            <div class="form-group">
                <label>👨‍🎓 Bwana Harusi</label>
                <input type="text" name="jina_mwanaume" required placeholder="Mfano: Hassan Ali">
            </div>
            <div class="form-group">
                <label>👩‍🎓 Bibi Harusi</label>
                <input type="text" name="jina_mwanamke" required placeholder="Mfano: Fatma Juma">
            </div>
            <div class="form-group">
                <label>📅 Tarehe ya Harusi</label>
                <input type="text" name="tarehe_harusi" required placeholder="Mfano: Jumamosi tarehe 20/01/2024">
            </div>
            <div class="form-group">
                <label>📍 Mahali pa Harusi</label>
                <input type="text" name="mahali_harusi" required placeholder="Mfano: Ukumbi wa Upendo, Dar es Salaam">
            </div>
            <div class="form-group">
                <label>⏰ Muda wa Sherehe</label>
                <input type="text" name="muda_harusi" placeholder="Mfano: Kuanzia saa 2 hadi saa 6 mchana">
            </div>
            <div class="form-group">
                <label>📝 Maelezo ya Ziada</label>
                <textarea name="maelezo_harusi" rows="2" placeholder="Mfano: Karibuni wote kwa furaha na baraka"></textarea>
            </div>
            <div class="form-group" style="background: #fff3e0; padding: 15px; border-radius: 12px;">
                <label>✏️ UJUMBE WAKO MWENYEWE (Hiari)</label>
                <textarea name="custom_message_harusi" rows="4" placeholder="Andika ujumbe wako mwenyewe hapa...\nMfano: Tunawakaribisha wote kuhudhuria harusi yetu..."></textarea>
                <small>★ Ukiandika hapa, utatumwa kama ulivyo, na utaonekana kwenye ukurasa wa kuingia</small>
            </div>
            <button type="submit" name="tangaza_harusi" class="btn" style="background: #ffd700; color: #1e3c32; width: 100%;">🎉 Tangaza Harusi</button>
        </form>
    </div>
</div>

<!-- EXISTING ANNOUNCEMENTS -->
<div class="islamic-divider" style="margin: 40px 0;">
    <span>★</span> <span>☪</span> <span>📋</span> <span>MATANGAZO YALIYOHIFADHIWA</span> <span>📋</span> <span>☪</span> <span>★</span>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr><th>#</th><th>Aina</th><th>Ujumbe</th><th>Tarehe</th><th>Kitendo</th></tr>
        </thead>
        <tbody>
            <?php if ($announcements_list && $announcements_list->num_rows > 0): ?>
                <?php $no = 1; while($row = $announcements_list->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><span style="background: <?php echo $row['type'] == 'msiba' ? '#6c757d' : '#ffd700'; ?>; color: <?php echo $row['type'] == 'msiba' ? 'white' : '#333'; ?>; padding: 5px 12px; border-radius: 20px;"><?php echo $row['type'] == 'msiba' ? '🌙 MSIBA' : '🎉 HARUSI'; ?></span></td>
                    <td><?php echo htmlspecialchars(substr($row['message'], 0, 100)); ?>...</td>
                    <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                    <td><a href="?delete_announcement=1&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Futa tangazo hili?')">🗑️ Futa</a></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align: center;">★ Hakuna matangazo yaliyohifadhiwa ★</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>