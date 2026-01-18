<?php
require __DIR__ . "/../../config/database.php";
require __DIR__ . "/../../utils/response.php";

/**
 * DELETE MENU
 * DELETE / GET
 * /api/menu/delete.php?id=1
 */

$id = $_GET['id'] ?? null;

if (!$id) {
    jsonResponse(["error" => "ID menu wajib dikirim"], 400);
}

$stmt = $pdo->prepare("DELETE FROM menu WHERE id = ?");
$stmt->execute([$id]);

jsonResponse([
    "message" => "Menu berhasil dihapus"
]);
