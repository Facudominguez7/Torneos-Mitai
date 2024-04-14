<?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $token_decodificado = base64_decode(urldecode($token));

    // Buscar el usuario por el token en la base de datos
    $sql = "SELECT * FROM usuarios WHERE token = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $token_decodificado);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        echo $correo_verificado = $row['correo_verificado'];
        if ($correo_verificado === 0) {
            // Marcar el correo electrónico como verificado en la base de datos
            $sql_update = "UPDATE usuarios SET correo_verificado = 1 WHERE token = ?";
            $stmt_update = mysqli_prepare($con, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "s", $token_decodificado);
            mysqli_stmt_execute($stmt_update);
            // Redirigir al usuario a la página de inicio después de iniciar sesión automáticamente
            echo '<script> 
                Swal.fire({
                title: "¡Email Verificado con Éxito!",
                html: "<p>Su email ha sido verificado exitosamente.</p>",
                icon: "success",
                confirmButtonColor: "#4caf50",
                confirmButtonText: "Aceptar",
                allowOutsideClick: false,
                willClose: () => {
                    window.location.href = "index.php?modulo=iniciar-sesion";
                }
            }); 
        </script>';
        } else {
            echo '<script> 
            Swal.fire({
                title: "¡Error!",
                text: "El email ya ha sido verificado",
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
        echo "Token inválido o expirado.";
    }
} else {
    echo "Token no proporcionado.";
}
