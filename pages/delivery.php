<?php
// Delivery reports page
?>

<div class="islamic-divider">
    <span>★</span> <span>☪</span> <span>📬</span> <span>Delivery Reports</span> <span>📬</span> <span>☪</span> <span>★</span>
</div>

<div style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
    <a href="?update_delivery=1" class="btn">🔄 Sasisha Delivery Status Zote</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Tarehe</th>
                <th>Nambari</th>
                <th>Jina</th>
                <th>Ujumbe</th>
                <th>Hali ya Kutuma</th>
                <th>Hali ya Uwasilishaji</th>
                <th>Kitendo</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $history = $conn->query("SELECT * FROM sms_history ORDER BY sent_at DESC LIMIT 100");
            if($history->num_rows > 0):
                while($h = $history->fetch_assoc()): ?>
                <tr>
                    <td><?php echo date('d/m/Y H:i', strtotime($h['sent_at'])); ?></td>
                    <td><?php echo formatPhoneForDisplay($h['phone']); ?></td>
                    <td><?php echo htmlspecialchars($h['name'] ?: '-'); ?></td>
                    <td style="max-width: 200px; word-break: break-word;"><?php echo htmlspecialchars(substr($h['message'], 0, 35)); ?>...</td>
                    <td><span class="badge badge-<?php echo $h['status']=='sent'?'success':'danger'; ?>"><?php echo $h['status']=='sent'?'✓ Imeenda':'✗ Imeshindwa'; ?></span></strong></strong></td>
                    <td>
                        <?php 
                        if($h['delivery_status'] && $h['delivery_status'] != 'pending'):
                            $deliveryClass = 'success';
                            if($h['delivery_status'] == 'Failed') $deliveryClass = 'danger';
                            if($h['delivery_status'] == 'Pending') $deliveryClass = 'warning';
                            echo '<span class="badge badge-'.$deliveryClass.'">'.$h['delivery_status'].'</span>';
                        else:
                            echo '<span class="badge" style="background:#ffc107;">⚡ Inasubiri</span>';
                        endif;
                        ?>
                    </strong></strong></td>
                    <td>
                        <?php if($h['request_id'] && $h['request_id'] != '' && strpos($h['request_id'], 'TEST_') !== 0): ?>
                        <a href="?update_single_delivery=1&id=<?php echo $h['id']; ?>" class="btn-sm btn" style="font-size: 11px;">🔄 Sasisha</a>
                        <?php else: ?>
                        <span class="badge" style="background:#999;"><?php echo $h['request_id'] ? 'Test Mode' : 'No ID'; ?></span>
                        <?php endif; ?>
                    </strong></strong> </td>
                </tr>
            <?php endwhile; else: ?>
            <tr>
                <td colspan="7" style="text-align: center; padding: 40px;">
                    <span style="font-size: 2em;">📭</span><br>
                    ★ Hakuna historia ya ujumbe bado ★<br>
                    Tumia "Tuma Ujumbe" kuanza
                </strong></strong></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="alert alert-info" style="margin-top: 20px;">
    <strong>ℹ️ Maelezo ya Delivery Status:</strong><br>
    <span>★</span> <strong>Delivered</strong> - Ujumbe umewasilishwa kwa mpokeaji<br>
    <span>★</span> <strong>Pending</strong> - Ujumbe bado haujawasilishwa<br>
    <span>★</span> <strong>Failed</strong> - Ujumbe umeshindwa kuwasilishwa<br>
    <span>★</span> <strong>Sent</strong> - Ujumbe umetumwa kwenye mtandao<br>
    <span>★</span> Bonyeza <strong>"Sasisha Delivery Status"</strong> kuona hali ya sasa ya ujumbe wako.
</div>