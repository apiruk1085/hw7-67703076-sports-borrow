<?php
/**
 * ===================================================
 * Database Configuration (PDO)
 * ===================================================
 * - ใช้ PDO กับ Prepared Statements เพื่อป้องกัน SQL Injection
 * - ค่า host, dbname, username, password ตรงกับ docker-compose.yml
 * - มี Auto-Seed: ถ้าตาราง users ว่างเปล่า จะสร้าง admin อัตโนมัติ
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'db';
$dbname = 'sports_borrow_db';
$username = 'root';
$password = 'rootpassword';

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $conn = new PDO($dsn, $username, $password, $options);

    // ========== Auto-Seed: สร้าง Admin User ถ้ายังไม่มี ==========
    $count = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
    if ($count == 0) {
        $hashedPassword = password_hash('1234', PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, name, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['admin', $hashedPassword, 'ผู้ดูแลระบบ', 'admin']);

        // Seed ข้อมูลอุปกรณ์ตัวอย่าง
        $sampleData = [
            ['ลูกฟุตบอล', 'ลูกฟุตบอลมาตรฐาน FIFA ขนาด 5', 10, 10, 'available'],
            ['ลูกบาสเกตบอล', 'ลูกบาสเกตบอล Molten ขนาด 7', 8, 5, 'available'],
            ['ไม้แบดมินตัน', 'ไม้แบดมินตัน Yonex พร้อมกระเป๋า', 15, 3, 'low'],
            ['ลูกวอลเลย์บอล', 'ลูกวอลเลย์บอล Mikasa หนังแท้', 6, 0, 'out_of_stock'],
            ['ตะกร้อ', 'ลูกตะกร้อพลาสติก มาตรฐานสมาคม', 12, 12, 'available'],
        ];
        $stmtEq = $conn->prepare("INSERT INTO equipment (name, description, total_quantity, available_quantity, status) VALUES (?, ?, ?, ?, ?)");
        foreach ($sampleData as $item) {
            $stmtEq->execute($item);
        }
    }

} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['success' => false, 'message' => 'เชื่อมต่อฐานข้อมูลไม่สำเร็จ: ' . $e->getMessage()]));
}
