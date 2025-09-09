<?php include("conexao.php"); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Excluir Time</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
$id = $_GET['id'];
$conn->query("DELETE FROM times WHERE id=$id");
header("Location: times.php");
?>
</body>
</html>
