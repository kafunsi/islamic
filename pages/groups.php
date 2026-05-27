<?php
// Handle Group operations
if (isset($_POST['add_group'])) {
    $stmt = $conn->prepare("INSERT INTO groups (name) VALUES (?)");
    $stmt->bind_param("s", $_POST['group_name']);
    $stmt->execute();
    $_SESSION['msg'] = "✓ Kikundi kimeongezwa!";
    header("Location: index.php?page=groups");
    exit();
}

if (isset($_GET['delete_group'])) {
    $conn->query("DELETE FROM member_groups WHERE group_id=" . intval($_GET['delete_group']));
    $stmt = $conn->prepare("DELETE FROM groups WHERE id=?");
    $stmt->bind_param("i", $_GET['delete_group']);
    $stmt->execute();
    $_SESSION['msg'] = "✓ Kikundi kimefutwa!";
    header("Location: index.php?page=groups");
    exit();
}

if (isset($_POST['save_group_members'])) {
    $group_id = intval($_POST['group_id']);
    $conn->query("DELETE FROM member_groups WHERE group_id=$group_id");
    if (!empty($_POST['members'])) {
        foreach ($_POST['members'] as $member_id) {
            $member_id = intval($member_id);
            $conn->query("INSERT INTO member_groups VALUES ($member_id, $group_id)");
        }
    }
    $_SESSION['msg'] = "✓ Waumini wameongezwa kwenye kikundi!";
    header("Location: index.php?page=groups");
    exit();
}

$manage_group = null;
if (isset($_GET['manage_group'])) {
    $manage_group = $conn->query("SELECT * FROM groups WHERE id=" . intval($_GET['manage_group']))->fetch_assoc();
}
?>

<div class="islamic-divider">
    <span>★</span> <span>☪</span> <span>📁</span> <span>Makundi</span> <span>📁</span> <span>☪</span> <span>★</span>
</div>

<button class="btn" onclick="showGroupForm()" style="margin-bottom: 20px;">➕ Ongeza Kikundi</button>

<div id="addGroupForm" style="display:none; background:#f9f9f9; padding:20px; margin-bottom:25px; border-radius:12px;">
    <h3 style="margin-bottom:15px;">➕ Ongeza Kikundi Kipya</h3>
    <form method="POST">
        <div class="form-group">
            <input type="text" name="group_name" placeholder="Jina la Kikundi (Mf: Wanawake, Wanaume, Vijana)" required style="width:100%; padding:10px;">
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" name="add_group" class="btn">💾 Hifadhi</button>
            <button type="button" class="btn-danger btn" onclick="hideGroupForm()">✖️ Ghairi</button>
        </div>
    </form>
</div>

<?php if($manage_group): ?>
<div style="background:#fff8e1; padding:20px; margin-bottom:25px; border-radius:12px;">
    <h3 style="margin-bottom:15px;">👥 Weka Waumini kwenye: <?php echo htmlspecialchars($manage_group['name']); ?></h3>
    <form method="POST">
        <input type="hidden" name="group_id" value="<?php echo $manage_group['id']; ?>">
        <div class="member-list">
            <?php 
            $current = [];
            $res = $conn->query("SELECT member_id FROM member_groups WHERE group_id=" . $manage_group['id']);
            while($r = $res->fetch_assoc()) $current[] = $r['member_id'];
            
            $all = $conn->query("SELECT * FROM members WHERE status='active' ORDER BY name");
            if($all->num_rows > 0):
                while($mem = $all->fetch_assoc()): ?>
                <div class="member-item">
                    <input type="checkbox" name="members[]" value="<?php echo $mem['id']; ?>" <?php echo in_array($mem['id'], $current) ? 'checked' : ''; ?>>
                    <span><strong>☪ <?php echo htmlspecialchars($mem['name']); ?></strong> - <?php echo $mem['phone']; ?> (<?php echo htmlspecialchars($mem['city'] ?: '-'); ?>)</span>
                </div>
                <?php endwhile;
            else: ?>
                <div style="padding: 20px; text-align: center; color: #999;">
                    ★ Hakuna waumini waliosajiliwa bado. Tafadhali ongeza waumini kwanza. ★
                </div>
            <?php endif; ?>
        </div>
        <div style="margin-top: 15px;">
            <button type="submit" name="save_group_members" class="btn">💾 Hifadhi</button>
            <a href="?page=groups" class="btn-danger btn">✖️ Ghairi</a>
        </div>
    </form>
</div>
<?php endif; ?>

<?php 
$groups = $conn->query("SELECT g.*, COUNT(mg.member_id) as member_count FROM groups g LEFT JOIN member_groups mg ON g.id=mg.group_id GROUP BY g.id ORDER BY g.name");
if($groups->num_rows > 0):
    while($g = $groups->fetch_assoc()): 
?>
<div style="background:white; padding:15px; margin-bottom:15px; border-radius:12px; border:1px solid #ddd; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
    <div>
        <h3 style="margin:0;">📁 <?php echo htmlspecialchars($g['name']); ?></h3>
        <small style="color:#666;">👥 Waumini: <?php echo $g['member_count']; ?></small>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="?page=groups&manage_group=<?php echo $g['id']; ?>" class="btn-sm btn">👥 Weka Waumini</a>
        <a href="?delete_group=<?php echo $g['id']; ?>" class="btn-sm btn-danger" onclick="return confirm('★ Tahadhari! Je, una hakika unataka kufuta kikundi <?php echo addslashes($g['name']); ?>? ★')">🗑️ Futa Kikundi</a>
    </div>
</div>
<?php 
    endwhile;
else:
?>
<div style="text-align: center; padding: 40px; color: #999;">
    <span style="font-size: 2em;">📁</span><br>
    ★ Hakuna makundi yaliyoundwa bado ★<br>
    Bonyeza "Ongeza Kikundi" kuanza
</div>
<?php endif; ?>

<script>
    function showGroupForm() { 
        document.getElementById('addGroupForm').style.display = 'block';
        document.getElementById('addGroupForm').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    function hideGroupForm() { document.getElementById('addGroupForm').style.display = 'none'; }
</script>