<?php include("conexao.php"); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Calendário de Jogos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Calendário de Jogos 📅</h1>
</header>

<div class="container">
    <h2>Jogos Agendados</h2>
    <?php
    $result = $conn->query("
        SELECT p.*, t1.nome AS time_casa, t2.nome AS time_fora
        FROM partidas p
        JOIN times t1 ON p.time_casa = t1.id
        JOIN times t2 ON p.time_fora = t2.id
        ORDER BY p.data_partida ASC
    ");

    if($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Data/Hora</th><th>Time Casa</th><th>Time Fora</th><th>Placar</th></tr>";
        while($row = $result->fetch_assoc()) {
            $placar = $row['gols_casa'] . " x " . $row['gols_fora'];
            echo "<tr>
                    <td>".date('d/m/Y H:i', strtotime($row['data_partida']))."</td>
                    <td>{$row['time_casa']}</td>
                    <td>{$row['time_fora']}</td>
                    <td>$placar</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhum jogo agendado.</p>";
    }
    ?>
</div>
</body>
</html>
