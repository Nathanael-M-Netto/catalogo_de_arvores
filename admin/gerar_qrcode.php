<?php
require __DIR__ . '/../src/libs/phpqrcode.php';

$arvoreId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($arvoreId > 0) {
    $url = "https://catalogo-de-arvores.onrender.com/catalogo.php?busca=#{$arvoreId}";
    
    // Adiciona o header para garantir que o navegador interprete a saída como uma imagem SVG.
    header('Content-Type: image/svg+xml');
    
    // Gera o código QR em formato SVG e o exibe diretamente na resposta.
    QRcode::svg($url);
}
// A chave '}' extra que causava o erro foi removida daqui.
