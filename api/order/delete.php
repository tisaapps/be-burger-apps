<?php
require __DIR__ . "/../../config/database.php";
require __DIR__ . "/../../utils/response.php";

/* AMBIL ID ORDER */
$orderId = $_GET['id'] ?? null;

if (!$orderId) {
    jsonResponse(["error" => "id order wajib dikirim"], 400);
}

/* DELETE ORDER */
$stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
$stmt->execute([$orderId]);

if ($stmt->rowCount() === 0) {
    jsonResponse(["error" => "Pesanan tidak ditemukan"], 404);
}

jsonResponse(["message" => "Pesanan berhasil dihapus"]);
