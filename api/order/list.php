<?php
require __DIR__ . "/../../config/database.php";
require __DIR__ . "/../../utils/response.php";

/**
 * Ambil user_id dari GET atau JSON
 */
$userId = $_GET['user_id'] ?? null;

if (!$userId) {
    $data = json_decode(file_get_contents("php://input"), true);
    $userId = $data['user_id'] ?? null;
}

if (!$userId) {
    jsonResponse(["error" => "user_id wajib dikirim"], 400);
}

/* AMBIL LIST PESANAN USER */
$stmt = $pdo->prepare("
    SELECT 
        o.id,
        o.total_price,
        o.status,
        o.delivery_address,
        o.created_at
    FROM orders o
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
");

$stmt->execute([$userId]);
$orders = $stmt->fetchAll();

/* RESPONSE */
jsonResponse([
    "total" => count($orders),
    "orders" => $orders
]);
