<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

autoDeleteOldAnnouncements();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit();
}

$error = '';
$success_msg = $_SESSION['msg'] ?? '';
unset($_SESSION['msg']);

$conn = db();

$announcements = getAllAnnouncementsForRotate();
$announcements_json = json_encode($announcements);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['password'] ?? '') === 'allah99') {
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
        header("Location: index.php");
        exit();
    } else {
        $error = "❌ Nenosiri si sahihi!";
    }
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>ESTQAMA UVZ - Information System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }

        @keyframes progressShrink {
            from { width: 100%; }
            to { width: 0%; }
        }

        @keyframes starFloat {
            0%, 100% { transform: translateY(0px); opacity: 0.08; }
            50% { transform: translateY(-20px); opacity: 0.2; }
        }

        body {
            font-family: 'Segoe UI', 'Traditional Arabic', 'Georgia', serif;
            background: linear-gradient(135deg, #0a2a1f 0%, #1a4a3a 50%, #0d3325 100%);
            min-height: 100vh;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: "★ ☪ ★ ☆ ★ ☪ ★ ☆ ★ ☪ ★ ☆ ★ ☪ ★ ☆ ★ ☪ ★ ☆";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            font-size: 28px;
            color: rgba(255,215,0,0.03);
            white-space: nowrap;
            overflow: hidden;
            pointer-events: none;
            animation: starFloat 25s ease-in-out infinite;
        }

        .main-container {
            max-width: 750px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .arabic {
            font-size: 2em;
            font-family: 'Traditional Arabic', 'Amiri', serif;
            color: #ffd700;
            margin-bottom: 5px;
            text-shadow: 0 0 8px rgba(255,215,0,0.3);
        }

        .login-header h1 {
            color: white;
            font-size: 1.2em;
            font-weight: normal;
            letter-spacing: 2px;
        }

        .login-header h1 span {
            color: #ffd700;
        }

        .divider {
            text-align: center;
            color: #ffd700;
            font-size: 0.8em;
            letter-spacing: 6px;
            margin: 8px 0;
            opacity: 0.6;
        }

        /* Islamic Card Styles */
        .islamic-card {
            max-width: 650px;
            margin: 0 auto;
            background: linear-gradient(135deg, #fffef5, #ffffff);
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 25px 45px rgba(0,0,0,0.2);
            animation: fadeIn 0.5s ease-out;
            transition: all 0.3s ease;
        }

        .islamic-card.fade-out {
            animation: fadeOut 0.5s ease-out forwards;
        }

        .islamic-card-header {
            padding: 30px 20px 25px 20px;
            text-align: center;
        }

        .islamic-card-header.msiba {
            background: linear-gradient(135deg, #2d2d2d, #1a1a1a);
            color: #e0e0e0;
        }

        .islamic-card-header.harusi {
            background: linear-gradient(135deg, #ffd700, #ffb347);
            color: #1e3c32;
        }

        .islamic-card-header .card-icon {
            font-size: 56px;
            margin-bottom: 12px;
        }

        .islamic-card-header .card-title {
            font-size: 1.5em;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 8px;
        }

        .islamic-card-header .quran-verse {
            font-size: 0.95em;
            font-style: italic;
            margin: 10px 0 5px;
        }

        .islamic-card-header .card-subtitle {
            font-size: 0.75em;
            opacity: 0.85;
            letter-spacing: 1px;
        }

        .islamic-card-body {
            padding: 30px;
            background: white;
        }

        .islamic-card-body .bismillah {
            text-align: center;
            font-size: 1.4em;
            font-family: 'Traditional Arabic', 'Amiri', serif;
            color: #1e3c32;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ffd700;
        }

        .deceased-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .deceased-label {
            font-size: 0.8em;
            color: #6c757d;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .deceased-name {
            font-size: 1.2em;
            font-weight: bold;
            color: #2d2d2d;
            background: #f0f0f0;
            padding: 10px 20px;
            border-radius: 50px;
            display: inline-block;
        }

        .couple-section {
            text-align: center;
            margin-bottom: 25px;
        }

        .couple-names {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .couple-names .groom, .couple-names .bride {
            font-size: 1.1em;
            font-weight: bold;
            padding: 8px 18px;
            background: #f8f9fa;
            border-radius: 40px;
            color: #1e3c32;
        }

        .wedding-symbol {
            font-size: 1.2em;
            color: #ffd700;
        }

        .invitation-text {
            font-size: 0.85em;
            color: #555;
            line-height: 1.6;
            margin-bottom: 15px;
            text-align: center;
        }

        .details-grid {
            background: #f8f9fa;
            border-radius: 20px;
            padding: 15px;
            margin: 15px 0;
        }

        .detail-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-icon {
            font-size: 16px;
            min-width: 35px;
        }

        .detail-text {
            font-size: 13.5px;
            color: #444;
            line-height: 1.4;
        }

        .detail-text strong {
            color: #1e3c32;
        }

        .message-box {
            background: #fff3e0;
            padding: 12px 15px;
            border-radius: 16px;
            margin: 12px 0;
            font-size: 13px;
            line-height: 1.5;
            color: #333;
            border-left: 4px solid #ffd700;
        }

        .prayer-box {
            background: #e8f5e9;
            padding: 10px 15px;
            border-radius: 16px;
            margin: 15px 0;
            text-align: center;
            font-style: italic;
            color: #1e3c32;
        }

        .dua-box {
            background: #e8f5e9;
            padding: 10px;
            border-radius: 30px;
            text-align: center;
            margin: 12px 0;
            font-weight: bold;
            color: #1e3c32;
            font-size: 12px;
        }

        .dress-code {
            text-align: center;
            margin: 12px 0;
            font-size: 12px;
            color: #555;
        }

        .rsvp-box {
            text-align: center;
            background: #ffd700;
            color: #1e3c32;
            padding: 10px;
            border-radius: 40px;
            font-weight: bold;
            margin: 12px 0;
            font-size: 12px;
        }

        .invitation-footer {
            text-align: center;
            margin-top: 18px;
            padding: 10px;
            background: #f0f7f4;
            border-radius: 16px;
            font-size: 12px;
            font-weight: bold;
            color: #1e3c32;
        }

        .islamic-card-footer {
            background: #1e3c32;
            padding: 10px;
            text-align: center;
        }

        .footer-logo {
            color: #ffd700;
            font-size: 10px;
            letter-spacing: 1px;
        }

        .progress-container {
            text-align: center;
            margin: 15px 0 20px;
        }

        .progress-bar-bg {
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            height: 3px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .progress-bar-fill {
            background: #ffd700;
            height: 100%;
            width: 100%;
            border-radius: 20px;
            animation: progressShrink <?php echo ANNOUNCEMENT_ROTATE_INTERVAL; ?>s linear forwards;
        }

        .counter-text {
            color: #ffd700;
            font-size: 11px;
            letter-spacing: 1px;
        }

        .login-container {
            background: white;
            border-radius: 28px;
            padding: 5px 5px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            border: 1px solid #ffd700;
            text-align: center;
            margin-top: 15px;
            max-width: 380px;
            margin-left: auto;
            margin-right: auto;
        }

        .login-container h2 {
            color: #1e3c32;
            font-size: 1.1em;
            margin-bottom: 12px;
        }

        .input-group {
            margin-bottom: 12px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 4px;
            font-weight: 600;
            color: #1e3c32;
            font-size: 11px;
        }

        .input-group input {
            width: 100%;
            padding: 8px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 12px;
            transition: all 0.3s;
        }

        .input-group input:focus {
            outline: none;
            border-color: #ffd700;
            box-shadow: 0 0 0 3px rgba(255,215,0,0.2);
        }

        .btn-login {
            background: linear-gradient(135deg, #2a5a4a, #1e4a3a);
            color: white;
            width: 100%;
            padding: 8px;
            border: none;
            border-radius: 35px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(42,90,74,0.4);
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 6px 10px;
            border-radius: 10px;
            margin-bottom: 12px;
            font-size: 11px;
            border-left: 3px solid #dc3545;
        }

        .success-alert {
            background: #d4edda;
            color: #155724;
            padding: 6px 10px;
            border-radius: 10px;
            margin-bottom: 12px;
            font-size: 11px;
            border-left: 3px solid #28a745;
        }

        .empty-msg {
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 28px;
            color: #999;
        }

        .empty-msg .icon {
            font-size: 40px;
            margin-bottom: 12px;
        }

        .footer-text {
            text-align: center;
            margin-top: 15px;
            padding: 8px;
            font-size: 9px;
            color: rgba(255,255,255,0.5);
        }

        @media (max-width: 600px) {
            body { padding: 15px; }
            .islamic-card-header { padding: 20px 15px; }
            .islamic-card-header .card-title { font-size: 1.2em; }
            .islamic-card-header .card-icon { font-size: 42px; }
            .islamic-card-body { padding: 20px; }
            .islamic-card-body .bismillah { font-size: 1.1em; }
            .couple-names .groom, .couple-names .bride { font-size: 0.95em; padding: 5px 12px; }
            .login-container { padding: 15px; max-width: 95%; }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="login-header">
            <div class="arabic">بسم الله الرحمن الرحيم</div>
            <h1><span>★</span> TAARIFA MPYA  <span>☪</span></h1>
            <div class="divider">★ ✦ ☪ ✦ ★</div>
        </div>
        
        <div class="announcement-container" id="announcementContainer">
            <?php if (count($announcements) > 0): ?>
                <div id="announcementCard"></div>
                <div class="progress-container">
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" id="progressBar"></div>
                    </div>
                    <div class="counter-text" id="counterText">⚡ Tangazo: 1 / <?php echo count($announcements); ?> ⚡</div>
                </div>
            <?php else: ?>
                <div class="empty-msg">
                    <div class="icon">📢</div>
                    <div>★ Hakuna matangazo ya sasa ★</div>
                    <div style="font-size: 11px; margin-top: 8px;">Wasiliana na Msimamizi</div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="login-container">
            <h2>🔐 Ingia Mfumo</h2>
            
            <?php if ($success_msg): ?>
                <div class="success-alert">✓ <?php echo htmlspecialchars($success_msg); ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="input-group">
                    <label>Nenosiri</label>
                    <input type="password" name="password" placeholder="Weka nenosiri..." required autofocus>
                </div>
                <button type="submit" class="btn-login">🚪 Ingia</button>
            </form>
            
            <div class="divider" style="margin-top: 12px;">★ ☪ ★</div>
            <p style="margin-top: 8px; font-size: 9px; color: #999;">السلام عليكم ورحمة الله وبركاته</p>
            <p style="margin-top: 3px; font-size: 9px; color: #ffd700;">📱 Sender: ESTQAMA UVZ</p>
        </div>
        
        <div class="footer-text">
            ★ Hakizote zimehifadhiwa | Imeundwa na Kafunsi IT ★
        </div>
    </div>
    
    <script>
        const announcements = <?php echo $announcements_json; ?>;
        const rotateInterval = <?php echo ANNOUNCEMENT_ROTATE_INTERVAL; ?> * 1000;
        const fadeDuration = <?php echo ANNOUNCEMENT_FADE_DURATION; ?>;
        
        let currentIndex = 0;
        let intervalId = null;
        
        function formatAnnouncement(announcement) {
            if (!announcement) return '<div class="empty-msg">Hakuna tangazo</div>';
            
            const type = announcement.type;
            const message = announcement.message || '';
            const isMsiba = type === 'msiba';
            
            let deceased = '', groom = '', bride = '', date = '', location = '', time = '', dua = '', extraMsg = '', maelezo = '';
            
            const lines = message.split('\n');
            for (let line of lines) {
                line = line.trim();
                
                // MSIBA - kwa muundo mpya rahisi
                if (line.startsWith('📛')) {
                    deceased = line.replace('📛', '').replace('Jina:', '').trim();
                }
                else if (line.startsWith('📝')) {
                    maelezo = line.replace('📝', '').trim();
                }
                else if (line.startsWith('📅')) {
                    date = line.replace('📅', '').trim();
                }
                else if (line.startsWith('📍')) {
                    location = line.replace('📍', '').trim();
                }
                else if (line.startsWith('🕌')) {
                    dua = line.replace('🕌', '').trim();
                }
                // HARUSI
                else if (line.startsWith('👨‍🎓') || line.includes('Bwana harusi:')) {
                    groom = line.replace('👨‍🎓', '').replace('Bwana harusi:', '').trim();
                }
                else if (line.startsWith('👩‍🎓') || line.includes('Bibi harusi:')) {
                    bride = line.replace('👩‍🎓', '').replace('Bibi harusi:', '').trim();
                }
                else if (line.startsWith('⏰')) {
                    time = line.replace('⏰', '').trim();
                }
                else if (line.length > 15 && !line.includes('★') && !line.includes('─') && !line.includes('ESTQAMA') && !line.includes('Al-Fatiha') && !line.includes('Inna') && !line.includes('Alhamdulillah')) {
                    extraMsg = line;
                }
            }
            
            const title = isMsiba ? 'INNA LILLAHI' : 'WALIMU NA HARUSI';
            const subtitle = isMsiba ? 'WA INNA ILAYHI RAJI\'UN' : 'YOU\'RE INVITED TO CELEBRATE!';
            const icon = isMsiba ? '🌙' : '🎉';
            const footerMsg = isMsiba ? '★ Tunawakaribisha wote kwenye mazishi. Al-Fatiha! ★' : '★ Karibuni wote kwa furaha na baraka! ★';
            
            let html = `
                <div class="islamic-card ${type}" id="activeCard">
                    <div class="islamic-card-header ${type}">
                        <div class="card-icon">${icon}</div>
                        <div class="card-title">${title}</div>
                        <div class="quran-verse">${isMsiba ? '"Inna lillahi wa inna ilayhi raji\'un"' : '"Alhamdulillah!"'}</div>
                        <div class="card-subtitle">${subtitle}</div>
                    </div>
                    <div class="islamic-card-body">
                        <div class="bismillah">بسم الله الرحمن الرحيم</div>
            `;
            
            if (isMsiba) {
                html += `
                    <div class="deceased-section">
                        <div class="deceased-label">📛 MAREHEMU</div>
                        <div class="deceased-name">${deceased || 'Jina la Marehemu'}</div>
                    </div>
                `;
                if (maelezo) html += `<div class="message-box">📝 ${maelezo}</div>`;
                html += `
                    <div class="details-grid">
                        <div class="detail-row">
                            <span class="detail-icon">📅</span>
                            <span class="detail-text"><strong>Tarehe ya Mazishi:</strong> ${date || 'Tarehe haijawekwa'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-icon">📍</span>
                            <span class="detail-text"><strong>Mahali:</strong> ${location || 'Mahali haijabainishwa'}</span>
                        </div>
                `;
                if (dua) html += `
                        <div class="detail-row">
                            <span class="detail-icon">🕌</span>
                            <span class="detail-text"><strong>Mahali pa Dua:</strong> ${dua}</span>
                        </div>
                `;
                html += `</div>`;
                if (extraMsg) html += `<div class="message-box">💔 ${extraMsg}</div>`;
                html += `
                        <div class="prayer-box">
                            🕌 "Allahumma maghfirlahu warhamhu wa'afihi wa'fu anhu"
                        </div>
                        <div class="invitation-footer">${footerMsg}</div>
                `;
            } else {
                html += `
                    <div class="couple-section">
                        <div class="couple-names">
                            <div class="groom">🤵 ${groom || 'Bwana Harusi'}</div>
                            <div class="wedding-symbol">✦</div>
                            <div class="bride">👰 ${bride || 'Bibi Harusi'}</div>
                        </div>
                        <div class="invitation-text">
                            Kwa heshima kubwa, tunakuomba uwe sehemu ya furaha yetu katika sherehe ya Nikah na Walima. Uwepo wako utatuongezea baraka na furaha isiyoelezeka.
                        </div>
                    </div>
                    <div class="details-grid">
                        <div class="detail-row">
                            <span class="detail-icon">📅</span>
                            <span class="detail-text"><strong>Tarehe:</strong> ${date || 'Tarehe haijawekwa'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-icon">⏰</span>
                            <span class="detail-text"><strong>Muda:</strong> ${time || 'Saa 2 Mchana'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-icon">📍</span>
                            <span class="detail-text"><strong>Mahali:</strong> ${location || 'Ukumbi wa Upendo, Dar es Salaam'}</span>
                        </div>
                    </div>
                `;
                if (maelezo) html += `<div class="message-box">💝 ${maelezo}</div>`;
                if (extraMsg) html += `<div class="message-box">💝 ${extraMsg}</div>`;
                html += `
                    <div class="dua-box">
                        🕌 <strong>Dua is highly appreciated</strong> 🕌
                    </div>
                    <div class="dress-code">
                        👔 <strong>Dress Code:</strong> Kanzu & Gown | Semi-Formal
                    </div>
                    <div class="invitation-footer">${footerMsg}</div>
                `;
            }
            
            html += `
                    </div>
                    <div class="islamic-card-footer">
                        <span class="footer-logo">★ ESTQAMA UVZ | Kafunsi IT ★</span>
                    </div>
                </div>
            `;
            
            return html;
        }
        
        function updateAnnouncement(index) {
            const container = document.getElementById('announcementCard');
            if (!container || announcements.length === 0) return;
            
            const oldCard = document.getElementById('activeCard');
            if (oldCard) {
                oldCard.classList.add('fade-out');
                setTimeout(() => {
                    container.innerHTML = formatAnnouncement(announcements[index]);
                    updateCounter(index + 1);
                    resetProgressBar();
                }, fadeDuration);
            } else {
                container.innerHTML = formatAnnouncement(announcements[index]);
                updateCounter(index + 1);
                resetProgressBar();
            }
        }
        
        function updateCounter(current) {
            const counterEl = document.getElementById('counterText');
            if (counterEl) {
                counterEl.innerHTML = `⚡ Tangazo: ${current} / ${announcements.length} ⚡`;
            }
        }
        
        function resetProgressBar() {
            const progressBar = document.getElementById('progressBar');
            if (progressBar) {
                const newBar = progressBar.cloneNode(true);
                progressBar.parentNode.replaceChild(newBar, progressBar);
            }
        }
        
        function nextAnnouncement() {
            if (announcements.length <= 1) return;
            currentIndex = (currentIndex + 1) % announcements.length;
            updateAnnouncement(currentIndex);
        }
        
        function startAutoRotate() {
            if (announcements.length <= 1) return;
            if (intervalId) clearInterval(intervalId);
            intervalId = setInterval(nextAnnouncement, rotateInterval);
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            if (announcements.length > 0) {
                const container = document.getElementById('announcementCard');
                if (container) {
                    container.innerHTML = formatAnnouncement(announcements[0]);
                    updateCounter(1);
                }
                startAutoRotate();
            }
            console.log('★ ESTQAMA UVZ System Ready ★');
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>