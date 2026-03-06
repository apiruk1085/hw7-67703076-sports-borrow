<?php
/**
 * Update Equipment API
 * POST: id, name, description, total_quantity, available_quantity
 * สถานะจะถูกคำนวณอัตโนมัติจาก available_quantity
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

$id = intval($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$total_quantity = intval($_POST['total_quantity'] ?? 0);
$available_quantity = intval($_POST['available_quantity'] ?? 0);

if ($id <= 0 || empty($name) || $total_quantity < 0) {
    echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ถูกต้อง']);
    exit;
}

// คำนวณสถานะอัตโนมัติ
if ($available_quantity <= 0) {
    $status = 'out_of_stock';
} elseif ($available_quantity <= floor($total_quantity * 0.2)) {
    $status = 'low';
} else {
    $status = 'available';
}

try {
    $stmt = $conn->prepare("UPDATE equipment SET name = ?, description = ?, total_quantity = ?, available_quantity = ?, status = ? WHERE id = ?");
    $stmt->execute([$name, $description, $total_quantity, $available_quantity, $status, $id]);
    echo json_encode(['success' => true, 'message' => 'แก้ไขอุปกรณ์สำเร็จ']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
