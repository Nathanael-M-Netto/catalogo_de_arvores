<?php
/**
 * Script para gerar um QR Code em SVG para uma árvore específica.
 */

// CORREÇÃO: O caminho para a biblioteca QR Code foi ajustado.
// Este caminho assume a seguinte estrutura de pastas:
// /raiz_do_projeto/
//   -> admin/ (onde este arquivo, gerar_qrcode.php, deve estar)
//   -> src/
//      -> libs/
//         -> phpqrcode.php
$qr_lib_path = __DIR__ . '/../src/libs/phpqrcode.php';

// Verifica se a biblioteca existe no caminho especificado antes de tentar incluí-la.
// Isso previne o erro fatal que estava causando a renderização da página admin no modal.
if (!file_exists($qr_lib_path)) {
    // Envia um cabeçalho de erro HTTP, que será capturado pelo JavaScript no admin.php
    header('HTTP/1.1 500 Internal Server Error');
    // Fornece uma mensagem de erro clara para depuração.
    echo "ERRO CRÍTICO: A biblioteca de QR Code (phpqrcode.php) não foi encontrada no caminho esperado. Verifique a estrutura de pastas no servidor.";
    // Mostra o caminho que falhou para facilitar a correção.
    echo "\nCaminho verificado: " . htmlspecialchars(realpath(__DIR__ . '/..')) . '/src/libs/phpqrcode.php';
    exit;
}

// Inclui a biblioteca
require $qr_lib_path;

// Obtém o ID da árvore a partir do parâmetro GET da URL (ex: gerar_qrcode.php?id=4)
$arvoreId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($arvoreId > 0) {
    // Monta a URL final que será codificada no QR Code.
    // O parâmetro 'busca' será preenchido com o ID da árvore, permitindo encontrá-la na página do catálogo.
    $url = "https://catalogo-de-arvores.onrender.com/catalogo.php?busca={$arvoreId}";
    
    // Define o cabeçalho da resposta para indicar que o conteúdo é uma imagem SVG.
    header('Content-Type: image/svg+xml');
    
    // Gera o QR Code em formato SVG e o envia diretamente para a saída (o navegador).
    QRcode::svg($url);

} else {
    // Se nenhum ID válido for fornecido na URL, retorna um erro HTTP.
    header('HTTP/1.1 400 Bad Request');
    echo "Erro: ID da árvore inválido ou não fornecido.";
    exit;
}

