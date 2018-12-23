<?php
session_start();

//Creamos la conexión
include "configDB.php";
$mysql = mysqli_connect($server,$user,$pass,$basededatos);
if (!$mysql){
	die ("Fallo al conectar a MySQL: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Preguntas</title>
    <link rel='stylesheet' type='text/css' href='estilos/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='estilos/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='estilos/smartphone.css' />
  </head>
  <body>
  <div id='page-wrap'>
      <header class='main' id='h1'>
          <span class="right"><a href="registro.php">Registrarse</a></span>
          <span class="right"><a href="login.php">Login</a></span>
          <span class="right" style="display:none;"><a href="/logout">Logout</a></span>
          <h2>Quiz: el juego de las preguntas</h2>
      </header>
      <nav class='main' id='n1' role='navigation'>
          <span><a href='jugar.php'>Jugar a Quizz!</a></span>
          <span><a href='layout.php'>Inicio</a></span>
          <span><a href='creditos.html'>Creditos</a></span>
          <span><a href='CambiarPassword.php'>Recuperar contraseña</a></span>
      </nav>
    <section class="main" id="s1">
		<div>
			<form id='fpassword' name='fpassword' action="recuperarContrasenaCodigo.php" method="post" enctype="multipart/form-data">
				E-mail*:
                <input type="text" id="email" name="email" required placeholder="Introduce un correo de la UPV-EHU.">
				<br/>
				Introduce tu nueva contraseña*:
                <input type="password" id="pass1" name="pass1" required placeholder="Introduce una contrasñea de mínimo 6 caracteres alfanuméricos">
				<br/>
				Repite tu nueva contraseña*: <input type="password" id="pass2" name="pass2"><br/>
				Introduce el código de recuperación*: <input type="text" id="code" name="code"><br/>
                <input type="submit" id="enviar" name="enviar" value="Enviar solicitud">
			</form>

            <?php
            if(isset($_POST['email'])){
                $email = $_POST['email'];
                $contrasena = $_POST['pass1'];
                $contrasena2 = $_POST['pass2'];
                $codigo = $_POST['code'];
                if($email!="" && $contrasena!="" && $contrasena2!="" && $codigo!=""){
                    if($contrasena != $contrasena2){
                        echo "Las contraseñas introducidas no coinciden";
                    }else{
                        if($_SESSION['code'] == $codigo && $_SESSION['email'] == $email){
                            $contrasena = password_hash($contrasena,PASSWORD_DEFAULT);
                            $sql = "UPDATE usuarios SET password = '$contrasena' WHERE email = '$email' ";
                            if (mysqli_query($mysql, $sql)){
                                echo "Se ha actualizado la contraseña correctamente";
                                session_unset();
                            }else{
                                echo "Ha habido un error";
                            }
                        }else{
                            echo "Código o e-mail incorrecto.";
                        }
                    }
                }else{
                    echo ("El e-mail introducido no existe");
                }
                mysqli_close($mysql);
            }
            ?>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript">
        </script>
    </section>
	<footer class='main' id='f1'>
        <a href='https://github.com/elsahipatia/SW_final'>Link GITHUB</a>
	</footer>
  </div>
</body>
</html>
