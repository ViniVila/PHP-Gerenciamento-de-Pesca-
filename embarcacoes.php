<?php


// Inicia a sessão para verificar se o usuário está autenticado
session_start();


// Se não houver usuário logado, redireciona para a página de login
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


// Inclui o arquivo de configuração para conexão com o banco de dados
include 'config.php';


// Verifica se o formulário de cadastro foi enviado via POST e o botão 'add' foi clicado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    // Prepara uma consulta segura para inserir uma nova embarcação, evitando SQL Injection
    // O campo pescador_id liga a embarcação ao seu pescador (um pescador tem muitas embarcações)
    $stmt = $conn->prepare(
        "INSERT INTO embarcacoes (pescador_id, modelo, marca, registro, cor, ano)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    // Liga os parâmetros enviados no formulário aos marcadores da consulta preparada
    $stmt->bind_param(
        "issssi",
        $_POST['pescador_id'],
        $_POST['modelo'],
        $_POST['marca'],
        $_POST['registro'],
        $_POST['cor'],
        $_POST['ano']
    );
    // Executa a inserção no banco
    $stmt->execute();
    // Após adicionar a embarcação, redireciona para a mesma página para atualizar a lista
    header("Location: embarcacoes.php");
    exit();
}


// Recebe o termo de busca enviado via GET, ou vazio se não houver
$busca = $_GET['busca'] ?? '';


// Protege o termo de busca contra SQL Injection antes de colocar na consulta
$termo = $conn->real_escape_string($busca);


// Monta a cláusula WHERE da consulta para filtrar embarcações pelo modelo ou registro, se houver termo de busca
$where = $busca ? "WHERE c.modelo LIKE '%$termo%' OR c.registro LIKE '%$termo%'" : '';


// Consulta SQL que une embarcações e pescador (JOIN) para mostrar o nome do pescador de cada embarcação
$query = "SELECT c.*, d.nome AS pescador_nome
          FROM embarcacoes c
          JOIN pescador d ON c.pescador_id = d.id
          $where
          ORDER BY c.modelo";


// Executa a consulta e armazena o resultado
$embarcacoes = $conn->query($query);


// Busca todos os pescadores para preencher o select do formulário de cadastro
$pescadores = $conn->query("SELECT id, nome FROM pescador ORDER BY nome");
?>
<!-- Folha de estilo padrão do sistema (todas as telas usam o mesmo arquivo css/style.css) -->
<link rel="stylesheet" href="css/style.css">


<h2>Cadastro de Embarcação</h2>


<!-- Formulário para pesquisa de embarcações -->
<form method="get">
    <input name="busca" placeholder="Buscar por modelo ou registro..." value="<?= htmlspecialchars($busca) ?>">
    <button type="submit">Buscar</button>
    <a href="principal.php">Voltar</a>
</form>


<!-- Tabela exibindo as embarcações buscadas/listadas -->
<table border="1" cellpadding="5">
    <tr><th>Modelo</th><th>Marca</th><th>Registro</th><th>Cor</th><th>Ano</th><th>Pescador</th><th>Ações</th></tr>
    <?php while($row = $embarcacoes->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['modelo']) ?></td>
        <td><?= htmlspecialchars($row['marca']) ?></td>
        <td><?= htmlspecialchars($row['registro'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['cor'] ?? '') ?></td>
       
        <td><?= htmlspecialchars($row['ano'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['pescador_nome']) ?></td>
        <td>
            <!-- Link para editar a embarcação, passando o ID via GET -->
            <a href="editar_embarcacao.php?id=<?= $row['id'] ?>">Editar</a>
            <!-- Link para deletar a embarcação, com confirmação (as pescarias dela também são apagadas) -->
            <a href="deletar_embarcacao.php?id=<?= $row['id'] ?>" onclick="return confirm('Excluir a embarcação apaga também as pescarias dela. Confirma?')">Excluir</a>
        </td>
      </tr>
    <?php endwhile; ?>
</table>


<!-- Formulário para cadastro de nova embarcação -->
<h3>Nova embarcação</h3>
<form method="post">
    <!-- Select com os pescadores cadastrados: o valor enviado é o id do pescador -->
    <select name="pescador_id" required>
        <option value="">Selecione o pescador</option>
        <?php while ($d = $pescadores->fetch_assoc()): ?>
            <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['nome']) ?></option>
        <?php endwhile; ?>
    </select>
    
    <input name="modelo" required placeholder="Modelo">
    <input name="marca" required placeholder="Marca">
    <input name="cor" placeholder="Cor">
    <input name="registro" placeholder="Registro">
    <input type="number" name="ano" required placeholder="Ano">
    <button name="add">Cadastrar</button>
</form>
