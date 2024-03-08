<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
if (isset($_GET['salir'])) {
    session_destroy();
    echo "<script>window.location='index.php';</script>";
}

// Función para enviar un correo electrónico de verificación
function enviarCorreoVerificacion($email, $token)
{
    $mail = new PHPMailer(true); // Crear una instancia de PHPMailer

    // Configurar la conexión SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'torneos-mitai@torneosmitaí.com'; // Cambiar por tu dirección de correo electrónico
    $mail->Password = 'rrbd rgej ewxq uplj'; // Cambiar por tu contraseña
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Configurar el remitente y el destinatario
    $mail->setFrom('torneos-mitai@torneosmitaí.com', 'Torneos Mitai'); // Cambiar por tu dirección de correo electrónico
    $mail->addAddress($email);

    // Configurar el contenido del correo electrónico
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Verificación de correo electrónico';
    $mail->Body = "Haga clic en el siguiente enlace para verificar su correo electrónico: <a href='http://localhost/MITAI/index.php?modulo=verificar-email&token=$token'>Verificar correo electrónico</a>";

    // Enviar el correo electrónico
    $mail->send();
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    // Escapar las variables del formulario para prevenir inyecciones SQL
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Consulta preparada para buscar el usuario por su email
    $sql = "SELECT id, nombre, email, clave, rol, correo_verificado as verificado FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        //Verificación de correo electronico chequeado
        if ($row['verificado'] === 1) {
            // Verificar la contraseña almacenada con la contraseña proporcionada
            if (password_verify($password, $row['clave'])) {
                // Iniciar sesión de manera segura
                session_start();
                $_SESSION['id'] = $row['id'];
                $_SESSION['nombre_usuario'] = $row['nombre'];
                $_SESSION['rol'] = $row['rol'];

                echo "<script> alert ('Bienvenido: " . $_SESSION['nombre_usuario'] . "');</script>";
            } else {
                echo "<script> alert('Verifique los datos.');</script>";
            }
        } else {
            if (password_verify($password, $row['clave'])) {
                $verificado = $row['verificado'];
                ?>
                        <input type="text" id="verificacion" class="hidden" value="<?php echo $verificado ?>">
                <?php
                $token = bin2hex(random_bytes(16));
                $idUsuario = $row['id'];

                $insertarUsuario = "UPDATE usuarios SET token = ? WHERE id = ?";
                $stmt = mysqli_prepare($con, $insertarUsuario);

                mysqli_stmt_bind_param($stmt, "si", $token, $idUsuario);

                $insertarResultado = mysqli_stmt_execute($stmt);

                if ($insertarResultado) {
                    enviarCorreoVerificacion($email, $token);
                    echo "Correo enviado";
                } else {
                    echo "Correo no enviado";
                }
            } else {
                echo "<script> alert('Verifique los datos.');</script>";
            }
        }
    } else {
        echo "<script> alert('Error en la consulta.');</script>";
    }
    //echo "<script>window.location='index.php';</script>";
}
?>


<!doctype html>
<html lang="en">

<style>
    input::placeholder {
        color: white;
    }
</style>
<section class="bg-gray-200">
    <div class="flex h-screen w-full items-center justify-center bg-gray-900 bg-cover bg-no-repeat" style="background-image:url('Imagenes/fondo_en_cancha.webp')">
        <div class="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-lg backdrop-blur-md max-sm:px-8">
            <div class="text-white">
                <div class="mb-8 flex flex-col items-center">
                    <img src="Imagenes/Logo_Mitai_SinFondo.png" width="150" alt="Logo_Mitai_SinFondo" srcset="" />
                    <h1 class="mb-2 text-2xl">Torneos Mitai</h1>
                    <a href="index.php?modulo=registro" class="mt-2">
                        <h1 class="text-white">No tiene una cuenta? <button class="rounded-lg p-1 bg-yellow-200  bg-opacity-50 hover:bg-yellow-700 shadow-xl backdrop-blur-md transition-colors duration-300">Registrarse</button></h1>
                    </a>
                </div>
                <form id="registrationForm" action="index.php?modulo=iniciar-sesion" method="POST">
                    <div class="mb-4 text-2xl flex flex-col justify-center items-center">
                        <label class="mb-2" for="nombre">Email</label>
                        <input class="rounded-3xl border-none bg-blue-500 bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="email" id="email" name="email" placeholder="Ingrese su Email" required />
                    </div>

                    <div class="mb-4 text-2xl flex flex-col justify-center items-center">
                        <label class="mb-2" for="nombre">Contraseña</label>
                        <input class="rounded-3xl border-none bg-blue-500  bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="password" id="password" name="password" placeholder="Ingrese su contraseña" required />
                    </div>
                    <div class="mt-8 flex justify-center text-lg text-black">
                        <button type="submit" class="rounded-3xl bg-yellow-200 bg-opacity-50 px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-yellow-700">Iniciar Sesión</button>
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

<script defer>
    // Obtén el formulario y el elemento de carga
    const form = document.getElementById('registrationForm');
    const loader = document.getElementById('loader');
    let verificado = 0; // Valor predeterminado para verificado

    // Obtener el valor de verificado si existe
    const verificacionInput = document.getElementById('verificacion');
    if (verificacionInput) {
        verificado = verificacionInput.value;
    }


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
                        if (verificado === 1) {
                            window.location = 'index.php';
                        } else {
                            // Si la respuesta es exitosa, mostrar el mensaje de alerta
                            alert('Debe verificar su correo electrónico antes de iniciar sesión. Se ha enviado un correo electrónico de verificación.');
                            window.location.href = 'index.php';
                        }
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

</html>