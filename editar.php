<?php include("conexao.php"); ?>
<?php
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM times WHERE id=$id");
$time = $result->fetch_assoc();

if (isset($_POST['salvar'])) {
    $nome = $_POST['nome'];
    $cidade = $_POST['cidade'];
    $fundacao = $_POST['fundacao'];
    $treinador = $_POST['treinador'];

    $sql = "UPDATE times SET 
                nome='$nome',
                cidade='$cidade',
                fundacao='$fundacao',
                treinador='$treinador'
            WHERE id=$id";
    if ($conn->query($sql)) {
        header("Location: times.php");
    } else {
        echo "<p style='color:red'>Erro: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Time</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Editar Time</h1>
</header>
<div class="container">
    <form method="POST">
        <input type="text" name="nome" value="<?= $time['nome'] ?>" required>
        <input type="text" name="cidade" value="<?= $time['cidade'] ?>">
        <input type="number" name="fundacao" value="<?= $time['fundacao'] ?>" min="1800" max="2100">
        <input type="text" name="treinador" value="<?= $time['treinador'] ?>">
        <button type="submit" name="salvar">Salvar</button>
    </form>
</div>
</body>
</html>
