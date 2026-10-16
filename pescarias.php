<?php


// Inicia a sessão para acessar dados do usuário logado e verificar autenticação
session_start();


// Se o usuário não estiver autenticado, redireciona para a página de login e encerra o script
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}


// Verifica o tempo de expiração da sessão: se ficou mais de 30 minutos sem usar o sistema,
// encerra a sessão e volta para o login avisando que expirou
if (time() - $_SESSION['ultimo_acesso'] > 30 * 60) {
    session_destroy();
    header('Location: login.php?expirou=1');
    exit();
}


// Ainda está no prazo: renova o horário do último acesso
$_SESSION['ultimo_acesso'] = time();


// Inclui o arquivo de configuração que contém a conexão com o banco de dados
include 'config.php';


// Inicializa variável para armazenar mensagens de alerta que poderão ser exibidas para o usuário
$alerta = '';


// Verifica se o formulário foi submetido via método POST para registrar a pescaria
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe e sanitiza os dados enviados pelo formulário
    $embarcacao_id = intval($_POST['embarcacao_id']); // Embarcação em que a pescaria foi feito
    $data = $_POST['data'];
    $descricao = $_POST['descricao'];       
    $valor = $_POST['valor'] !== '' ? $_POST['valor'] : 0;


    // Verifica se os campos obrigatórios foram preenchidos
    if (!$embarcacao_id || !$data || !$descricao) {
        $alerta = "Embarcação, data e descrição são obrigatórias.";
            } else {
        // Prepara a inserção da pescaria no banco de dados
        // O campo embarcacao_id liga a pescaria aa embarcação (uma embarcação tem muitas pescarias)
        $stmt = $conn->prepare("INSERT INTO pescarias (embarcacao_id, data, descricao, valor) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issd", $embarcacao_id, $data, $descricao, $valor);
        $stmt->execute();


        // Redireciona para o histórico para mostrar a pescaria registrado
        header('Location: historico.php');
        exit;
    }
}
// Consulta SQL para buscar todos as embarcações (com o nome do pescador) para popular o select no formulário
$sql = "SELECT c.id, c.modelo, c.registro, d.nome AS pescador_nome
        FROM embarcacoes c
        JOIN pescador d ON c.pescador_id = d.id
        ORDER BY c.modelo";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registrar Pescaria</title>
    <!-- Folha de estilo padrão do sistema (todas as telas usam o mesmo arquivo css/style.css) -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>


<h2>Registrar Pescaria na Embarcação</h2>


<!-- Exibe mensagem de alerta em destaque, caso tenha sido definida -->
<?php if ($alerta): ?>
    <div style="color: red; font-weight: bold; margin-bottom: 1em;">
        <?= htmlspecialchars($alerta) ?>
    </div>
<?php endif; ?>


<!-- Formulário de registro da pescaria -->
<form action="" method="post">
    <label for="embarcacao_id">Embarcação:</label>
    <select id="embarcacao_id" name="embarcacao_id" required>
        <!-- Preenche o select com as embarcações obtidos do banco (modelo, registro e pescador) -->
        <?php while ($row = $res->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['modelo'] . ' - ' . $row['registro'] . ' (' . $row['pescador_nome'] . ')') ?></option>
        <?php endwhile; ?>
    </select>
    <br><br>


    <label for="data">Data:</label>
    <input type="date" id="data" name="data" required>
    <br><br>


    <label for="descricao">Descrição (espécie/local):</label>
    <input type="text" id="descricao" name="descricao" required>
    <br><br>


    <label for="valor">Valor (R$):</label>
    <input type="number" step="0.01" min="0" id="valor" name="valor">
    <br><br>


    <button type="submit">Registrar</button>
</form>


<br>
<a href="principal.php">Voltar</a>


</body>
</html>

