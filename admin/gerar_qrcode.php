<?php
require __DIR__ . '/../src/libs/phpqrcode.php';

$arvoreId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($arvoreId > 0) {
    $url = "https://catalogo-de-arvores.onrender.com/catalogo.php?busca=#{$arvoreId}";
    QRcode::svg($url);
}
