<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if (!empty($_GET['accion']) && $_GET['accion'] == 'recuperar') {
    $email = $_POST['email'];
    $sqlVerificarExistencia = "SELECT us.email, us.token FROM usuarios as us WHERE email = ?";
    $stmt = mysqli_prepare($con, $sqlVerificarExistencia);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado->num_rows > 0) {
        while ($row = mysqli_fetch_array($resultado)) {
            $mail = new PHPMailer(true); // Crear una instancia de PHPMailer
            try {
                $token = $row['token'];
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
                $mail->addAddress($row['email']);

                // Configurar el contenido del correo electrónico
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Verificación de correo electrónico';
                $mail->Body = "Haga clic en el siguiente enlace para Recuperar su contraseña: <a href='http://localhost/MITAI/index.php?modulo=formulario-clave&token=$token'>Recuperar Contraseña</a>";

                // Enviar el correo electrónico
                $mail->send();
            } catch (Exception $e) {
                echo $e;
                // Manejar cualquier excepción
                echo "<script>alert('Error: No se pudo enviar el correo electrónico de verificación. Por favor, inténtelo de nuevo más tarde.');</script>";
            }
        }
    } else {
        // Si el correo electrónico no existe en la base de datos, mostrar un mensaje de error
        echo "El correo electrónico no existe en la base de datos";
    }
}

?>

<section>
    <div class="flex mb-10 h-auto w-auto mx-auto items-center justify-center">
        <div class="container h-screen mx-auto px-4 md:w-1/2 mt-10">
            <div class="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-xl md:shadow-lg backdrop-blur-md max-sm:px-8">
                <div class="text-white">
                    <form action="index.php?modulo=recuperar-clave&accion=recuperar" method="POST">
                        <div class="mb-4 text-2xl flex flex-col justify-center items-center">
                            <label class="mb-2" for="nombre">Ingrese su Dirección de Correo Electrónico</label>
                            <input class="rounded-3xl border-none bg-blue-500 bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="email" id="email" name="email" required />
                        </div>
                        <div class="mt-8 flex justify-center text-lg text-black">
                            <button type="submit" class="rounded-3xl bg-yellow-200 bg-opacity-50 px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-yellow-700">Verificar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>