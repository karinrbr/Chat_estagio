<?php
echo '
<form class="form_login" method="POST" action="login_verificacao.php">
<h3>Login</h3><hr><br>
Para entrar no Fórum, precisa de introduzir o seu user e a password .<br>
Se não tiver uma conta de utilizador, pode criar uma 
<a href="signup.php"> nova conta de utilizador</a><br><br>

Usarname:<br><input type="text" size="20" name="text_utilizador"><br><br>
Password:<br><input type="password" size="20" name="text_password"><br><br>
<input type="submit" name="btn_submit" value="Entrar">


</form>

';

?>