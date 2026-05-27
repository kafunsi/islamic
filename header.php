<?php
// Session already started in config.php, no need to start again
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Islamic SMS - Ujumbe wa Dini ya Uislamu</title>
    <style>
        /* CSS styles same as before - keeping all Islamic styling */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        @keyframes glow {
            0% { text-shadow: 0 0 5px #ffd700, 0 0 10px #ffd700; }
            50% { text-shadow: 0 0 20px #ffd700, 0 0 30px #ffa500; }
            100% { text-shadow: 0 0 5px #ffd700, 0 0 10px #ffd700; }
        }
        
        @keyframes starTwinkle {
            0% { opacity: 0.3; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1.2); }
            100% { opacity: 0.3; transform: scale(0.8); }
        }
        
        @keyframes crescentRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes borderPulse {
            0% { border-color: #2a5a4a; box-shadow: 0 0 0 0 rgba(42, 90, 74, 0.4); }
            50% { border-color: #ffd700; box-shadow: 0 0 20px 5px rgba(255, 215, 0, 0.3); }
            100% { border-color: #2a5a4a; box-shadow: 0 0 0 0 rgba(42, 90, 74, 0.4); }
        }
        
        body { 
            font-family: 'Segoe UI', 'Traditional Arabic', Tahoma, sans-serif; 
            background: linear-gradient(135deg, #0a2a1f 0%, #1a4a3a 50%, #0d3325 100%);
            position: relative;
            min-height: 100vh;
        }
        
        /* Islamic Stars Background */
        body::before {
            content: "★ ☆ ★ ☆ ★ ☆ ★ ☆ ★ ☆ ★ ☆ ★ ☆ ★ ☆ ★ ☆ ★ ☆";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            font-size: 30px;
            color: rgba(255, 215, 0, 0.08);
            white-space: nowrap;
            overflow: hidden;
            pointer-events: none;
            animation: starTwinkle 3s ease-in-out infinite;
            z-index: 0;
        }
        
        /* Islamic Pattern Overlay */
        body::after {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(circle at 10% 20%, rgba(255,215,0,0.03) 1px, transparent 1px);
            background-size: 30px 30px;
            pointer-events: none;
            z-index: 0;
        }
        
        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #0d2b22 0%, #061a13 100%);
            color: white;
            position: fixed;
            height: 100%;
            padding: 20px 0;
            z-index: 1000;
            transition: all 0.3s;
            border-right: 2px solid #ffd700;
            box-shadow: 5px 0 30px rgba(0,0,0,0.3);
        }
        
        .sidebar-header {
            text-align: center;
            padding: 20px;
            border-bottom: 2px solid #ffd700;
            margin-bottom: 20px;
            position: relative;
        }
        
        .sidebar-header h2 {
            font-size: 1.5em;
            margin-bottom: 8px;
            animation: glow 2s ease-in-out infinite;
        }
        
        .sidebar-header .arabic {
            font-size: 1.8em;
            font-family: 'Traditional Arabic', 'Amiri', serif;
            color: #ffd700;
            letter-spacing: 2px;
        }
        
        .sidebar-header .star {
            display: inline-block;
            animation: starTwinkle 1.5s ease-in-out infinite;
            margin: 0 5px;
        }
        
        .sidebar-header .crescent {
            display: inline-block;
            animation: crescentRotate 10s linear infinite;
            font-size: 1.3em;
        }
        
        .sidebar a {
            display: flex;
            align-items: center;
            padding: 14px 25px;
            color: #e8e8e8;
            text-decoration: none;
            transition: all 0.3s;
            gap: 12px;
            font-size: 15px;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar a::before {
            content: "★";
            position: absolute;
            left: -30px;
            color: #ffd700;
            font-size: 12px;
            transition: 0.3s;
        }
        
        .sidebar a:hover::before {
            left: 15px;
        }
        
        .sidebar a:hover, .sidebar a.active {
            background: linear-gradient(90deg, #2a5a4a, #1e4a3a);
            padding-left: 35px;
            color: #ffd700;
        }
        
        .sidebar a .icon {
            font-size: 1.3em;
            min-width: 35px;
        }
        
        /* Main Content */
        .main {
            margin-left: 280px;
            padding: 20px;
            position: relative;
            z-index: 1;
        }
        
        .header {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 15px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(255, 215, 0, 0.3);
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            transition: all 0.3s;
            animation: borderPulse 3s ease-in-out infinite;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: "☪";
            position: absolute;
            right: -20px;
            top: -20px;
            font-size: 100px;
            opacity: 0.05;
            pointer-events: none;
        }
        
        .page-title {
            padding: 20px 30px;
        }
        
        .page-title h1 { 
            color: #1e3c32; 
            font-size: 1.6em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .page-title h1::before {
            content: "☪";
            color: #ffd700;
            font-size: 1.3em;
            animation: crescentRotate 8s linear infinite;
            display: inline-block;
        }
        
        .page-title p { 
            color: #666; 
            font-size: 0.85em;
            margin-top: 5px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            background: linear-gradient(135deg, #1e3c32, #2a5a4a);
            padding: 8px 20px;
            border-radius: 40px;
            margin-right: 20px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ffd700, #ffa500);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
        }
        
        .user-info span {
            color: white;
            font-weight: bold;
        }
        
        .logout-btn {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
        }
        
        .logout-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(220,53,69,0.4);
        }
        
        .content {
            background: rgba(255, 255, 255, 0.97);
            border-radius: 20px;
            padding: 30px;
            min-height: 550px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255, 215, 0, 0.2);
            position: relative;
        }
        
        .content::before {
            content: "۞";
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: 60px;
            opacity: 0.03;
            pointer-events: none;
        }
        
        /* Islamic Card Design */
        .stat-card {
            background: linear-gradient(135deg, #1e3c32, #0d2b22);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 215, 0, 0.3);
        }
        
        .stat-card::before {
            content: "★";
            position: absolute;
            top: 10px;
            right: 10px;
            color: rgba(255, 215, 0, 0.2);
            font-size: 20px;
            animation: starTwinkle 2s infinite;
        }
        
        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            border-color: #ffd700;
        }
        
        .stat-card h3 { font-size: 2.2em; color: #ffd700; }
        
        /* Islamic Buttons */
        .btn {
            background: linear-gradient(135deg, #2a5a4a, #1e4a3a);
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: "★";
            position: absolute;
            left: -20px;
            opacity: 0;
            transition: 0.3s;
        }
        
        .btn:hover::before {
            left: 15px;
            opacity: 1;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(42, 90, 74, 0.4);
            padding-left: 35px;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #b02a37);
        }
        
        .btn-sm { padding: 5px 15px; font-size: 12px; }
        
        /* Islamic Table */
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 15px;
            overflow: hidden;
        }
        
        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        th {
            background: linear-gradient(135deg, #1e3c32, #2a5a4a);
            color: white;
            font-weight: bold;
        }
        
        th:first-child { border-radius: 10px 0 0 0; }
        th:last-child { border-radius: 0 10px 0 0; }
        
        tr:hover td {
            background: rgba(255, 215, 0, 0.05);
        }
        
        /* Islamic Badges */
        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .badge-success {
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: white;
        }
        
        .badge-danger {
            background: linear-gradient(135deg, #dc3545, #bd2130);
            color: white;
        }
        
        /* Islamic Alert */
        .alert {
            padding: 15px 20px;
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border-radius: 12px;
            margin-bottom: 20px;
            border-left: 5px solid #28a745;
            position: relative;
        }
        
        .alert::before {
            content: "☪";
            position: absolute;
            right: 15px;
            top: 10px;
            opacity: 0.3;
            font-size: 20px;
        }
        
        .alert-info {
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
            color: #0c5460;
            border-left-color: #17a2b8;
        }
        
        /* Islamic Form Elements */
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            transition: all 0.3s;
            font-size: 14px;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #ffd700;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
        }
        
        .member-list {
            max-height: 350px;
            overflow-y: auto;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            padding: 10px;
        }
        
        .member-item {
            padding: 12px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: 0.3s;
        }
        
        .member-item:hover {
            background: rgba(42, 90, 74, 0.05);
            border-radius: 10px;
        }
        
        /* Islamic Decorative Divider */
        .islamic-divider {
            text-align: center;
            margin: 25px 0;
            font-size: 1.5em;
            color: #ffd700;
            letter-spacing: 10px;
        }
        
        .islamic-divider span {
            animation: starTwinkle 2s infinite;
            display: inline-block;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .menu-toggle { 
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                background: #2a5a4a;
                color: white;
                border: none;
                padding: 10px 15px;
                border-radius: 30px;
                cursor: pointer;
                z-index: 1001;
                font-weight: bold;
            }
            .sidebar { width: 0; transform: translateX(-100%); overflow: hidden; }
            .sidebar.active { width: 280px; transform: translateX(0); }
            .main { margin-left: 0; }
            .user-info span { display: none; }
        }
        
        /* Islamic Prayer Times Widget (Optional) */
        .prayer-widget {
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 10px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 12px;
            border: 1px solid rgba(255,215,0,0.2);
        }
        
        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #1e3c32;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #ffd700;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #ffa500;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #1e3c32;
        }
        
        .table-container {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <button class="menu-toggle" onclick="toggleSidebar()">☰ Menyu</button>
    <div class="app-container">
    </body>