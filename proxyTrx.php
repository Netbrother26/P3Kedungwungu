<?php
// Proxy khusus untuk TrxPemesanan
$url = "https://script.google.com/macros/s/AKfycbxMbTidfkhOdMWuToBOFfG5q4QM_kml8m5IAzZ-Xz-Np-4z0DKfbvJ1MoONqtJesPTKQA/exec"; // Ganti dengan URL Web App TrxPemesanan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = http_build_query($_POST);

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded",
            'method'  => 'POST',
            'content' => $postData
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if (strpos($result, '<br') !== false) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Script error: response bukan JSON"]);
        exit;
    }

    header('Content-Type: application/json');
    echo $result;
    exit;
}
?>
