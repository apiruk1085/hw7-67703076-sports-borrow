<?php
/**
 * ===================================================
 * index.php - หน้า Login
 * ===================================================
 * ถ้า Login แล้ว จะ redirect ไปหน้า dashboard.php อัตโนมัติ
 */
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ | ระบบยืม-คืนอุปกรณ์กีฬา</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }

        .login-card {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-slate-900 via-slate-800 to-cyan-900 min-h-screen flex items-center justify-center p-4">

    <!-- Background Glow -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Login Card -->
    <div
        class="login-card max-w-md w-full bg-slate-800/80 backdrop-blur-xl rounded-2xl shadow-2xl shadow-cyan-500/5 p-8 border border-slate-700/50 relative z-10">

        <!-- Logo -->
        <div class="text-center mb-8">
            <div
                class="floating inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl shadow-lg shadow-cyan-500/25 mb-4">
                <i class="fas fa-basketball-ball text-3xl text-white"></i>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-wide">เข้าสู่ระบบ</h1>
            <p class="text-slate-400 mt-2 text-sm">ระบบยืม-คืนอุปกรณ์กีฬา</p>
        </div>

        <!-- Login Form -->
        <form id="loginForm" class="space-y-5">
            <div>
                <label class="block text-slate-300 text-sm font-medium mb-2" for="username">
                    <i class="fas fa-user mr-2 text-cyan-400"></i>รหัสนักศึกษา / Username
                </label>
                <input type="text" id="username" name="username"
                    class="w-full px-4 py-3 rounded-xl bg-slate-900/80 border border-slate-600 text-white placeholder-slate-500 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition-all duration-300"
                    placeholder="กรอกรหัสนักศึกษา" required>
            </div>
            <div>
                <label class="block text-slate-300 text-sm font-medium mb-2" for="password">
                    <i class="fas fa-lock mr-2 text-cyan-400"></i>รหัสผ่าน / Password
                </label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-3 rounded-xl bg-slate-900/80 border border-slate-600 text-white placeholder-slate-500 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition-all duration-300"
                    placeholder="••••••••" required>
            </div>
            <button type="submit" id="btnSubmit"
                class="w-full bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-semibold py-3.5 px-4 rounded-xl transition-all duration-300 flex justify-center items-center shadow-lg shadow-cyan-500/25 hover:shadow-cyan-500/40 hover:-translate-y-0.5 active:translate-y-0">
                <i class="fas fa-sign-in-alt mr-2"></i> เข้าสู่ระบบ
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-slate-500 text-xs">ข้อมูลทดสอบ: admin / 1234</p>
        </div>
    </div>

    <script src="assets/js/auth.js"></script>
</body>

</html>