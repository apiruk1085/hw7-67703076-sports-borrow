<?php
/**
 * Logout API Endpoint
 * Destroys session and returns JSON
 */
session_start();
session_unset();
session_destroy();
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['success' => true, 'message' => 'ออกจากระบบสำเร็จ']);
