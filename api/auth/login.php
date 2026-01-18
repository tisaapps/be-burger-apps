<?php
require __DIR__ . "/../../config/database.php";
require __DIR__ . "/../../utils/response.php";

$data = json_decode(file_get_contents("php://input"), true);

if (
    !isset($data['email']) ||
    !isset($data['password'])
) {
    jsonResponse(["error" => "Email dan password wajib diisi"], 400);
}

$email = $data['email'];
$password = $data['password'];

/* AMBIL USER */
$stmt = $pdo->prepare("
    SELECT id, name, email, password, role
    FROM users
    WHERE email = ?
");
$stmt->execute([$email]);

$user = $stmt->fetch();

if (!$user) {
    jsonResponse(["error" => "Email tidak terdaftar"], 401);
}

/* CEK PASSWORD */
if (!password_verify($password, $user['password'])) {
    jsonResponse(["error" => "Password salah"], 401);
}

/* RESPONSE (TANPA JWT DULU) */
jsonResponse([
    "message" => "Login berhasil",
    "user" => [
        "id" => $user['id'],
        "name" => $user['name'],
        "email" => $user['email'],
        "role" => $user['role']
    ]
]);
