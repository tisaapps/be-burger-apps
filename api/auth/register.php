<?php
require __DIR__ . "/../../config/database.php";
require __DIR__ . "/../../utils/response.php";

$data = json_decode(file_get_contents("php://input"), true);

if (
    !isset($data['name']) ||
    !isset($data['email']) ||
    !isset($data['password'])
) {
    jsonResponse(["error" => "Data tidak lengkap"], 400);
}

$name = $data['name'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_BCRYPT);
$phone = $data['phone'] ?? null;
$address = $data['address'] ?? null;
$role = 'user';

/* CEK EMAIL */
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->fetch()) {
    jsonResponse(["error" => "Email sudah terdaftar"], 409);
}

/* INSERT USER */
$stmt = $pdo->prepare("
    INSERT INTO users (name, email, password, phone, address, role)
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $name,
    $email,
    $password,
    $phone,
    $address,
    $role
]);

jsonResponse(["message" => "Registrasi berhasil"]);
