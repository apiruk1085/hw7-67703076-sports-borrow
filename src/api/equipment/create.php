<?php
/**
 * Create Equipment API
 * POST: name, description, total_quantity
 * available_quantity จะถูกตั้งค่าเท่ากับ total_quantity อัตโนมัติ
 */
require_once __DIR__ . '/../../config/db.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบก่อน']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$total_quantity = intval($_POST['total_quantity'] ?? 0);

if (empty($name) || $total_quantity <= 0) {
    echo json_encode(['success' => false, 'message' => 'กรุณากรอกชื่อและจำนวนอุปกรณ์ให้ถูกต้อง']);
    exit;
}

$status = 'available';

try {
    $stmt = $conn->prepare("INSERT INTO equipment (name, description, total_quantity, available_quantity, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $total_quantity, $total_quantity, $status]);
    echo json_encode(['success' => true, 'message' => 'เพิ่มอุปกรณ์สำเร็จ']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
