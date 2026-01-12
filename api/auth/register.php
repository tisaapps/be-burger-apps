<?php
header("Content-Type: application/json");
include "../../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['email'], $data['password'])) {
    echo json_encode(["status"=>false,"message"=>"Invalid request"]);
    exit;
}

$name = trim($data['name']);
$email = trim($data['email']);
$password = password_hash($data['password'], PASSWORD_DEFAULT);

# cek email sudah terdaftar
$check = $conn->prepare("SELECT id FROM users WHERE email=?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(["status"=>false,"message"=>"Email already registered"]);
    exit;
}

# insert user
$stmt = $conn->prepare(
    "INSERT INTO users (name,email,password) VALUES (?,?,?)"
);
$stmt->bind_param("sss", $name, $email, $password);

if ($stmt->execute()) {
    echo json_encode(["status"=>true,"message"=>"Register success"]);
} else {
    echo json_encode(["status"=>false,"message"=>"Register failed"]);
}
