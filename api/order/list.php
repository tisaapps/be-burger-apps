<?php
include "../../config/database.php";

$q = $conn->query("
SELECT orders.*, users.name 
FROM orders 
JOIN users ON users.id = orders.user_id
ORDER BY orders.created_at DESC
");

$data = [];
while ($row = $q->fetch_assoc()) {
    $row['items'] = json_decode($row['items'], true);
    $data[] = $row;
}
echo json_encode($data);
