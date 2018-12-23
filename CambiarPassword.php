<?php
include "configDB.php";

//Creamos la conexión
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
			<form id='fpassword' name='fpassword' action="CambiarPassword.php" method="post" enctype="multipart/form-data">
				Email: <input type="text" id="email" name="email"><br/>
				<small><input type="submit" id="actualizar" name="actualizar" value="Actualizar contraseña""></small>
			</form>

			<?php

				if (isset($_POST['email'])){

					$email = $_POST['email'];

					$mysql = mysqli_connect($server,$user,$pass,$basededatos);
					if (!$mysql){
						echo ("Fallo al conectar a MySQL: " . mysqli_connect_error());
						echo ("<br/><a href='CambiarPassword.php'> Volver a intentarlo</a>");
					}
					else{

						$sql = "SELECT * FROM usuarios WHERE email = '$email' ";

						$result = mysqli_query($mysql, $sql);

						if ($result){
							$row = mysqli_fetch_row($result);
						}
						if($row[0] == $email){
							$to = $email;
							$subject = "Recupera tu contraseña";

							$codigo = rand(10000,99999);

							session_start();

							$_SESSION['code'] = $codigo;
							$_SESSION['email'] = $email;

							$message = "
							<html>
							<head>
							<title>Recupera tu contraseña</title>
							</head>
							<body>
							<h3>Sigue estos pasos para recuperar tu contraseña:</h3>
							<ol>
								<li>Entra en el link proporcionado</li>
								<li>Introduce el código proporcionado y la nueva contraseña</li>
								<li>Si todo va bien la página te lo notificará y habrás cambiado tu contraseña</li>
							</ol>
							<h3>Link a la página de recuperación:</h3>
							<h2><a href='http://www.sw18g12.tech/SW_final/recuperarContrasenaCodigo.php?email=".$email."' id='layout'>Aquí</a></h2>
							<h3>Código de recuperación:</h3>
							<h2>".$codigo."</h2>
							</body>
							</html>
							";

							$headers = "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

							$headers .= 'From: <admin@ehu.es>' . "\r\n";

							mail($to,$subject,$message,$headers);

							echo "El e-mail se ha enviado correctamente.";

						}else{
							echo ("El e-mail introducido no existe");
						}
						mysqli_close($mysql);
					}
				}
			?>
		</div>
    </section>
	<footer class='main' id='f1'>
        <a href='https://github.com/elsahipatia/SW_final'>Link GITHUB</a>
	</footer>
  </div>
</body>
</html>
