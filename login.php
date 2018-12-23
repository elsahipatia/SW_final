
<?php
require_once "config.php";

if (isset($_SESSION['access_token'])) {
    header('Location: index.php');
    exit();
}

$redirectURL = "http://localhost/SW_final/fb-callback.php";
$permissions = ['email'];
$loginURL = $helper->getLoginUrl($redirectURL, $permissions);
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
    <section class="main" id="s1" >
        <div style="font-weight: bold ; font-size: large">
            <form  method='post' id='loginForm' name='loginForm' enctype="multipart/form-data" action="login.php" >
                <table id="tabla-registro">
                    <tr>
                        <td align="left">Email*: <input id="email" name="email" type="text" class="login" required placeholder="Introduce un correo de la UPV-EHU."  pattern="^([a-z]+[0-9]{3}@ikasle\.ehu\.eus)|(admin@ehu\.es)$"></td>
                    </tr>
                    <tr>
                        <td align="left">Contraseña*: <input id="password" name="password" type="password" class="login" required placeholder="Introduce una contrasñea de mínimo 6 caracteres alfanuméricos"  pattern="^.{6,}$"></td>
                    </tr>
                    <tr>
                        <td align="left"><input id="submit" name="submit" type="submit" class="login"></td>
                    </tr>
                    <tr>
                        <td align="left"><input type="button" onclick="window.location = '<?php echo $loginURL ?>';" value="Log In With Facebook" class="btn btn-primary"></td>
                    </tr>
                </table>
            </form>
            <a href='CambiarPassword.php'>¿Has olvidado la contraseña?</a>
            <?php
            if(isset($_POST['submit'])) {
                include "configDB.php";
                $link = mysqli_connect($server, $user, $pass, $basededatos);
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
                $sql = "SELECT email,password,foto FROM usuarios WHERE email='$email'";
                $res = mysqli_query($link, $sql);
                $row = mysqli_fetch_array( $res);

                if(!$row){
                    echo "Email incorrecto";
                    return;
                }
                if($email=="admin@ehu.es"){
                    if($password!="admin000"){
                        echo "Contraseña Incorrecta";
                        return;
                    }
                }
                else{
                    if(!password_verify($password,$row['password'])){
                        echo "Contraseña Incorrecta";
                        return;
                    }
                }
                $_SESSION['email'] = $row['email'];
                $_SESSION['password'] = $row['password'];
                $_SESSION['foto'] = base64_encode($row['foto']);
                if($row['email'] === 'admin@ehu.es')
                    $_SESSION['rol'] = 0; //admin
                else
                    $_SESSION['rol'] = 1;
                mysqli_close($link);
                header("Location: layout2.php");

                /*Actualizar el contador*/
                if (file_exists('contador.xml')) {
                    $contador = simplexml_load_file('contador.xml');
                } else {
                    exit('Error abriendo contador.xml.');
                }
                $contador->usuariosOnline=$contador->usuariosOnline + 1;
                $contador->asXML('contador.xml');
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
