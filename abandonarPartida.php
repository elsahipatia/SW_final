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
        <form action="rankingDB.php" method="post">
            <table>
                <tr>
                    <td align="left">Tu puntuación:</td>
                    <td align="left" id="miPuntuacion">
                        <?php echo $_GET['puntuacion']?>
                        <input id="puntuacion" name="puntuacion" type="text" size="1" style="display: none" value="<?php echo $_GET['puntuacion']?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Introduce tu nick:
                    </td>
                    <td>
                        <input id="nick" name="nick" type="text">
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <input align="right" type="submit">
                    </td>
                </tr>
            </table>
        </form>
    </section>
    <footer class='main' id='f1'>
        <a href='https://github.com/elsahipatia/SW_final'>Link GITHUB</a>
    </footer>
</div>
</body>
</html>
