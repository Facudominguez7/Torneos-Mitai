<?php
session_destroy();
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Buscar el usuario por el token en la base de datos
    $sql = "SELECT * FROM usuarios WHERE token = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Marcar el correo electrónico como verificado en la base de datos
        $sql_update = "UPDATE usuarios SET correo_verificado = 1 WHERE token = ?";
        $stmt_update = mysqli_prepare($con, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "s", $token);
        mysqli_stmt_execute($stmt_update);

        // Iniciar sesión automáticamente
        session_start();
        $_SESSION['id'] = $row['id'];
        $_SESSION['nombre_usuario'] = $row['nombre'];
        $_SESSION['rol'] = $row['rol'];

        // Redirigir al usuario a la página de inicio después de iniciar sesión automáticamente
        echo "<script>window.location='index.php';</script>";
        exit();
    } else {
        echo "Token inválido o expirado.";
    }
} else {
    echo "Token no proporcionado.";
}

