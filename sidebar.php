<?php
$current_page = $_GET['page'] ?? 'dashboard';
?>
<div class="sidebar">
    <div class="sidebar-header">
        <div class="arabic">بسم الله الرحمن الرحيم</div>
        <h2>
            <span class="star">★</span>
            Islamic SMS
            <span class="crescent">☪</span>
        </h2>
        <div style="font-size: 0.8em; opacity: 0.8;">Ujumbe wa Dini ya Uislamu</div>
    </div>
    
    <div class="prayer-widget">
        <span>🕌</span> Alhamdulillah
        <span>★</span>
    </div>
    
    <a href="?page=dashboard" class="<?php echo $current_page == 'dashboard' ? 'active' : ''; ?>">
        <span class="icon">📊</span>
        <span>Dashboard</span>
    </a>
    <a href="?page=send" class="<?php echo $current_page == 'send' ? 'active' : ''; ?>">
        <span class="icon">✉️</span>
        <span>Tuma Ujumbe</span>
    </a>
    <a href="?page=members" class="<?php echo $current_page == 'members' ? 'active' : ''; ?>">
        <span class="icon">👥</span>
        <span>Waumini</span>
    </a>
    <a href="?page=groups" class="<?php echo $current_page == 'groups' ? 'active' : ''; ?>">
        <span class="icon">📁</span>
        <span>Makundi</span>
    </a>
    <a href="?page=announcements" class="<?php echo $current_page == 'announcements' ? 'active' : ''; ?>">
        <span class="icon">📢</span>
        <span>Tangaza Matukio</span>
    </a>
    <a href="?page=reports" class="<?php echo $current_page == 'reports' ? 'active' : ''; ?>">
        <span class="icon">📈</span>
        <span>Ripoti</span>
    </a>
    <a href="?page=delivery" class="<?php echo $current_page == 'delivery' ? 'active' : ''; ?>">
        <span class="icon">📬</span>
        <span>Delivery Reports</span>
    </a>
    <a href="?page=settings" class="<?php echo $current_page == 'settings' ? 'active' : ''; ?>">
        <span class="icon">⚙️</span>
        <span>Mipangilio</span>
    </a>
    
    <div class="islamic-divider">
        <span>★</span> <span>☪</span> <span>★</span>
    </div>
    
    <a href="?page=logout" onclick="return confirm('★ Unataka kutoka? ★')" style="margin-top: 20px;">
        <span class="icon">🚪</span>
        <span>Toka Mfumo</span>
    </a>
</div>

<div class="main">
    <div class="header">
        <div class="page-title">
            <h1>
                <?php
                $titles = [
                    'dashboard' => 'Dashboard',
                    'send' => 'Tuma Ujumbe',
                    'members' => 'Wasimamie Waumini',
                    'groups' => 'Makundi',
                    'announcements' => 'Tangaza Matukio',
                    'reports' => 'Ripoti',
                    'delivery' => 'Delivery Reports',
                    'settings' => 'Mipangilio'
                ];
                echo $titles[$current_page] ?? 'Dashboard';
                ?>
            </h1>
            <p>
                <span>★</span> 
                السلام عليكم ورحمة الله وبركاته 
                <span>☪</span>
            </p>
        </div>
        <div class="user-info">
            <div class="user-avatar">👤</div>
            <span>Admin</span>
            <a href="?page=logout" onclick="return confirm('Toka?')" style="color: white; text-decoration: none;">
                <button class="logout-btn">Toka</button>
            </a>
        </div>
    </div>
    
    <?php if(isset($_SESSION['msg'])): ?>
        <div class="alert">
            <span>★</span> <?php echo htmlspecialchars($_SESSION['msg']); unset($_SESSION['msg']); ?>
        </div>
    <?php endif; ?>
    
    <div class="content">