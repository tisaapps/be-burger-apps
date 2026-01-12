<?php
header("Content-Type: application/json");
include "../../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email'], $data['password'])) {
    echo json_encode(["status"=>false,"message"=>"Invalid request"]);
    exit;
}

$email = $data['email'];
$password = $data['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo json_encode(["status"=>false,"message"=>"Email not registered"]);
    exit;
}

if (!password_verify($password, $user['password'])) {
    echo json_encode(["status"=>false,"message"=>"Wrong password"]);
    exit;
}

echo json_encode([
    "status" => true,
    "user_id" => $user['id'],
    "name" => $user['name'],
    "role" => $user['role']
]);
