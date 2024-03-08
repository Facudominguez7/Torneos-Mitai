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
        echo "Error: El usuario ya existe";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Generar un token único
    $token = bin2hex(random_bytes(16));

    // Insertar el usuario con el token en la base de datos
    $insertarUsuario = "INSERT INTO usuarios (nombre, apellido, email, clave, rol, token) VALUES ('$nombre', '$apellido', '$email', '$hashed_password', 1, '$token')";
    $insertarResultado = mysqli_query($con, $insertarUsuario);

    if ($insertarResultado) {
        // Enviar correo electrónico de verificación en segundo plano
        enviarCorreo($email, $token);
        echo "Registro exitoso";
    } else {
        echo "Error: No se pudo insertar el registro";
    }
}

function enviarCorreo($email, $token) {
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

        // Enviar el correo electrónico
        $mail->send();
    } catch (Exception $e) {
        // Manejar cualquier excepción
        echo "Error: No se pudo enviar el correo electrónico de verificación. Por favor, inténtelo de nuevo más tarde.";
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
                <form id="registrationForm" class="max-w-full" action="index.php?modulo=registro" method="POST">
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

<script>
   // Obtén el formulario y el elemento de carga
const form = document.getElementById('registrationForm');
const loader = document.getElementById('loader');

// Agrega un evento de envío al formulario
form.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir el envío del formulario por defecto

    loader.classList.remove('hidden'); // Mostrar el elemento de carga

    // Retrasar el envío del formulario por 1 segundo
    setTimeout(function() {
        // Enviar el formulario de manera asíncrona usando Fetch API
        fetch(form.action, {
                method: form.method,
                body: new FormData(form)
            })
            .then(response => {
                if (response.ok) {
                    // Si la respuesta es exitosa, mostrar el mensaje de alerta
                    alert('Gracias por registrarse! Se ha enviado un correo electrónico de verificación. Por favor, verifique su correo electrónico para continuar.');
                    window.location.href = 'index.php';
                } else {
                    // Si hay un error en la respuesta, mostrar un mensaje de error
                    alert('Error: No se pudo registrar. Por favor, inténtelo de nuevo más tarde.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // En caso de un error, mostrar un mensaje de error
                alert('Error: No se pudo registrar. Por favor, inténtelo de nuevo más tarde.');
            })
            .finally(() => {
                loader.classList.add('hidden'); // Ocultar el elemento de carga después de enviar el formulario
            });
    }, 1000); // Retraso de 1 segundo
});

</script>
