<?php
include "../../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data['user_id'];
$items = json_encode($data['items']);
$total = $data['total_price'];
$address = $data['delivery_address'];
$notes = $data['notes'] ?? null;

$conn->query("INSERT INTO orders (user_id,items,total_price,delivery_address,notes)
VALUES ('$user_id','$items','$total','$address','$notes')");

echo json_encode(["status"=>true,"message"=>"Order created"]);
