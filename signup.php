<?php
//signup.php
session_start();
unset($_SESSION['user']);

include 'cabecalho.php';
//verificar se foram inseridos dados de utilizador

if (!isset($_POST['btn_submit'])) {
    ApresentarFormulario();
} else {
    RegistarUtilizador();
}

include 'rodape.php';

function ApresentarFormulario()
{
    //Apresentar o formulario para adicao de novo utilizador
    echo ' 
   <form class="form_signup" method="post"  action="signup.php?a=signup"  enctype="multipart/form-data"> 
     <h3>Signup</h3><hr><hr><br>

   Username:<br><input type="text size="20" 
   name="text_utilizador"><br><br>
   
   Password:<br><input type="password" size="20" 
   name="text_password_1"><br><br>
   
   Re-escrever password:<br><input type="password size="20"
   name="text_password_2"><br><br>

    Avatar:<input type="file" name="imagem_avatar">.<br><br>
    <input type="submit" name="btn_submit" value="Registar"><br><br>

    <a href="index.php">Voltar</a>

   </form>

    ';
}

function RegistarUtilizador()
{
    //executar as operacoes necessarias para o registo de um novo utilizador.
    $utilizador = $_POST['text_utilizador'];
    $password_1 = $_POST['text_password_1'];
    $password_2 = $_POST['text_password_2'];
    $avatar = $_FILES['imagem_avatar'];

    $erro = false;

    if ($utilizador == "" || $password_1 == "" || $password_2 == "") {
        echo '<div class ="erro">
    É necessário preencher todos os campos .
    </div>
    ';
        $erro = true;
    
    }else if($password_1 !=$password_2){
        echo '<div class ="erro">
        As password não coincidem.
       </div>'; 
    $erro = true;
    
}else if($avatar['name'] != "" && $avatar['type'] != "image/jpeg"){
    echo '<div class ="erro">
    Ficheiro de imagem invalido.
   </div>';
   $erro = true;
}
//verificar se existe erros
if ($erro){
    Apresentarformulario();
    include 'rodape.php';
    exit;

}
//Processamento do registo do novo utilizador
include 'config.php';
$ligacao =new PDO("mysql:dbname=$base_dados; host=$host", $user, $password);

//verificar se existe utilizador com o mesmo nome
$motor = $ligacao->prepare ("SELECT username FROM users WHERE username = ?");
$motor->bindParam(1, $utilizador,PDO::PARAM_STR );
$motor->execute();

if($motor->rowCount() !=0){
    //erro ja esta registado

    echo'<div class="erro">Já existe um membro do forum com o mesmo username.</div>';
    $ligacao =null;
    ApresentarFormulario();
    include 'rodape.php';
    exit;
}
else{
//Registo do novo utilizador
$motor=$ligacao->prepare("SELECT MAX(id_user)AS MaxId FROM users");
$motor->execute();
$id_temp=$motor->fetch(PDO::FETCH_ASSOC)['MaxId'];

if($id_temp == null)
$id_temp =1;

else
$id_temp++;
$passwordEncriptada = md5($password_1);

$sql ="INSERT INTO users VALUES(:id_user,:user, :pass, :avatar)";
$motor=$ligacao->prepare($sql);
$motor->bindParam(":id_user",$id_temp, PDO::PARAM_INT);
$motor->bindParam(":user",$utilizador, PDO::PARAM_STR);
$motor->bindParam(":pass",$passwordEncriptada, PDO::PARAM_STR);
$motor->bindParam(":avatar",$avatar['name'], PDO::PARAM_STR);
$motor->execute();
$ligacao =null;

move_uploaded_file($avatar['tmp_name'],"image/".$avatar['name']);
echo'
<div class="novo_registo_sucesso">Bem vindo ao forum,<strong>'.$utilizador.'</strong><br><br>
A partir deste momento esta em condições de fazer o seu login e participar neste comunidade online.<br><br>
<a href="index.php">Voltar ao login </a>

</div>';


}

}
