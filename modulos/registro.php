<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require_once './PHPMailer/config.php';
$clave = $config['smtp_password'];

if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['password'])) {
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($con, $_POST['apellido']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Verificar si el usuario ya existe
    $chequeoUsuario = "SELECT * FROM usuarios WHERE email = '$email'";
    $chequeoResultado = mysqli_query($con, $chequeoUsuario);

    if (mysqli_num_rows($chequeoResultado) != 0) {
        echo '<script> 
        Swal.fire({
            title: "¡Oops!",
            text: "Este usuario ya existe. Por favor, inicia sesión.",
            icon: "error",
            showCloseButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Iniciar Sesión",
            allowOutsideClick: false,
            willClose: () => {
                window.location.href = "index.php?modulo=iniciar-sesion";
            }
        }); 
    </script>';
        exit();
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Generar un token único
        $token = bin2hex(random_bytes(16));

        // Insertar el usuario con el token en la base de datos
        $insertarUsuario = "INSERT INTO usuarios (nombre, apellido, email, clave, rol, token) VALUES ('$nombre', '$apellido', '$email', '$hashed_password', 1, '$token')";
        $insertarResultado = mysqli_query($con, $insertarUsuario);

        if ($insertarResultado) {
            echo '<script> 
                     Swal.fire({
                    title: "¡Registro Exitoso!",
                    html: "<p>Gracias por registrarse. Se ha enviado un correo electrónico de verificación.</p><p>Por favor, verifique su correo electrónico para continuar.</p>",
                    icon: "success",
                    confirmButtonColor: "#4caf50",
                    confirmButtonText: "Aceptar",
                    allowOutsideClick: false,
                    willClose: () => {
                        window.location.href = "index.php";
                    }
                }); 
            </script>';
            // Enviar correo electrónico de verificación en segundo plano
            enviarCorreo($email, $token, $clave);
        } else {
            echo "Error: No se pudo insertar el registro";
        }
    }
}

function enviarCorreo($email, $token, $clave)
{
    $mail = new PHPMailer(true); // Habilitar excepciones
    try {


        // Configurar el método de envío
        $mail->isSMTP(); // Usar SMTP
        $mail->Host = 'c248.ferozo.com'; // Cambiar al servidor SMTP de tu proveedor de correo
        $mail->SMTPAuth = true; // Habilitar autenticación SMTP
        $mail->Username = 'torneos-mitai@xn--torneosmita-ycb.com'; // Usuario SMTP
        $mail->Password = $clave; // Contraseña SMTP
        $mail->SMTPSecure = 'ssl'; // Habilitar cifrado TLS
        $mail->Port = 465; // 587 Puerto SMTP

        // Configurar el remitente y el destinatario
        $mail->setFrom('torneos-mitai@xn--torneosmita-ycb.com', 'Torneos Mitai'); // Remitente
        $mail->addAddress($email); // Destinatario

        // Configurar el contenido del correo electrónico
        $mail->isHTML(true); // Habilitar formato HTML
        $mail->CharSet = 'UTF-8'; // Establecer la codificación de caracteres
        $mail->Subject = 'Verificación de correo electrónico';
        $body = '<html>';
        $body .= '<head><style>';
        $body .= 'body { font-family: Arial, sans-serif; }';
        $body .= 'a { color: #007bff; text-decoration: none; }';
        $body .= 'a:hover { text-decoration: underline; }';
        $body .= '</style></head>';
        $body .= '<body>';
        $body .= '<p>Hola,</p>';
        $body .= '<p>Haga clic en el siguiente enlace para verificar su correo electrónico:</p>';
        $body .= '<p><a href="http://localhost/MITAI/index.php?modulo=verificar-email&token=' . urlencode(base64_encode($token)) . '">Verificar correo electrónico</a></p>';
        $body .= '<p>Si no solicitó esta verificación, ignore este correo electrónico.</p>';
        $body .= '</body></html>';

        $mail->Body = $body;

        // Enviar el correo electrónico
        $mail->send();
    } catch (Exception $e) {
        echo $e;
        // Manejar cualquier excepción
        echo "<script>alert('Error: No se pudo enviar el correo electrónico de verificación. Por favor, inténtelo de nuevo más tarde.');</script>";
    }
}
?>

<head>

</head>
<style>
    input::placeholder {
        color: white;
    }
</style>

<section>
    <div class="flex mb-10 h-auto w-auto mx-auto items-center justify-center">
        <div class="container h-full mx-auto px-4 md:w-1/2 mt-10">
            <div class="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-xl md:shadow-lg backdrop-blur-md max-sm:px-8">
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
        </div>
</section>