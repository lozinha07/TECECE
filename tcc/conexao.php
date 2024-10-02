<?php
// conexão.php

$host = 'localhost';
$usuario = 'root';  
$senha = '';         
$bd = 'tcc';         

$conn = new mysqli($host, $usuario, $senha, $bd);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");


?>
