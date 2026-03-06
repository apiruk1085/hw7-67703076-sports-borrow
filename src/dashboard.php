<?php
/**
 * ===================================================
 * dashboard.php - หน้าจัดการอุปกรณ์กีฬา (CRUD)
 * ===================================================
 * - ตารางแสดงอุปกรณ์ทั้งหมด
 * - ปุ่มเพิ่ม / แก้ไข / ลบ (ทำงานผ่าน AJAX + jQuery Confirm)
 * - ต้อง Login ก่อนจึงจะเข้าใช้งานได้
 */
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการอุปกรณ์กีฬา | ระบบยืม-คืนอุปกรณ์กีฬา</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        ::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 3px;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        tbody tr {
            transition: background 0.2s ease;
        }

        tbody tr:hover {
            background: rgba(6, 182, 212, 0.05) !important;
        }
    </style>
</head>

<body class="bg-slate-900 text-slate-200 min-h-screen">

    <!-- ==================== NAVBAR ==================== -->
    <nav class="bg-slate-800/90 backdrop-blur-lg border-b border-slate-700/50 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-cyan-500/20">
                        <i class="fas fa-basketball-ball text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white leading-tight">Sports Equipment</h1>
                        <p class="text-xs text-slate-400 -mt-0.5">ระบบจัดการอุปกรณ์กีฬา</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex items-center space-x-2 bg-slate-700/50 px-3 py-1.5 rounded-lg">
                        <i class="fas fa-user-circle text-cyan-400"></i>
                        <span class="text-sm text-slate-300">
                            <?= htmlspecialchars($_SESSION['name']) ?>
                        </span>
                        <span class="text-xs px-2 py-0.5 bg-cyan-500/20 text-cyan-300 rounded-full">
                            <?= htmlspecialchars($_SESSION['role']) ?>
                        </span>
                    </div>
                    <button id="btnLogout"
                        class="flex items-center space-x-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 px-3 py-2 rounded-lg transition-all duration-300 text-sm">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="hidden sm:inline">ออกจากระบบ</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- ===== Stats Cards ===== -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8 fade-in">
            <!-- Total -->
            <div
                class="stat-card bg-gradient-to-br from-slate-800 to-slate-800/50 border border-slate-700/50 rounded-xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-400 text-sm">อุปกรณ์ทั้งหมด</p>
                        <p class="text-3xl font-bold text-white mt-1" id="statTotal">0</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-box text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>
            <!-- Available -->
            <div
                class="stat-card bg-gradient-to-br from-slate-800 to-slate-800/50 border border-slate-700/50 rounded-xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-400 text-sm">พร้อมใช้งาน</p>
                        <p class="text-3xl font-bold text-emerald-400 mt-1" id="statAvailable">0</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-emerald-400 text-xl"></i>
                    </div>
                </div>
            </div>
            <!-- Low / Out -->
            <div
                class="stat-card bg-gradient-to-br from-slate-800 to-slate-800/50 border border-slate-700/50 rounded-xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-400 text-sm">หมด / ใกล้หมด</p>
                        <p class="text-3xl font-bold text-amber-400 mt-1" id="statLow">0</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-500/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-amber-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== Equipment Table Section ===== -->
        <div class="bg-slate-800/50 border border-slate-700/50 rounded-xl overflow-hidden fade-in">

            <!-- Table Header Bar -->
            <div
                class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-5 border-b border-slate-700/50 gap-3">
                <div>
                    <h2 class="text-lg font-semibold text-white">
                        <i class="fas fa-table-list mr-2 text-cyan-400"></i>รายการอุปกรณ์กีฬา
                    </h2>
                    <p class="text-slate-400 text-sm mt-0.5">จัดการข้อมูลอุปกรณ์กีฬาทั้งหมดในระบบ</p>
                </div>
                <div class="flex items-center space-x-2 w-full sm:w-auto">
                    <div class="relative flex-1 sm:flex-none">
                        <input type="text" id="searchInput" placeholder="ค้นหาอุปกรณ์..."
                            class="w-full sm:w-48 bg-slate-900/80 border border-slate-600 rounded-lg pl-9 pr-4 py-2 text-sm text-white placeholder-slate-500 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500/20 outline-none transition-all">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                    </div>
                    <button id="btnAdd"
                        class="bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 shadow-lg shadow-cyan-500/20 hover:shadow-cyan-500/30 hover:-translate-y-0.5 flex items-center space-x-2 whitespace-nowrap">
                        <i class="fas fa-plus"></i>
                        <span>เพิ่มอุปกรณ์</span>
                    </button>
                </div>
            </div>

            <!-- Data Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-900/50 text-slate-400 text-left">
                            <th class="px-5 py-3 font-medium">#</th>
                            <th class="px-5 py-3 font-medium">ชื่ออุปกรณ์</th>
                            <th class="px-5 py-3 font-medium hidden md:table-cell">รายละเอียด</th>
                            <th class="px-5 py-3 font-medium text-center">จำนวนทั้งหมด</th>
                            <th class="px-5 py-3 font-medium text-center">คงเหลือ</th>
                            <th class="px-5 py-3 font-medium text-center">สถานะ</th>
                            <th class="px-5 py-3 font-medium text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody id="equipmentTableBody">
                        <!-- ข้อมูลจะโหลดผ่าน AJAX -->
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden text-center py-16">
                <div class="w-20 h-20 bg-slate-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-inbox text-3xl text-slate-500"></i>
                </div>
                <p class="text-slate-400 font-medium">ยังไม่มีข้อมูลอุปกรณ์</p>
                <p class="text-slate-500 text-sm mt-1">คลิกปุ่ม "เพิ่มอุปกรณ์" เพื่อเริ่มต้นใช้งาน</p>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="text-center py-16">
                <i class="fas fa-spinner fa-spin text-3xl text-cyan-400 mb-3 block"></i>
                <p class="text-slate-400">กำลังโหลดข้อมูล...</p>
            </div>
        </div>
    </main>

    <script src="assets/js/main.js"></script>
</body>

</html>