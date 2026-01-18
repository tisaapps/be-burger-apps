<?php
require __DIR__ . "/../../config/database.php";
require __DIR__ . "/../../utils/response.php";

/**
 * Ambil user_id dari body JSON
 * (sementara tanpa JWT)
 */
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id'])) {
    jsonResponse(["error" => "user_id wajib dikirim"], 400);
}

$userId = $data['user_id'];

/* QUERY USER */
$stmt = $pdo->prepare("
    SELECT id, name, email, phone, address, role, created_at
    FROM users
    WHERE id = ?
");

$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    jsonResponse(["error" => "User tidak ditemukan"], 404);
}

/* RESPONSE */
jsonResponse($user);
