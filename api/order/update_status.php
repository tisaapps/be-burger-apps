<?php
include "../../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['order_id'];
$status = $data['status'];

$conn->query("UPDATE orders SET status='$status' WHERE id='$id'");
echo json_encode(["status"=>true,"message"=>"Order updated"]);
