<?php
if (isset($_GET['salir'])) {
    session_destroy();
    echo "<script>window.location='index.php';</script>";
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    // Escapar las variables del formulario para prevenir inyecciones SQL
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Consulta preparada para buscar el usuario por su email
    $sql = "SELECT id, nombre, email, clave, rol FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
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
        echo "<script> alert('Verifique los datos.');</script>";
    }
    echo "<script>window.location='index.php';</script>";
}
?>


<!doctype html>
<html lang="en">

<style>
    input::placeholder {
        color: white;
    }
</style>
<body class="bg-gray-200">
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
                <form action="index.php?modulo=iniciar-sesion" method="POST">
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
    </div>
</body>

</html>