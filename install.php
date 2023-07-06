<?php
//criar a base de dados que suporta o site.

include 'config.php';
$ligacao = new PDO("mysql:host=$host", $user, $password);
$motor = $ligacao->prepare("CREATE DATABASE $base_dados");
$motor->execute();
echo '<p>Base de dados criadas com sucesso.</p><hr>';   

$ligacao = new PDO("mysql:dbname=$base_dados;host=$host", $user, $password);

//criação tabela utilizadores
$sql = "CREATE TABLE users(
    id_user   INT NOT NULL PRIMARY KEY,
    username  VARCHAR (30),
    pass      VARCHAR(100),
    avatar    VARCHAR(250)
    )";

$motor = $ligacao->prepare($sql);
$motor-> execute();

echo '<p>Tabela "users" criadas com sucesso.</p><hr>'; 

//criação tabela posts
$sql = "CREATE TABLE posts(
    id_post     INT NOT NULL PRIMARY KEY,
    id_user     INT NOT NULL,
    titulo      VARCHAR(100),
    mensagem    TEXT,
    data_post   DATETIME,
    FOREIGN KEY (id_user) REFERENCES Users(id_user) ON DELETE CASCADE )";
    

    $motor=$ligacao->prepare($sql);
    $motor-> execute();

    echo '<p>Tabela "post" criadas com sucesso.</p><hr>'; 
    
$ligacao =null;

?>
