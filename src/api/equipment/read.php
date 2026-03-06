<?php
/**
 * Read Equipment API
 * GET: ดึงรายการอุปกรณ์ทั้งหมด
 * Response: JSON { success, data[] }
 */
require_once __DIR__ . '/../../config/db.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบก่อน']);
    exit;
}

try {
    $stmt = $conn->query("SELECT * FROM equipment ORDER BY id DESC");
    $data = $stmt->fetchAll();
    echo json_encode(['success' => true, 'data' => $data]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
