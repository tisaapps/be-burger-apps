<?php
require __DIR__ . "/../../config/database.php";
require __DIR__ . "/../../utils/response.php";

$data = json_decode(file_get_contents("php://input"), true);

if (
    !isset($data['order_id']) ||
    !isset($data['status'])
) {
    jsonResponse(["error" => "order_id dan status wajib dikirim"], 400);
}

/* VALIDASI STATUS */
$allowedStatus = ['pending','confirmed','preparing','delivered','cancelled'];
if (!in_array($data['status'], $allowedStatus)) {
    jsonResponse(["error" => "Status tidak valid"], 400);
}

/* UPDATE STATUS */
$stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->execute([
    $data['status'],
    $data['order_id']
]);

if ($stmt->rowCount() === 0) {
    jsonResponse(["error" => "Order tidak ditemukan"], 404);
}

jsonResponse(["message" => "Status pesanan diperbarui"]);
