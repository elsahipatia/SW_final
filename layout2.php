<?php
session_start();
if (!isset($_SESSION['email']))
    header("Location: login.php");
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
      		<span class="right"><a href="logout.php">Logout</a></span>
        <span>
            <?php
            if(!isset($_SESSION['fb'])){
                echo '<img height="60" width="60" src="data:image/*;base64,'.$_SESSION['foto'].' "/>';
            }else{

                echo '<img height="60" width="60" src="fb.jpg<"/>';
            }
            ?>
        </span>
		<h2>Quiz: el juego de las preguntas</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>

        <span><a href="layout2.php">Inicio</a></span>
        <span><a href="gestionPreguntas.php">Gestionar Preguntas</a></span>
        <span><a href="creditos2.php">Creditos</a></span>
        <span><a href="obtenerDatos.php">Obtener Datos</a></span>
        <span><a href="obtenerPreguntaId.php">Ver preguntas por ID</a></span>
        <span><a href="verPreguntasXML.php">Ver tabla XML</a></span>
        <span><a href="preguntas.xml">Ver tabla XSL</a></span>
        <?php
        if($_SESSION['rol'] == 0)
            echo '<span><a href="gestionarCuentas.php">Gestionar Cuentas (admin)</a></span>';
        ?>
    </nav>

    <section class="main" id="s1">
    
	<div>
		<img id="image" src="http://britishclublaspalmas.es/wp-content/uploads/2017/01/English-Grammar-Quiz-Time.png"/>
	</div>
    </section>
	<footer class='main' id='f1'>
        <a href='https://github.com/elsahipatia/SW_final'>Link GITHUB</a>
	</footer>
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script>
      $('#logout').click(function () {
          $.get('contador.xml',function (d) {
              var usuariosOnline = $(d).find('usuariosOnline');
              usuariosOnline.text=usuariosOnline.text-1;
          })
      });
  </script>
</body>
</html>
