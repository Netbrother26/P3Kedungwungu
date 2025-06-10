<?php
header("Content-Type: application/json");
$url = "https://script.google.com/macros/s/AKfycbxVgwRqAqmKBXnhetkZ2g3JbXofSPFy3oQxh1b9mln1OoinsUzjjoD2Fxf3F6JTKH6ZtA/exec?sheet=DataPembeli";


$data = file_get_contents($url);
if ($data === false) {
    echo json_encode(['error' => 'Gagal fetch dari Apps Script']);
} else {
    header('Content-Type: application/json');
    echo $data;
}
?>