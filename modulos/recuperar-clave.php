<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require_once './PHPMailer/config.php';
$clave = $config['smtp_password'];

if (!empty($_GET['accion']) && $_GET['accion'] == 'recuperar') {
    $email = $_POST['email'];
    $sqlVerificarExistencia = "SELECT us.email, us.token, us.correo_verificado, us.id FROM usuarios as us WHERE LOWER(email) = LOWER(?)";
    $stmt = mysqli_prepare($con, $sqlVerificarExistencia);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado->num_rows > 0) {
        while ($row = mysqli_fetch_array($resultado)) {
            $correo_verificado = $row['correo_verificado'];
            if ($correo_verificado === 1) {
                $token = $row['token'];
                $expiracion = date('Y-m-d H:i:s', strtotime('+24 hours'));
                // Almacena el tiempo de expiración del token en la base de datos
                $sql_guardar_expiracion = "UPDATE usuarios SET expiracion_token = ? WHERE token = ?";
                $stmt_guardar_expiracion = mysqli_prepare($con, $sql_guardar_expiracion);
                mysqli_stmt_bind_param($stmt_guardar_expiracion, "ss", $expiracion, $token);
                mysqli_stmt_execute($stmt_guardar_expiracion);

                $mail = new PHPMailer(true); // Crear una instancia de PHPMailer
                try {
                    // Configurar la conexión SMTP
                    $mail->isSMTP();
                    $mail->Host = 'c248.ferozo.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'torneos-mitai@xn--torneosmita-ycb.com'; // Cambiar por tu dirección de correo electrónico
                    $mail->Password = $clave; // Cambiar por tu contraseña
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;

                    // Configurar el remitente y el destinatario
                    $mail->setFrom('torneos-mitai@xn--torneosmita-ycb.com', 'Torneos Mitai'); // Cambiar por tu dirección de correo electrónico
                    $mail->addAddress($row['email']);

                    // Configurar el contenido del correo electrónico
                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->Subject = 'Recuperación';
                    $body = '<html>';
                    $body .= '<head><style>';
                    $body .= 'body { font-family: Arial, sans-serif; }';
                    $body .= 'a { color: #007bff; text-decoration: none; }';
                    $body .= 'a:hover { text-decoration: underline; }';
                    $body .= '</style></head>';
                    $body .= '<body>';
                    $body .= '<p>Hola,</p>';
                    $body .= '<p>Haga clic en el siguiente enlace para recuperar su contraseña. Este enlace será válido por 24 horas.</p>';
                    $body .= '<p><a href="http://localhost/MITAI/index.php?modulo=formulario-clave&token=' . urlencode(base64_encode($token)) . '">Recuperar Contraseña</a></p>';
                    $body .= '<p>Si no solicitó este cambio, ignore este correo electrónico.</p>';
                    $body .= '</body></html>';

                    $mail->Body = $body;

                    // Enviar el correo electrónico
                    $mail->send();
                    echo '<script> 
                Swal.fire({
                    title: "¡Correo enviado!",
                    text: "Se ha enviado un correo electrónico de verificación. Por favor, verifique su correo electrónico para recuperar su contraseña.",
                    icon: "success",
                    confirmButtonColor: "#4caf50",
                    confirmButtonText: "Aceptar"
                }); 
        </script>';
                } catch (Exception $e) {
                    echo $e;
                    echo '<script> 
                Swal.fire({
                    title: "¡Error!",
                    text: "No se pudo enviar el correo electrónico, por favor intentelo de nuevo mas tarde.",
                    icon: "warning",
                    confirmButtonColor: "#ffc107",
                    confirmButtonText: "Aceptar",
                    willClose: () => {
                        window.location.href = "index.php?modulo=recuperar-clave";
                    }
                }); 
            </script>';
                }
            } else {
                $token_nuevo = bin2hex(random_bytes(16));
                $idUsuario = $row['id'];
                $insertarUsuario = "UPDATE usuarios SET token = ? WHERE id = ?";
                $stmt = mysqli_prepare($con, $insertarUsuario);

                mysqli_stmt_bind_param($stmt, "si", $token_nuevo, $idUsuario);

                $insertarResultado = mysqli_stmt_execute($stmt);

                if ($insertarResultado) {
                    $mail = new PHPMailer(true); // Crear una instancia de PHPMailer
                    try {
                        // Configurar la conexión SMTP
                        $mail->isSMTP();
                        $mail->Host = 'c248.ferozo.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'torneos-mitai@xn--torneosmita-ycb.com'; // Cambiar por tu dirección de correo electrónico
                        $mail->Password = $clave; // Cambiar por tu contraseña
                        $mail->SMTPSecure = 'ssl';
                        $mail->Port = 465;

                        // Configurar el remitente y el destinatario
                        $mail->setFrom('torneos-mitai@xn--torneosmita-ycb.com', 'Torneos Mitai'); // Cambiar por tu dirección de correo electrónico
                        $mail->addAddress($email);

                        // Configurar el contenido del correo electrónico
                        $mail->isHTML(true);
                        $mail->CharSet = 'UTF-8';
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
                        $body .= '<p><a href="http://localhost/MITAI/index.php?modulo=verificar-email&token=' . urlencode(base64_encode($token_nuevo)) . '">Verificar correo electrónico</a></p>';
                        $body .= '<p>Si no solicitó esta verificación, ignore este correo electrónico.</p>';
                        $body .= '</body></html>';

                        $mail->Body = $body;

                        // Enviar el correo electrónico
                        $mail->send();
                        echo '<script> 
                        Swal.fire({
                            title: "¡Correo enviado!",
                            text: "Se ha enviado un correo electrónico de verificación. Es necesario validar su correo para poder recuperar su contraseña",
                            icon: "success",
                            confirmButtonColor: "#4caf50",
                            confirmButtonText: "Aceptar"
                        }); 
                </script>';
                    } catch (Exception $e) {
                        echo $e;
                        // Manejar cualquier excepción
                        echo "<script>alert('Error: No se pudo enviar el correo electrónico de verificación. Por favor, inténtelo de nuevo más tarde.');</script>";
                    }
                } else {
                    echo "Correo no enviado";
                }
            }
        }
    } else {
        echo '<script> 
                    Swal.fire({
                        title: "¡Error!",
                        text: "El email ingresado no pertenece a un usuario registrado",
                        icon: "warning",
                        confirmButtonColor: "#ffc107",
                        confirmButtonText: "Aceptar",
                        willClose: () => {
                            window.location.href = "index.php?modulo=registro";
                        }
                    }); 
                </script>';
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