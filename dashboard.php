<?php include("conexao.php"); ?>

<?php
// Buscar times para o select
$times = $conn->query("SELECT id, nome FROM times ORDER BY nome ASC");

// Receber termo de busca
$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Jogadores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Cadastro de Jogadores </h1>
</header>

<div class="container">
    <!-- Formulário de cadastro -->
    <h2>Adicionar Novo Jogador</h2>
    <form method="POST" action="">
        <input type="text" name="nome" placeholder="Nome" required>
        <select name="posicao" required>
            <option value="Goleiro">Goleiro</option>
            <option value="Zagueiro">Zagueiro</option>
            <option value="Lateral">Lateral</option>
            <option value="Meia">Meia</option>
            <option value="Atacante">Atacante</option>
        </select>
        <input type="number" name="numero" placeholder="Número" min="1" max="99" required>
        <input type="number" name="gols" placeholder="Gols" value="0" min="0">
        <select name="time_id" required>
            <option value="">Selecione o time</option>
            <?php
            if ($times->num_rows > 0) {
                while($t = $times->fetch_assoc()) {
                    echo "<option value='{$t['id']}'>{$t['nome']}</option>";
                }
            }
            ?>
        </select>
        <button type="submit" name="adicionar">Adicionar</button>
    </form>

    <?php
    // Inserir jogador
    if (isset($_POST['adicionar'])) {
        $nome = $_POST['nome'];
        $posicao = $_POST['posicao'];
        $numero = $_POST['numero'];
        $gols = $_POST['gols'];
        $time_id = $_POST['time_id'];

        $sql = "INSERT INTO jogadores (nome, posicao, numero, gols, time_id) 
                VALUES ('$nome', '$posicao', $numero, $gols, $time_id)";
        if ($conn->query($sql) === TRUE) {
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<p style='color:red'>Erro: " . $conn->error . "</p>";
        }
    }

    // Listar jogadores com filtro
    $sql = "SELECT j.*, t.nome AS time_nome 
            FROM jogadores j
            JOIN times t ON j.time_id = t.id";

    if ($busca != '') {
        $sql .= " WHERE j.nome LIKE '%$busca%' 
                  OR j.posicao LIKE '%$busca%' 
                  OR t.nome LIKE '%$busca%'";
    }
    // Remover filtro de busca
    $sql .= " ORDER BY j.gols DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Nome</th><th>Posição</th><th>Número</th><th>Gols</th><th>Time</th><th>Ações</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nome']}</td>
                    <td>{$row['posicao']}</td>
                    <td>{$row['numero']}</td>
                    <td>{$row['gols']}</td>
                    <td>{$row['time_nome']}</td>
                    <td>
                        <a href='editar.php?id={$row['id']}'>Editar</a> | 
                        <a href='excluir.php?id={$row['id']}'>Excluir</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhum jogador encontrado.</p>";
    }
    ?>
</div>
</body>
</html>