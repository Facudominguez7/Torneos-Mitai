<?php
if (!empty($_GET['accion']) && $_GET['accion'] == 'recuperar') {
    if (!empty($_POST['clave']) && !empty($_POST['confirmar_clave'])) {
        $token = $_POST['token'];
        $token_decodificado = base64_decode(urldecode($token));

        // Obtener las contraseñas enviadas por el formulario
        $clave = mysqli_real_escape_string($con, $_POST['clave']);
        $clave2 = mysqli_real_escape_string($con, $_POST['confirmar_clave']);

        // Verificar si las contraseñas son iguales
        if ($clave === $clave2) {
            $sql = "SELECT email FROM usuarios WHERE token = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "s", $token_decodificado);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado->num_rows > 0) {
                // Actualizar la contraseña en la base de datos
                $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);
                $sql_actualizar = "UPDATE usuarios SET clave = ? WHERE token = ?";
                $stmt_actualizar = mysqli_prepare($con, $sql_actualizar);
                mysqli_stmt_bind_param($stmt_actualizar, "ss", $clave_encriptada, $token_decodificado);
                mysqli_stmt_execute($stmt_actualizar);

                echo '<script> 
                    Swal.fire({
                    title: "¡Contraseña Actualizada!",
                    html: "<p>Ya puede iniciar sesión</p>",
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
                // Token no encontrado en la base de datos, mostrar un mensaje de error
                echo '<script> 
                Swal.fire({
                    title: "¡Oops!",
                    text: "Token no válido",
                    icon: "error",
                    showCloseButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Aceptar",
                    allowOutsideClick: false,
                    willClose: () => {
                        window.location.href = "index.php?modulo=iniciar-sesion";
                    }
                }); 
            </script>';
            }
        } else {
            echo '<script> 
            Swal.fire({
                title: "¡Oops!",
                text: "Las contraseñas no coinciden, por favor intentelo de nuevo",
                icon: "error",
                showCloseButton: true,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Aceptar",
                allowOutsideClick: false,
                willClose: () => {
                    window.location.href = "index.php?modulo=formulario-clave&accion=recuperar&token='. $token .'";
                }
            }); 
        </script>';
        }
    }
}
?>

<section>
    <div class="flex mb-10 h-auto w-auto mx-auto items-center justify-center">
        <div class="container h-screen mx-auto px-4 md:w-1/2 mt-10">
            <div class="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-xl md:shadow-lg backdrop-blur-md max-sm:px-8">
                <div class="text-white">
                    <form action="index.php?modulo=formulario-clave&accion=recuperar" method="POST">
                        <div class="mb-4 text-2xl flex flex-col justify-center items-center">
                            <label class="mb-2" for="nombre">Ingrese su Nueva Contraseña</label>
                            <?php
                                if(isset($_GET['token'])){
                                    $token = $_GET['token']
                                    ?>
                                         <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                                    <?php
                                } 
                            ?>
                            <input class="rounded-3xl border-none bg-blue-500 bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="password" id="clave" name="clave" required />
                        </div>
                        <div class="mb-4 text-2xl flex flex-col justify-center items-center">
                            <label class="mb-2" for="nombre">Repetir Contraseña</label>
                            <input class="rounded-3xl border-none bg-blue-500 bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="password" id="confirmar_clave" name="confirmar_clave" required />
                        </div>
                        <div class="mt-8 flex justify-center text-lg text-black">
                            <button type="submit" class="rounded-3xl bg-yellow-200 bg-opacity-50 px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-yellow-700">Ingresar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>