<?php
session_start();
include 'cabecalho.php';

$mensagem ="Página não disponível a visitantes";
if(isset($_SESSION['user']))$mensagem ='Até a próxima, '.$_SESSION['user'].'!';

//faz logout do utilizador
unset($_SESSION['user']);

//Apresenta a caixa com a mensagem
echo '<div class="login_sucesso">'.$mensagem.'<br><br>
<a href="index.php">Inicio</a>
</div>';

include 'rodape.php';




?>