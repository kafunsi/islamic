<?php
// GET LIVE DATA FROM BEEM API
$liveBalance = checkBeemBalance();
$liveStats = getBeemSMSStats();
$recentSMS = getBeemRecentSMS();
?>

<div class="islamic-divider">
    <span>★</span> <span>☪</span> <span>📈</span> <span>Ripoti za Beem (Live Data)</span> <span>📈</span> <span>☪</span> <span>★</span>
</div>

<div style="background: #e8f5e9; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
    <p style="color: #1e3c32; margin: 0; font-size: 14px;">
        <span>⭐</span> <strong>Taarifa za LIVE kutoka Beem Platform</strong> 
        <span>⭐</span> Data hii inachukuliwa moja kwa moja kwenye API ya Beem
    </p>
</div>

<div class="stats" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card">
        <h3><?php echo $liveStats['total'] ?? '0'; ?></h3>
        <p>📊 Jumla ya SMS (Beem)</p>
        <small style="font-size: 10px;">Live from Beem API</small>
    </div>
    <div class="stat-card">
        <h3><?php echo $liveStats['sent'] ?? '0'; ?></h3>
        <p>✅ SMS Zilizofanikiwa</p>
        <small style="font-size: 10px;">Live from Beem API</small>
    </div>
    <div class="stat-card">
        <h3><?php echo $liveStats['failed'] ?? '0'; ?></h3>
        <p>❌ SMS Zilizofeli</p>
        <small style="font-size: 10px;">Live from Beem API</small>
    </div>
    <div class="stat-card">
        <h3><?php echo $liveStats['delivered'] ?? '0'; ?></h3>
        <p>📬 Zilizowasilishwa</p>
        <small style="font-size: 10px;">Live from Beem API</small>
    </div>
</div>

<div class="alert alert-info">
    <strong>ℹ️ Taarifa za Beem Account:</strong><br>
    <span>★</span> Salio la sasa: <strong><?php echo $liveBalance; ?></strong><br>
    <span>★</span> Data inachukuliwa moja kwa moja kutoka Beem Africa API<br>
    <span>★</span> Hakuna data inayotokana na database kwenye ripoti hizi
</div>

<div style="margin-top: 30px;">
    <h3>📋 Historia ya SMS kutoka Beem (SMS 10 za mwisho)</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tarehe</th>
                    <th>Nambari</th>
                    <th>Ujumbe</th>
                    <th>Hali</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($recentSMS)): ?>
                    <?php foreach($recentSMS as $sms): ?>
                    <tr>
                        <td><?php echo $sms['date'] ?? date('Y-m-d H:i'); ?></td>
                        <td><?php echo formatPhoneForDisplay($sms['phone'] ?? ''); ?></td>
                        <td style="max-width: 250px; word-break: break-word;"><?php echo htmlspecialchars(substr($sms['message'] ?? '', 0, 45)); ?>...</td>
                        <td>
                            <?php
                            $status = $sms['status'] ?? 'pending';
                            $badgeClass = 'warning';
                            if ($status == 'Delivered') $badgeClass = 'success';
                            if ($status == 'Sent') $badgeClass = 'info';
                            if ($status == 'Failed') $badgeClass = 'danger';
                            ?>
                            <span class="badge badge-<?php echo $badgeClass; ?>"><?php echo ucfirst($status); ?></span>
                         </strong></strong></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">★ Hakuna data ya SMS kutoka Beem kwa sasa ★</strong></strong></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 20px; padding: 15px; background: #f0f7f4; border-radius: 12px; text-align: center;">
    <p style="color: #1e3c32; font-size: 12px;">
        <span>★</span> <strong>Muhimu:</strong> Ripoti hizi zinatoka moja kwa moja kwenye API ya Beem. 
        Ikiwa data haionyeshi, hakikisha una muunganisho wa intaneti na API credentials zako ni sahihi.
        <span>★</span>
    </p>
</div>