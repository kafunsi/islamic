<?php
// ===============================
// DATABASE CONFIGURATION
// ===============================
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'islamic_sms');

// ===============================
// SMS CONFIGURATION (BEEM)
// ===============================
define('SMS_ENABLED', true);

// ** BEEM API CREDENTIALS **
define('BEEM_API_KEY', '291aed49d8256b67');
define('BEEM_SECRET_KEY', 'MjMwYjAxNTljNmVmZTUwOGY2MTUyNjRlMDAyOTk1MDZhNDE0NjdiODAyYzk3NmVmNmQxY2VlNzI4YzFmN2JhMA==');

// ** SENDER ID YAKO ILIYOSAJILIWA **
define('BEEM_SENDER_ID', 'ESTQAMA UVZ');

// ===============================
// AUTO-ROTATE ANNOUNCEMENTS SETTINGS
// ===============================
define('ANNOUNCEMENT_ROTATE_INTERVAL', 12); // Sekunde kabla ya kubadilisha tangazo
define('ANNOUNCEMENT_FADE_DURATION', 500);  // Milisekunde kwa fade animation

// ===============================
// ERROR REPORTING
// ===============================
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

$conn = null;

function db() {
    global $conn;
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8mb4");
    }
    return $conn;
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Auto-delete old announcements after 3 days
function autoDeleteOldAnnouncements() {
    $conn = db();
    $conn->query("DELETE FROM announcements WHERE created_at < DATE_SUB(NOW(), INTERVAL 3 DAY)");
}
?>