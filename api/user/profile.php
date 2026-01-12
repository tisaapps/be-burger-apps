<?php
include "../../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['user_id'];

$q = $conn->query("SELECT id,name,email,phone,address,role FROM users WHERE id='$id'");
echo json_encode($q->fetch_assoc());
