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

    try {
        // Configurar la conexión SMTP
        $mail->isSMTP();
        $mail->Host = 'c248.ferozo.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'torneos-mitai@xn--torneosmita-ycb.com'; // Cambiar por tu dirección de correo electrónico
        $mail->Password = ''; // Cambiar por tu contraseña
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Configurar el remitente y el destinatario
        $mail->setFrom('torneos-mitai@xn--torneosmita-ycb.com', 'Torneos Mitai'); // Cambiar por tu dirección de correo electrónico
        $mail->addAddress($email);

        // Configurar el contenido del correo electrónico
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Verificación de correo electrónico';
        $mail->Body = "Haga clic en el siguiente enlace para verificar su correo electrónico: <a href='http://localhost/MITAI/index.php?modulo=verificar-email&token=$token'>Verificar correo electrónico</a>";

        // Enviar el correo electrónico
        $mail->send();
    } catch (Exception $e) {
        echo $e;
        // Manejar cualquier excepción
        echo "<script>alert('Error: No se pudo enviar el correo electrónico de verificación. Por favor, inténtelo de nuevo más tarde.');</script>";
    }
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
                $_SESSION['id'] = $row['id'];
                $_SESSION['nombre_usuario'] = $row['nombre'];
                $_SESSION['rol'] = $row['rol'];

                echo '<script> 
                    Swal.fire({
                        title: "¡Bienvenido!",
                        text: "Nombre de usuario: ' . $_SESSION['nombre_usuario'] . '",
                        icon: "success",
                        confirmButtonColor: "#4caf50",
                        confirmButtonText: "Aceptar",
                        allowOutsideClick: false,
                        willClose: () => {
                            window.location.href = "index.php";
                        }
                    }); 
                </script>';
            } else {
                echo '<script> 
                    Swal.fire({
                        title: "¡Verifique los datos!",
                        text: "Por favor, revise los datos ingresados.",
                        icon: "warning",
                        confirmButtonColor: "#ffc107",
                        confirmButtonText: "Aceptar",
                        willClose: () => {
                            window.location.href = "index.php?modulo=iniciar-sesion";
                        }
                    }); 
                </script>';
            }
        } else {
            if (password_verify($password, $row['clave'])) {

                $token = bin2hex(random_bytes(16));
                $idUsuario = $row['id'];

                $insertarUsuario = "UPDATE usuarios SET token = ? WHERE id = ?";
                $stmt = mysqli_prepare($con, $insertarUsuario);

                mysqli_stmt_bind_param($stmt, "si", $token, $idUsuario);

                $insertarResultado = mysqli_stmt_execute($stmt);

                if ($insertarResultado) {
                    enviarCorreoVerificacion($email, $token);
                    echo '<script> 
                            Swal.fire({
                                title: "¡Correo enviado!",
                                text: "Se ha enviado un correo electrónico de verificación. Por favor, verifique su correo electrónico para iniciar sesión.",
                                icon: "success",
                                confirmButtonColor: "#4caf50",
                                confirmButtonText: "Aceptar"
                            }); 
                    </script>';
                } else {
                    echo "Correo no enviado";
                }
            } else {
                echo '<script> 
                    Swal.fire({
                        title: "¡Verifique los datos!",
                        text: "Por favor, revise los datos ingresados.",
                        icon: "warning",
                        confirmButtonColor: "#ffc107",
                        confirmButtonText: "Aceptar",
                        willClose: () => {
                            window.location.href = "index.php?modulo=iniciar-sesion";
                        }
                    }); 
                </script>';
            }
        }
    } else {
        echo '<script> 
                    Swal.fire({
                        title: "¡Verifique los datos!",
                        text: "Por favor, revise los datos ingresados.",
                        icon: "warning",
                        confirmButtonColor: "#ffc107",
                        confirmButtonText: "Aceptar",
                        willClose: () => {
                            window.location.href = "index.php?modulo=iniciar-sesion";
                        }
                    }); 
                </script>';
    }
}
?>

<style>
    input::placeholder {
        color: white;
    }
</style>
<section>
    <div class="flex mb-10 h-auto w-auto mx-auto items-center justify-center">
        <div class="container h-screen mx-auto px-4 md:w-1/2 mt-10">
            <div class="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-xl md:shadow-lg backdrop-blur-md max-sm:px-8">
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
                            <a href="index.php?modulo=recuperar-contraseña" class="mt-4 text-white hover:text-yellow-200">¿Olvidó su contraseña?</a>
                        </div>
                        <div class="mt-8 flex justify-center text-lg text-black">
                            <button type="submit" class="rounded-3xl bg-yellow-200 bg-opacity-50 px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-yellow-700">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>