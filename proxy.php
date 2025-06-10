<?php
session_start();

$url = "https://script.google.com/macros/s/AKfycbzmpwaa3O-8TV2Y3ZoqY2-VBHnBtd4ayaCKIP_QHooq63SlPK--AIfTY7kaji7ULdN9iw/exec";

$email = $_POST['email'];
$password = $_POST['password'];

$postData = http_build_query([
    'email' => $email,
    'password' => $password
]);

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => $postData
    ]
];

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$data = json_decode($result, true);

if ($data && isset($data['success']) && $data['success'] === true) {
    // Gunakan nama user dari response jika ada, jika tidak pakai email
    $username = $data['username'] ?? $email;

    $_SESSION['username'] = $username;

    // ✅ Kirim username ke JS
    echo json_encode([
        'success' => true,
        'username' => $username
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => $data['message'] ?? 'Login gagal'
    ]);
}
?>
