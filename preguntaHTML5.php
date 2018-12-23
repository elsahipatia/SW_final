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
		<span class="right"><a href="layout.php">Logout</a></span>
        <span>
            <?php
            include "configDB.php";
            $link = mysqli_connect($server,$user,$pass,$basededatos);
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            $email = $_GET['email'];
            $result = mysqli_query($link,"SELECT foto FROM usuarios WHERE email = '$email'");
            while($row = mysqli_fetch_array($result))
            {
                echo '<img height="60" width="60" src="data:image/*;base64,'.base64_encode($row['foto']).' "/>';
            }
            ?>



        </span>
		<h2>Quiz: el juego de las preguntas</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
        <span><a href=<?php if (isset($_GET['email'])) { echo 'layout2.php?email='. $_GET['email'];} else echo 'layout2.php'?>>Inicio</a></span>
        <span><a href=<?php if (isset($_GET['email'])) { echo 'preguntaHTML5.php?email='.$_GET['email'];}else echo 'preguntaHTML5.php'?>>Insertar Pregunta</a></span>
        <span><a href=<?php if (isset($_GET['email'])) { echo 'creditos2.php?email='.$_GET['email'];} else echo 'creditos2.php'?>>Creditos</a></span>
        <span><a href=<?php if (isset($_GET['email'])) { echo 'verPreguntas.php?email='.$_GET['email'];}else echo 'verPreguntas.php'?>>Ver Preguntas</a></span>
        <span><a href=<?php if (isset($_GET['email'])) { echo 'obtenerDatos.php?email='.$_GET['email'];}else echo 'obtenerDatos.php'?>>Obtener Datos</a></span>
        <span><a href=<?php if (isset($_GET['email'])) { echo 'verPreguntasXML.php?email='.$_GET['email'];}else echo 'verPreguntasXML.php'?>>Ver tabla XML</a></span>
        <span><a href=<?php if (isset($_GET['email'])) { echo 'preguntas.xml?email='.$_GET['email'];}else echo 'preguntas.xml'?>>Ver tabla XSL</a></span></nav>
    <section class="main" id="s1">
    
	<div>
		<form  method='post' id='questionForm' name='questionForm' enctype="multipart/form-data" action=<?php echo 'prueba.php?email='. $_GET['email'];?> >
			<table>
				<tr>
					<td align="left">Email*: <input id="email" name="email" type="text" class="emailComplexSubj" value=<?php echo $_GET['email'];?> required placeholder="Introduce un correo de la UPV-EHU."  pattern="^[a-z]+[0-9]{3}@ikasle\.ehu\.eus$" readonly="true"></td>
				</tr>
				<tr>
					<td align="left">Enunciado de la pregunta*: <input id="question" name="question" type="text" class="response" required placeholder="Introduce una pregunta de al menos 10 carácteres." pattern="^.{10,}$"></td>
				</tr>
				<tr>
					<td align="left">Respuesta correcta*: <input id="correct" name="correct" type="text" class="response" required placeholder="Introduce una respuesta correcta."></td>
				</tr>
				<tr>
					<td align="left">Respuesta incorrecta*: <input id="incorrect1" name="incorrect1" type="text" class="response" required placeholder="Introduce la primera respuesta incorrecta."></td>
				</tr>
				<tr>
					<td align="left">Respuesta incorrecta*: <input id="incorrect2" name="incorrect2" type="text" class="response" required placeholder="Introduce la segunda respuesta incorrecta."></td>
				</tr>
				<tr>
					<td align="left">Respuesta incorrecta*: <input id="incorrect3" name="incorrect3" type="text" class="response" required placeholder="Introduce la tercera respuesta incorrecta."></td>
				</tr>
				<tr>
					<td align="left">Complejidad (0-5)*: <input id="complexity" name="complexity" type="text" class="emailComplexSubj" required placeholder="Introduce un número de 0 a 5." pattern="^[0-5]$"></td>
				</tr>
				<tr>
					<td align="left">Tema (subject)*: <input id="subject" name="subject" type="text" class="emailComplexSubj" required placeholder="Introduce un tema."></td>
				</tr>
                <tr>
                    <td align="left"><input type="file" id="examine" name="examine" ></td>
                </tr>
                <tr>
                    <td align="left"><button id="send" type="submit">Enviar solicitud</button> <button id="reset" >Borrar todo</button> </td>
                </tr>
                <tr>
                    <td><img id="image" width="200px" height="200px"/></td>
                </tr>
			</table>
			<fieldset>

			</fieldset>
		</form>
	
	</div>
    </section>


	  <footer class='main' id='f1'>
          <a href='https://github.com/elsahipatia/SW_final'>Link GITHUB</a>
	</footer>
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.readAsDataURL(input.files[0]);
            reader.onload = function(e) {
                var image = $('#image');
                image.attr('src', e.target.result);
				image.css("display","inline");
            };
        }
    }

    $("#examine").change(function() {
        readURL(this);
    });

    $("#reset").click(function(){
        $("#email").val("");
        $("#question").val("");
        $("#correct").val("");
        $("#incorrect1").val("");
        $("#incorrect2").val("");
        $("#incorrect3").val("");
        $("#complexity").val("");
        $("#subject").val("");
        $("#examine").val("");
        $("#image").css("display","none");

    });
</script>

</body>
</html>
