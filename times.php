<?php include("conexao.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Times</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Gerenciador de Times 🏆</h1>
</header>
<div class="container">
    <h2>Cadastrar Novo Time</h2>
    <form method="POST" action="">
        <input type="text" name="nome" placeholder="Nome do Time" required>
        <input type="text" name="cidade" placeholder="Cidade">
        <input type="number" name="fundacao" placeholder="Ano de Fundação" min="1800" max="2100">
        <input type="text" name="treinador" placeholder="Treinador">
        <button type="submit" name="adicionar">Adicionar</button>
    </form>

    <?php
    // Inserir time
    if (isset($_POST['adicionar'])) {
        $nome = $_POST['nome'];
        $cidade = $_POST['cidade'];
        $fundacao = $_POST['fundacao'];
        $treinador = $_POST['treinador'];

        $sql = "INSERT INTO times (nome, cidade, fundacao, treinador)
                VALUES ('$nome', '$cidade', '$fundacao', '$treinador')";
        if ($conn->query($sql)) {
            header("Location: times.php");
        } else {
            echo "<p style='color:red'>Erro: " . $conn->error . "</p>";
        }
    }

    // Listar times
    $result = $conn->query("SELECT * FROM times ORDER BY nome ASC");
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Nome</th><th>Cidade</th><th>Fundação</th><th>Treinador</th><th>Ações</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nome']}</td>
                    <td>{$row['cidade']}</td>
                    <td>{$row['fundacao']}</td>
                    <td>{$row['treinador']}</td>
                    <td>
                        <a href='editar_time.php?id={$row['id']}'>Editar</a> | 
                        <a href='excluir_time.php?id={$row['id']}'>Excluir</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhum time cadastrado.</p>";
    }
    ?>
</div>
</body>
</html>
