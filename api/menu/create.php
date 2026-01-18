<?php
require __DIR__ . "/../../config/database.php";
require __DIR__ . "/../../utils/response.php";

/**
 * CREATE MENU
 * POST JSON
 * {
 *   "name": "Spicy Burger",
 *   "description": "Burger pedas level 5",
 *   "price": 42000,
 *   "image_url": "https://img.burgerapp.com/spicy.jpg"
 * }
 */

$data = json_decode(file_get_contents("php://input"), true);

/* VALIDASI */
if (
    !isset($data['name']) ||
    !isset($data['description']) ||
    !isset($data['price'])
) {
    jsonResponse(["error" => "Data tidak lengkap"], 400);
}

/* INSERT */
$stmt = $pdo->prepare("
    INSERT INTO menu (name, description, price, image_url, is_available)
    VALUES (?, ?, ?, ?, 1)
");

$stmt->execute([
    $data['name'],
    $data['description'],
    $data['price'],
    $data['image_url'] ?? null
]);

jsonResponse([
    "message" => "Menu berhasil ditambahkan"
]);
