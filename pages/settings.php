<?php
// Settings page
?>

<div class="islamic-divider">
    <span>★</span> <span>☪</span> <span>⚙️</span> <span>Mipangilio</span> <span>⚙️</span> <span>☪</span> <span>★</span>
</div>

<div class="alert alert-info">
    <strong>ℹ️ Taarifa za Mfumo wa Beem SMS</strong><br><br>
    <span>★</span> Toleo: <strong>3.0 (Beem Integration - Fixed)</strong><br>
    <span>★</span> Waumini: <strong><?php echo $total_members; ?></strong><br>
    <span>★</span> SMS Zilizotumwa: <strong><?php echo $total_sent; ?></strong><br>
    <span>★</span> Hali ya SMS: <strong><?php echo SMS_ENABLED ? '✅ LIVE (Beem)' : '⚠️ Testing Mode'; ?></strong><br>
    <span>★</span> Salio la Beem: <strong><?php echo $beemBalance; ?></strong>
</div>

<div style="background: #f0f7f4; padding: 20px; border-radius: 12px; margin-top: 20px;">
    <h3 style="color: #1e3c32;">📱 Mipangilio ya Beem API</h3>
    <p>Mfumo unatumia <strong>Beem Africa</strong> kwa utumaji wa SMS. Hali ya sasa: <strong><?php echo SMS_ENABLED ? 'IMEANZA' : 'IMEZIMWA'; ?></strong></p>
    <hr>
    <p><strong>API Key:</strong> <?php echo substr(BEEM_API_KEY, 0, 10); ?>...<br>
    <strong>Secret Key:</strong> <?php echo substr(BEEM_SECRET_KEY, 0, 10); ?>...<br>
    <strong>Sender ID:</strong> <?php echo BEEM_SENDER_ID; ?></p>
</div>

<div style="background: #e8f5e9; padding: 20px; border-radius: 12px; margin-top: 20px;">
    <h3 style="color: #1e3c32;">✅ Miongozo ya Namba za Simu</h3>
    <p><strong>Tanzania Phone Number Format:</strong></p>
    <ul style="margin-left: 20px; margin-top: 10px;">
        <li>Namba lazima iwe <strong>tarakimu 9</strong> kuanzia <strong>6 au 7</strong></li>
        <li>Mfano sahihi: <strong>0712345678</strong> au <strong>0612345678</strong></li>
        <li>Mfumo utabadilisha moja kwa moja kuwa: <strong>255712345678</strong> kwa ajili ya Beem API</li>
        <li>Usiweke namba za nchi nyingine au namba fupi</li>
    </ul>
</div>

<div style="background: #fff3e0; padding: 20px; border-radius: 12px; margin-top: 20px;">
    <h3 style="color: #e65100;">⚠️ Msaada wa Kutatua Matatizo</h3>
    <p>Kama SMS hazitumwi:</p>
    <ol style="margin-left: 20px; margin-top: 10px;">
        <li>Hakikisha una salio la kutosha kwenye akaunti ya Beem</li>
        <li>Angalia kuwa API key na Secret key ni sahihi</li>
        <li>Hakikisha nambari za simu ziko katika format sahihi (0712345678 au 0612345678)</li>
        <li>Angalia muunganisho wa intaneti</li>
        <li>Angalia error log katika faili ya error.log</li>
        <li>Wasiliana na Beem support kama tatizo linaendelea</li>
    </ol>
</div>