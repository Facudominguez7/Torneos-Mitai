<body>
    <div class="flex items-center justify-center p-12">
        <!-- Author: FormBold Team -->
        <!-- Learn More: https://formbold.com -->
        <div class="mx-auto w-full max-w-[550px]">
            <form action="index.php?modulo=agregar-fechas&accion=agregarFecha&id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-5">
                    <label for="nombre" class="mb-3 block text-base font-medium text-white">
                        Nombre de la fecha
                    </label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre de la Fecha" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div>
                    <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Agregar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

<?php
if (!empty($_GET['accion'])) {
    if ($_GET['accion'] == 'agregarFecha') {
        $idCategoria = $_GET['id'];
        $nombre = $_POST['nombre'];

        // Verificar si ya existe una fecha con ese nombre en esa categoría
        $sqlVerificarExistencia = "SELECT * FROM fechas WHERE nombre = ? AND idCategoria = ?";
        $stmt = mysqli_prepare($con, $sqlVerificarExistencia);
        mysqli_stmt_bind_param($stmt, "si", $nombre, $idCategoria);
        mysqli_stmt_execute($stmt);
        $resultadoVerificar = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultadoVerificar) != 0) {
            echo "<script> alert('LA FECHA YA EXISTE EN LA BASE DE DATOS');</script>";
        } else {
            // Insertar nueva fecha
            $sqlInsertarFecha = "INSERT INTO fechas (nombre, idCategoria) VALUES (?, ?)";
            $stmtInsertar = mysqli_prepare($con, $sqlInsertarFecha);
            mysqli_stmt_bind_param($stmtInsertar, "si", $nombre, $idCategoria);
            $resultadoInsertar = mysqli_stmt_execute($stmtInsertar);

            if (!$resultadoInsertar) {
                echo "<script>alert('Error al insertar la fecha');</script>";
            } else {
                echo "<script>alert('Fecha agregado exitosamente');</script>";
            }
        }
        echo "<script>window.location='index.php?modulo=categoria-2010&id=1';</script>";
    }
}


?>