<?php


// Inicia a sessão para acessar os dados do usuário logado
session_start();


// Verifica se o usuário está autenticado; caso contrário, redireciona para a página de login
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
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


// Inclui o arquivo de configuração para estabelecer a conexão com a base de dados
include 'config.php';


// Recebe o ID da embarcação a ser editado via parâmetro GET na URL; se não informado, assume 0
$id = $_GET['id'] ?? 0;


// Prepara e executa uma consulta para buscar os dados da embarcação com o ID informado
$sql = "SELECT * FROM embarcacoes WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$embarcacao = $res->fetch_assoc();


// Se não encontrou a embarcação, exibe mensagem e termina a execução
if (!$embarcacao) {
    echo "Embarcação não encontrada.";
    exit();
}


// Processa o formulário quando enviado via POST para atualizar a embarcação
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados atualizados do formulário
    $pescador_id = $_POST['pescador_id'];
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $registro = $_POST['registro'];
    $cor = $_POST['cor'];
    $ano = $_POST['ano'];


    // Validação simples: pescador, modelo e marca são obrigatórios
    if (!$pescador_id || !$modelo || !$marca) {
        echo "Pescador, modelo e marca são obrigatórios.";
    } else {
        // Atualiza os dados da embarcação no banco de dados
        $sql = "UPDATE embarcacoes SET pescador_id=?, modelo=?, marca=?, registro=?, cor=?, ano=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssii", $pescador_id, $modelo, $marca, $registro, $cor, $ano, $id);
        $stmt->execute();


        // Redireciona o usuário de volta para a lista de embarcações após atualizar
        
        header("Location: embarcacoes.php");
        exit();
    }
}


// Busca todos os pescadores para preencher o select (permite trocar o pescador da embarcação)
$pescadores = $conn->query("SELECT id, nome FROM pescador ORDER BY nome");
?>
<!-- Folha de estilo padrão do sistema (todas as telas usam o mesmo arquivo css/style.css) -->
<link rel="stylesheet" href="css/style.css">


<h2>Editar Embarcação</h2>


<!-- Formulário para edição da embarcação com dados já preenchidos -->
<form method="post">
    <select name="pescador_id" required>
        <!-- Deixa selecionado o pescador atual da embarcação -->
        <?php while ($d = $pescadores->fetch_assoc()): ?>
            <option value="<?= $d['id'] ?>" <?= $d['id'] == $embarcacao['pescador_id'] ? 'selected' : '' ?>><?= htmlspecialchars($d['nome']) ?></option>
        <?php endwhile; ?>
    </select>
    <input name="modelo" placeholder="Modelo" value="<?= htmlspecialchars($embarcacao['modelo']) ?>" required>
    <input name="marca" placeholder="Marca" value="<?= htmlspecialchars($embarcacao['marca']) ?>" required>
    <input name="registro" placeholder="Registro" value="<?= htmlspecialchars($embarcacao['registro'] ?? '') ?>">
    <input name="cor" placeholder="Cor" value="<?= htmlspecialchars($embarcacao['cor'] ?? '') ?>">
    <input type="number" name="ano" required placeholder="Ano" value="<?= htmlspecialchars($embarcacao['ano'] ?? '') ?>">
    <button>Salvar</button>
</form>


<!-- Link para voltar à página de listagem de embarcações -->
<a href="embarcacoes.php">Voltar</a>






