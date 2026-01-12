<?php
include "../../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['order_id'];

$conn->query("DELETE FROM orders WHERE id='$id'");
echo json_encode(["status"=>true,"message"=>"Order deleted"]);
