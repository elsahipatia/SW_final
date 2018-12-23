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
            <form  method='post' id='recoverForm' enctype="multipart/form-data" action="recuperarPass.php" >
                <table id="tabla-recuperar-pass">
                    <tr>
                        <td align="left">Email*: <input id="email" name="email" type="text"  required placeholder="Introduce un correo de la UPV-EHU."></td>
                    </tr>
                    <tr>
                        <td align="left">Confirmar Email*: <input id="email2" name="email2" type="text" required placeholder="Repite la contraseña."></td>
                    </tr>
                    <tr>
                        <td align="left">Nueva contraseña*: <input id="password" name="password" type="password" required placeholder="Introduce una contrasñea de mínimo 6 caracteres alfanuméricos"></td>
                    </tr>
                    <tr>
                        <td align="left"><input id="submit" name="submit" type="submit" class="login"></td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="display">
            <?php
            if(isset($_POST['submit'])){
                $email = $_POST['email'];
                $randNumber = rand(1000,9999);
                //mail($email,"Código de recuperación","Tu código de recuperación es: "+$randNumber);
                //echo '<form onsubmit="checkNumber($randNumber)"><input id="recCod" type="text" class="login"> Introduce el código de recuperación</form>';
            }
            ?>
        </div>
    </section>
    <footer class='main' id='f1'>
        <a href='https://github.com/elsahipatia/SW_final'>Link GITHUB</a>
    </footer>
</div>
<script>
    function checkNumber(randNumber) {
        var recCode=document.getElementById('recCod');
        alert("AQUIIIIII");
        if(randNumber === recCode.text)
            return true;
        else
            return false;

    }
</script>
</body>
</html>
