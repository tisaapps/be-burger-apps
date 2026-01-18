<?php
require __DIR__ . "/../../config/database.php";
require __DIR__ . "/../../utils/response.php";

/**
 * UPDATE MENU
 * PUT / POST JSON
 * {
 *   "id": 1,
 *   "name": "Spicy Burger",
 *   "description": "Burger pedas level 10",
 *   "price": 45000
 * }
 */

$data = json_decode(file_get_contents("php://input"), true);

/* VALIDASI */
if (
    !isset($data['id']) ||
    !isset($data['name']) ||
    !isset($data['description']) ||
    !isset($data['price'])
) {
    jsonResponse(["error" => "Data tidak lengkap"], 400);
}

/* UPDATE */
$stmt = $pdo->prepare("
    UPDATE menu 
    SET name = ?, description = ?, price = ?
    WHERE id = ?
");

$stmt->execute([
    $data['name'],
    $data['description'],
    $data['price'],
    $data['id']
]);

jsonResponse([
    "message" => "Menu berhasil diperbarui"
]);
