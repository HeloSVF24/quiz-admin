<?php
$host = "127.0.0.1";
$user = "root";
$password = "";
$dbname = "quiz_db";
$port = 3307; // Definindo a porta correta informada no seu XAMPP

try {
    $conn = new mysqli($host, $user, $password, $dbname, $port);
} catch (Exception $e) {
    die("Erro ao conectar ao banco de dados MySQL: " . $e->getMessage());
}
?>
