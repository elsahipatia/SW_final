<?php
session_start();
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
		<span><a href='layout.php'>Inicio</a></span>
		<span><a href='creditos.html'>Creditos</a></span>
	</nav>
    <section class="main" id="s1" >
    
	<div style="font-weight: bold ; font-size: large">
        <form  method='post' id='registroForm' name='registroForm' enctype="multipart/form-data" action="registro.php" onsubmit= "return check()">
            <table id="tabla-registro">
                <tr>
                    <td align="left">Email*: <input id="email" name="email" type="text" class="login" required placeholder="Introduce un correo de la UPV-EHU."  pattern="^[a-z]+[0-9]{3}@ikasle\.ehu\.eus$"></td>
                </tr>
                <tr>
                    <td align="left">Nombre y Apellido*: <input id="nombreApellido" name="nombreApellido" type="text" class="login" required placeholder="Introduce un correo de la UPV-EHU."></td>
                </tr>
                <tr>
                    <td align="left">Contraseña*: <input id="password" name="password" type="password" class="login" required placeholder="Introduce una contrasñea de mínimo 6 caracteres alfanuméricos"  pattern="^.{6,}$"></td>
                </tr>
                <tr>
                    <td align="left">Repetir contraseña*: <input id="password2" type="password" required placeholder="Repite la contraseña anterior"></td>
                </tr>
                <tr>
                    <td align="left"><input type="file" id="fotoUsuario" name="fotoUsuario" ></td>
                </tr>
                <tr>
                    <td align="left"><input id="submit" name="submit" type="submit" class="login"></td>
                </tr>
                <tr>
                    <td><img id="imagenUsuario" width="200px" height="200px"/></td>
                </tr>
            </table>
        </form>
        <?php
            if(isset($_POST['submit'])){
                include "configDB.php";
                $link = mysqli_connect($server,$user,$pass,$basededatos);
                $email = trim($_POST['email']);
                $password = password_hash(trim($_POST['password']),PASSWORD_DEFAULT);
                $nombreApellido = trim($_POST['nombreApellido']);
                if($_FILES['fotoUsuario']['tmp_name']!="")
                    $img = mysqli_real_escape_string($link,file_get_contents($_FILES['fotoUsuario']['tmp_name']));
                else
                    $img = mysqli_real_escape_string($link, file_get_contents("anonimo.jpg"));
                $sql = "INSERT INTO usuarios(email, nombreApellido, password,foto) VALUES ('$email','$nombreApellido','$password', '$img')";
                if (!mysqli_query($link, $sql)) {
                    die('Error: Fallo en el servidor, recarga la página.');
                }
                echo "Registro completado correctamente.<br>";
                $sql = "SELECT foto FROM usuarios WHERE email='$email'";
                $res = mysqli_query($link, $sql);
                $row = mysqli_fetch_array( $res);
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['foto'] = base64_encode($row['foto']);
                $_SESSION['rol'] = 1;
                mysqli_close($link);
                if (file_exists('contador.xml')) {
                    $contador = simplexml_load_file('contador.xml');
                } else {
                    exit('Error abriendo contador.xml.');
                }
                $contador->usuariosOnline=$contador->usuariosOnline + 1;
                $contador->asXML('contador.xml');
                header("Location: layout2.php");
            }
        ?>
        <div id="respuesta">

        </div>
	</div>
    </section>
	<footer class='main' id='f1'>
        <a href='https://github.com/elsahipatia/SW_final'>Link GITHUB</a>
	</footer>
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script>
      var validEmail=false;
      var validPassword=false;
      $("#password").change(function() {
          XMLHttpRequestObject = new XMLHttpRequest();
          XMLHttpRequestObject.onreadystatechange = function () {
              if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                  var obj1 = document.getElementById('respuesta');
                  if (XMLHttpRequestObject.responseText === 'VALIDA'){
                      obj1.innerHTML = 'Contraseña valida.';
                      validPassword = true;
                  }else if(XMLHttpRequestObject.responseText === 'INVALIDA'){
                      obj1.innerHTML = 'Su contraseña no es segura.';
                      validPassword = false;
                  }else
                      obj1.innerHTML = 'Error en el servidor';
              }
          };
          var password =$('#password').val();
          XMLHttpRequestObject.open('GET', 'comprobarPass.php?password='+password, true);
          XMLHttpRequestObject.send();
      });
      $("#password2").change(function() {
          if($("#password").val() != $("#password2").val()){
              alert("La contraseña no coincide.");
              return;
          }
      });
      $("#submit").click(function () {
          if($("#password").val() != $("#password2").val()){
              alert("La contraseña no coincide.");
              return false;
          }
          else return true;
      });
      $("#email").change(
          function () {
              XMLHttpRequestObject = new XMLHttpRequest();
              XMLHttpRequestObject.onreadystatechange = function () {
                  if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                      var obj1 = document.getElementById('respuesta');
                      if (XMLHttpRequestObject.responseText === 'SI'){
                          obj1.innerHTML = 'Usuario correcto';
                          validEmail=true;
                      }else{
                          obj1.innerHTML = 'El usuario no se encuentra en la base de datos de la EHU';
                          validEmail=false;
                      }
                  }
              };
              var email =$('#email').val();
              XMLHttpRequestObject.open('GET', 'comprobarEmail.php?email='+email, true);
              XMLHttpRequestObject.send();
          }
      );

      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.readAsDataURL(input.files[0]);
              reader.onload = function(e) {
                  var image = $('#imagenUsuario');
                  image.attr('src', e.target.result);
                  image.css("display","inline");
              };
          }
      }

      $("#fotoUsuario").change(function() {
          readURL(this);
      });

      function check() {

          if (!validEmail){
              alert("Introduce un email valido");
              return false;
          }
          else if(!validPassword){
              alert("Introduce una contraseña mas segura");
              return false;
          }else
              return true;
      }
  </script>
</body>
</html>
