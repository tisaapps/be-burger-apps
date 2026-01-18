<?php
require __DIR__ . "/../../config/database.php";
require __DIR__ . "/../../utils/response.php";

$data = json_decode(file_get_contents("php://input"), true);

if (
    !isset($data['user_id']) ||
    !isset($data['delivery_address']) ||
    !isset($data['total_price'])
) {
    jsonResponse(["error" => "Data tidak lengkap"], 400);
}

$stmt = $pdo->prepare("
    INSERT INTO orders (user_id, delivery_address, notes, total_price)
    VALUES (?, ?, ?, ?)
");

$stmt->execute([
    $data['user_id'],
    $data['delivery_address'],
    $data['notes'] ?? null,
    $data['total_price']
]);

jsonResponse(["message" => "Pesanan dibuat"]);
