<?php
if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['password'])) {

    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($con, $_POST['apellido']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Verificar si el usuario ya existe
    $chequeoUsuario = "SELECT * FROM usuarios WHERE nombre = '$nombre'";
    $chequeoResultado = mysqli_query($con, $chequeoUsuario);

    if (mysqli_num_rows($chequeoResultado) != 0) {
        echo "<script>alert('Error: El usuario ya existe');</script>";
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $insertarUsuario = "INSERT INTO usuarios (nombre, apellido, email, clave, rol) VALUES ('$nombre', '$apellido', '$email', '$hashed_password', 1)";
        $insertarResultado = mysqli_query($con, $insertarUsuario);

        if ($insertarResultado) {
            echo "<script>alert('Registro insertado con éxito');</script>";
        } else {
            echo "<script>alert('Error: No se pudo insertar el registro');</script>";
        }
    }
    echo "<script>window.location='index.php?modulo=iniciar-sesion';</script>";
}
?>

<style>
    input::placeholder {
        color: white;
    }
</style>

<body class="bg-gray-200">
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
    </div>
</body>