<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pokemon_revisao";

$conexao = new mysqli($servername, $username, $password, $dbname);

if ($conexao->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
}
?>