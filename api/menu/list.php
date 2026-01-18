<?php
require __DIR__ . "/../../config/database.php";
require __DIR__ . "/../../utils/response.php";

/**
 * LIST ORDER BY USER
 * POST JSON:
 * {
 *   "user_id": 1
 * }
 */

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id'])) {
    jsonResponse(["error" => "user_id wajib"], 400);
}

$stmt = $pdo->prepare("
    SELECT 
        id,
        delivery_address,
        notes,
        total_price,
        status,
        created_at
    FROM orders
    WHERE user_id = ?
    ORDER BY id DESC
");

$stmt->execute([$data['user_id']]);
$orders = $stmt->fetchAll();

jsonResponse($orders);
