<div class="stats" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card"><h3><?php echo $total_members; ?></h3><p>🌟 Waumini</p></div>
    <div class="stat-card"><h3><?php echo $total_sent; ?></h3><p>📨 SMS Zilizotumwa</p></div>
    <div class="stat-card"><h3><?php echo $beemBalance; ?></h3><p>💰 Salio</p></div>
</div>

<div class="islamic-divider"><span>★</span> <span>☪</span> <span>📜</span> <span>Ujumbe wa Hivi Karibuni</span> <span>📜</span> <span>☪</span> <span>★</span></div>

<div class="table-container">
    <table>
        <thead><tr><th>Tarehe</th><th>Jina</th><th>Ujumbe</th><th>Hali</th></tr></thead>
        <tbody>
            <?php 
            $history = $conn->query("SELECT * FROM sms_history ORDER BY sent_at DESC LIMIT 10");
            if($history && $history->num_rows > 0):
                while($h = $history->fetch_assoc()): ?>
                <tr>
                    <td><?php echo date('d/m/Y H:i', strtotime($h['sent_at'])); ?></td>
                    <td><?php echo htmlspecialchars($h['name']); ?></td>
                    <td><?php echo htmlspecialchars(substr($h['message'], 0, 50)); ?>...</td>
                    <td><span class="badge badge-<?php echo $h['status']=='sent'?'success':'danger'; ?>"><?php echo $h['status'] == 'sent' ? '✓ Imeenda' : '✗ Imeshindwa'; ?></span></td>
                </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="4" style="text-align: center;">★ Hakuna ujumbe ★</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div style="margin-top: 20px; text-align: center;">
    <a href="?page=send" class="btn">✉️ Tuma Ujumbe</a>
    <a href="?page=announcements" class="btn" style="background: #ff9800;">📢 Tangaza Matukio</a>
</div>