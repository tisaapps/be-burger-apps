<?php
require __DIR__ . "/../../config/database.php";
require __DIR__ . "/../../utils/response.php";

/**
 * GET MENU LIST
 * URL:
 * http://localhost/burger_apps/api/menu/list.php
 */

$stmt = $pdo->query("
    SELECT 
        id,
        name,
        description,
        price,
        image_url
    FROM menu
    WHERE is_available = 1
    ORDER BY id DESC
");

$menu = $stmt->fetchAll();

jsonResponse($menu);
