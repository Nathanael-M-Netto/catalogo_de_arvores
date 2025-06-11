<?php
// --- SCRIPT PARA IMPORTAR DADOS LOCAIS PARA O BANCO DE DADOS REMOTO NA RENDER ---

echo "=====================================================\n";
echo "INICIANDO SCRIPT DE IMPORTACAO PARA A RENDER\n";
echo "=====================================================\n\n";

// !!! ATENÇÃO !!!
// ESTE ARQUIVO NÃO DEVE SER ENVIADO PARA O GITHUB COM AS CREDENCIAIS!
// Use-o apenas localmente para a importação inicial dos dados.

// --- 1. CONFIGURAÇÃO DA CONEXÃO COM O BANCO DE DADOS DA RENDER ---
// Dados da sua "External Database URL".
$host = 'dpg-d14pn1a4d50c73cjkap0-a.virginia-postgres.render.com';
$port = '5432';
$dbname = 'projeto_arvores';
$user = 'admin_catalogo';
$pass = 'ViXt3LhTAF611vmXRo0oUE0uG3lCWdoI'; // Sua senha

// --- 2. CONEXÃO COM O BANCO DE DADOS ---
try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Adiciona um timeout para conexões remotas
        PDO::ATTR_TIMEOUT => 20,
    ]);
    echo "[OK] Conexao com o banco de dados da Render bem-sucedida!\n";
} catch (PDOException $e) {
    die("[ERRO] Nao foi possivel conectar ao banco de dados da Render: " . $e->getMessage() . "\n");
}

// --- 3. LÓGICA DE IMPORTAÇÃO ---
$csvFile = __DIR__ . '/data/dados_arvore.csv';
echo "[INFO] Procurando arquivo CSV em: $csvFile\n";

if (!file_exists($csvFile)) {
    die("[ERRO] Arquivo CSV nao encontrado. Verifique o caminho.\n");
}

try {
    $count = 0;
    $startTime = microtime(true);
    echo "[INFO] Iniciando importacao dos dados...\n";

    $handle = fopen($csvFile, 'r');
    if ($handle === false) {
        throw new Exception("Nao foi possivel abrir o arquivo CSV");
    }

    // Pula a primeira linha (cabeçalho)
    fgetcsv($handle);

    $sql = "INSERT INTO arvore (
        NOME_C, NAT_EXO, HORARIO, LOCALIZACAO, VEGETACAO, ESPECIE, 
        DIAMETRO_PEITO, ESTADO_FITOSSANITARIO, ESTADO_TRONCO, ESTADO_COPA, 
        TAMANHO_CALCADA, ESPACO_ARVORE, RAIZES, ACESSIBILIDADE, CURIOSIDADE
    ) VALUES (
        :nome_c, :nat_exo, :horario, :localizacao, :vegetacao, :especie, 
        :diametro_peito, :estado_fitossanitario, :estado_tronco, :estado_copa, 
        :tamanho_calcada, :espaco_arvore, :raizes, :acessibilidade, :curiosidade
    )";

    $stmt = $pdo->prepare($sql);
    $pdo->beginTransaction();
    $batchSize = 100; // Processa em lotes de 100

    while (($data = fgetcsv($handle, 0, ",")) !== false) {
        // Validação básica da linha do CSV
        if (count($data) < 15 || empty(trim($data[3]))) {
            echo "[AVISO] Linha " . ($count + 2) . " invalida ou sem nome comum. Pulando...\n";
            continue;
        }

        $horarioStr = trim($data[0]);
        $horario = DateTime::createFromFormat('n/j/Y H:i:s', $horarioStr);
        if ($horario === false) {
            echo "[AVISO] Formato de data invalido na linha " . ($count + 2) . ": \"$horarioStr\". Pulando...\n";
            continue;
        }

        $params = [
            ':nome_c' => trim($data[3]),
            ':nat_exo' => (strtoupper(trim($data[5])) === 'NATIVA') ? 'NATIVA' : 'EXOTICA',
            ':horario' => $horario->format('Y-m-d H:i:s'),
            ':localizacao' => trim($data[1]),
            ':vegetacao' => trim($data[2]),
            ':especie' => trim($data[4]),
            ':diametro_peito' => trim($data[7]),
            ':estado_fitossanitario' => trim($data[8]),
            ':estado_tronco' => trim($data[9]),
            ':estado_copa' => trim($data[10]),
            ':tamanho_calcada' => trim($data[12]),
            ':espaco_arvore' => trim($data[13]),
            ':raizes' => trim($data[14]),
            ':acessibilidade' => 'ADEQUADO', // Valor fixo conforme script original
            ':curiosidade' => trim($data[6])
        ];

        $stmt->execute($params);
        $count++;

        if ($count % $batchSize === 0) {
            $pdo->commit();
            $pdo->beginTransaction();
            echo "[INFO] Processadas $count linhas...\n";
        }
    }

    $pdo->commit(); // Garante que o último lote seja salvo
    fclose($handle);
    $executionTime = round(microtime(true) - $startTime, 2);

    echo "\n=====================================================\n";
    echo "[SUCESSO] Importacao concluida!\n";
    echo "Total de registros inseridos: $count\n";
    echo "Tempo de execucao: $executionTime segundos\n";
    echo "=====================================================\n";

} catch (PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    die("\n[ERRO FATAL] Erro na importacao: " . $e->getMessage() . "\nLinha do CSV (aproximada): " . ($count + 2) . "\n");
} catch (Exception $e) {
    die("\n[ERRO FATAL] " . $e->getMessage() . "\n");
}
?>
