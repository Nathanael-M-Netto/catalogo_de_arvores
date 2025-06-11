<?php
// --- INÍCIO DAS ALTERAÇÕES PARA DEPLOY ---

// 1. VERIFICAÇÃO DAS EXTENSÕES
// Mantivemos a verificação para garantir que o ambiente da Render tenha o driver pdo_pgsql.
if (!extension_loaded('pdo_pgsql')) {
    // Para o ambiente de produção, é melhor logar o erro do que exibir na tela.
    error_log('A extensão PDO PostgreSQL não está carregada no ambiente.');
    die('Ocorreu um erro de configuração no servidor.');
}
if (!extension_loaded('curl')) {
    error_log('A extensão cURL não está carregada no ambiente.');
    die('Ocorreu um erro de configuração no servidor.');
}

// 2. LEITURA DAS VARIÁVEIS DE AMBIENTE
// Em vez de valores fixos, usamos getenv() para ler as configurações fornecidas pela Render.
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

// 3. VALIDAÇÃO DAS VARIÁVEIS
// É crucial verificar se todas as variáveis foram encontradas.
if (!$host || !$port || !$dbname || !$user || !$pass) {
    error_log("Erro crítico: As variáveis de ambiente para a conexão com o banco de dados não estão configuradas.");
    die("Erro de configuração: Não foi possível conectar ao serviço de dados.");
}

// 4. CONSTRUÇÃO DA DSN E CONEXÃO PDO
// A string de conexão (DSN) é montada com os valores lidos do ambiente.
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    // Em produção, nunca exiba o erro detalhado para o usuário final.
    // Registre o erro para que o desenvolvedor possa analisá-lo.
    error_log("Erro de conexão com o banco de dados: " . $e->getMessage());
    die("Não foi possível conectar ao banco de dados. Por favor, tente novamente mais tarde.");
}

// --- FIM DAS ALTERAÇÕES ---
?>
