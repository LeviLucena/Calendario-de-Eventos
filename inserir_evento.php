<?php
//======================================================================
// Desenvolvido por Levi Lucena - linkedin.com/in/levilucena 
//======================================================================

// Obtenha os valores do novo evento enviados via POST
$newEventTitle = $_POST['title'];
$newEventTeam = $_POST['team'];
$newEventStart = $_POST['start'];
$newEventEnd = $_POST['end'];
$newEventDescription = $_POST['description'];
$newEventColor = $_POST['color'];

// Estabeleça a conexão com o banco de dados
$dbHost = 'localhost';
$dbName = 'calendario'; // Nome do banco de dados
$dbUser = ''; // Usuário do banco de dados
$dbPass = ''; // Senha do banco de dados

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insira o novo evento no banco de dados
    $stmt = $pdo->prepare("INSERT INTO eventos (title, start, end, description, team, color) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$newEventTitle, $newEventStart, $newEventEnd, $newEventDescription, $newEventTeam, $newEventColor]);

    // Obtenha o ID do evento recém-inserido
    $eventId = $pdo->lastInsertId();

    // Retorne o ID do evento para o JavaScript
    echo $eventId;
} catch (PDOException $e) {
    echo "Erro ao inserir o evento no banco de dados: " . $e->getMessage();
}
?>
