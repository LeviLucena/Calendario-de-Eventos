<?php
//======================================================================
// Desenvolvido por Levi Lucena - linkedin.com/in/levilucena 
//======================================================================

// Obtenha o ID do evento a ser removido enviado via POST
$eventId = $_POST['id'];

// Estabeleça a conexão com o banco de dados
$dbHost = 'localhost';
$dbName = 'calendario'; // Nome do banco de dados
$dbUser = ''; // Usuário do banco de dados
$dbPass = ''; // Senha do banco de dados

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Remova o evento do banco de dados
    $stmt = $pdo->prepare("DELETE FROM eventos WHERE id = ?");
    $stmt->execute([$eventId]);

    echo "Evento removido com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao remover o evento do banco de dados: " . $e->getMessage();
}
?>
