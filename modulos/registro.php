<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';


if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['password'])) {

    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($con, $_POST['apellido']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Verificar si el usuario ya existe
    $chequeoUsuario = "SELECT * FROM usuarios WHERE email = '$email'";
    $chequeoResultado = mysqli_query($con, $chequeoUsuario);

    if (mysqli_num_rows($chequeoResultado) != 0) {
        echo "<script>alert('Error: El usuario ya existe');</script>";
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Generar un token único
        $token = bin2hex(random_bytes(16));

        // Insertar el usuario con el token en la base de datos
        $insertarUsuario = "INSERT INTO usuarios (nombre, apellido, email, clave, rol, token) VALUES ('$nombre', '$apellido', '$email', '$hashed_password', 1, '$token')";
        $insertarResultado = mysqli_query($con, $insertarUsuario);

        if ($insertarResultado) {
            // Crear una nueva instancia de PHPMailer
            $mail = new PHPMailer(true); // Habilitar excepciones
            try {
                // Configurar el método de envío
                $mail->isSMTP(); // Usar SMTP
                $mail->Host = 'smtp.gmail.com'; // Cambiar al servidor SMTP de tu proveedor de correo
                $mail->SMTPAuth = true; // Habilitar autenticación SMTP
                $mail->Username = 'facudominguez457@gmail.com'; // Usuario SMTP
                $mail->Password = ''; // Contraseña SMTP
                $mail->SMTPSecure = 'tls'; // Habilitar cifrado TLS
                $mail->Port = 587; // Puerto SMTP

                // Configurar el remitente y el destinatario
                $mail->setFrom('torneos-mitai@xn--torneosmita-ycb.com', 'Torneos Mitai'); // Remitente
                $mail->addAddress($email); // Destinatario

                // Configurar el contenido del correo electrónico
                $mail->isHTML(true); // Habilitar formato HTML
                $mail->CharSet = 'UTF-8'; // Establecer la codificación de caracteres
                $mail->Subject = 'Verificación de correo electrónico';
                $mail->Body = "Haga clic en el siguiente enlace para verificar su correo electrónico: <a href='http://localhost/MITAI/index.php?modulo=verificar-email&token=$token'>Verificar correo electrónico</a>";

                $mail->send();

                if ($mail->send()) {
?>
                    <script>
                        document.getElementById('loader').classList.remove('hidden'); // Mostrar la animación de carga
                        setTimeout(function() {
                            alert('Gracias por registrarse! Se ha enviado un correo electrónico de verificación. Por favor, verifique su correo electrónico para continuar.');
                            document.getElementById('loader').classList.add('hidden'); // Ocultar la animación al completar
                        }, 3000); // Ajusta el tiempo de espera según la duración de tu animación
                    </script>
                <?php
                } else {
                ?>
                    <script>
                        alert('Error: No se pudo enviar el correo electrónico de verificación. Por favor, inténtelo de nuevo más tarde.');
                    </script>
<?php
                }
            } catch (Exception $e) {
                echo "<script>alert('Gracias por registrarse! No se pudo enviar el correo electrónico de verificación. Por favor, inténtelo de nuevo más tarde.');</script>";
            }
        } else {
            echo "<script>alert('Error: No se pudo insertar el registro');</script>";
        }
    }
}
?>

<style>
    input::placeholder {
        color: white;
    }
</style>

<section class="bg-gray-200">
    <div class="flex lg:h-screen w-full items-center justify-center bg-gray-900 bg-cover bg-no-repeat" style="background-image:url('Imagenes/fondo_en_cancha.webp')">
        <div class="rounded-xl mt-5 mb-5 bg-gray-800 bg-opacity-50 px-16 py-10 shadow-lg backdrop-blur-md max-sm:px-5">
            <div class="text-white  lg:w-full">
                <div class="mb-8 flex flex-col items-center">
                    <img src="Imagenes/Logo_Mitai_SinFondo.png" width="150" alt="Logo_Mitai_SinFondo" srcset="" />
                    <h1 class="mb-2 text-2xl">Torneos Mitai</h1>
                    <a class="mt-2" href="index.php?modulo=iniciar-sesion">
                        <h1 class="text-white">Ya tiene una cuenta? <button class="rounded-lg p-1 bg-yellow-200  bg-opacity-50 hover:bg-yellow-700 shadow-xl backdrop-blur-md transition-colors duration-300">Iniciar Sesión</button></h1>
                    </a>
                </div>
                <form class="max-w-full" action="index.php?modulo=registro" method="POST">
                    <div class="mb-4 text-2xl flex flex-col justify-center items-center">
                        <label class="mb-2" for="nombre">Nombre</label>
                        <input class="rounded-3xl border-none bg-blue-500 bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="text" name="nombre" id="nombre" placeholder="Nombre" required />
                    </div>
                    <div class="mb-4 text-2xl flex flex-col justify-center items-center">
                        <label class="mb-2" for="apellido">Apellido</label>
                        <input class="rounded-3xl border-none bg-blue-500 bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="text" name="apellido" id="apellido" placeholder="Apellido" required />
                    </div>
                    <div class="mb-4 text-2xl flex flex-col justify-center items-center">
                        <label class="mb-2" for="nombre">Email</label>
                        <input class="rounded-3xl border-none bg-blue-500 bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="email" name="email" id="email" placeholder="Email" required />
                    </div>
                    <div class="mb-4 text-2xl flex flex-col justify-center items-center">
                        <label class="mb-2" for="nombre">Contraseña</label>
                        <input class="rounded-3xl border-none bg-blue-500  bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="password" name="password" id="password" placeholder="******" required />
                    </div>
                    <div class="mt-8 flex justify-center text-lg text-black">
                        <button type="submit" class="rounded-3xl bg-yellow-200 bg-opacity-50 px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-yellow-700">Registrarse</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Elemento de carga -->
        <div id="loader" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-80 flex justify-center items-center z-50  ">
            <div class="animate-spin rounded-full h-20 w-20 border-t-4 border-b-4 border-yellow-500"></div>
        </div>
    </div>
</section>
