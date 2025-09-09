<?php include("conexao.php"); ?>
<?php
$id = $_GET['id'];
$conn->query("DELETE FROM times WHERE id=$id");
header("Location: times.php");
?>
