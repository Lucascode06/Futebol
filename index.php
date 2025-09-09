<?php
session_start();

// Conexão
$conn = new mysqli("localhost", "root", "root", "login_db");
if ($conn->connect_errno) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT * FROM usuario WHERE username = ? AND senha = ?");
    $stmt->bind_param("ss", $username, $senha);
    $stmt->execute();
    $result = $stmt->get_result();
    $dados = $result->fetch_assoc();
    $stmt->close();

    if ($dados) {
        $_SESSION['user_pk'] = $dados['pk'];
        $_SESSION['username'] = $dados['username'];
        header("Location: dashboard.php"); // redireciona para a página principal
        exit();
    } else {
        $erro = "Usuário ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Login</h2>

<form method="post">
    <input type="text" name="username" placeholder="Usuário" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>
    <button type="submit">Entrar</button>
</form>
</body>
</html>
