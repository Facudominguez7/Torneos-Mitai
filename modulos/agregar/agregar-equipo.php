<!doctype html>
<html lang="es">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex items-center justify-center p-12">
        <!-- Author: FormBold Team -->
        <!-- Learn More: https://formbold.com -->
        <div class="mx-auto w-full max-w-[550px]">
            <?php $idEdicion = $_GET['idEdicion']?>
            <form action="index.php?modulo=agregar-equipo&accion=agregar-equipo&idEdicion=<?php echo $idEdicion?>" method="POST" enctype="multipart/form-data">
                <div class="mb-5">
                    <label for="nombre" class="mb-3 block text-base font-medium text-white">
                        Nombre del Equipo
                    </label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre del equipo" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div class="mb-5">
                    <label for="category" class="mb-3 block text-base font-medium text-white">
                        Categoría del Equipo
                    </label>
                    <select name="categoria" id="categoria" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                        <?php
                        $idEdicion = $_GET['idEdicion'];
                        $sqlMostrarCategorias = "SELECT categorias.nombreCategoria AS categoria, categorias.id FROM categorias 
                             WHERE categorias.idEdicion = $idEdicion";
                        $stmtCategorias = mysqli_prepare($con, $sqlMostrarCategorias);
                        mysqli_stmt_execute($stmtCategorias);
                        $resultCategorias = mysqli_stmt_get_result($stmtCategorias);

                        if ($resultCategorias->num_rows > 0) {
                            while ($filaCategorias = mysqli_fetch_array($resultCategorias)) {
                        ?>
                            <option value="<?php echo $filaCategorias['id']?>"><?php echo $filaCategorias['categoria']?></option>
                        <?php
                            }
                        } else {
                            ?>
                            <h1>No se agregaron categorias para esta edicion mitaí</h1>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="foto" class="mb-3 block text-base font-medium text-white">
                        Agregar Logo
                    </label>
                    <input type="file" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" id="foto" name="foto">
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
if (!empty([$_GET['accion']])) {
    if ($_GET['accion'] == 'agregar-equipo') {
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $idEdicion = $_GET['idEdicion'];
        //Verifico que no exista ese equipo
        $sql = "SELECT * FROM equipos where nombre = '$nombre' AND idCategoria = $categoria AND idEdicion = $idEdicion";
        $sql = mysqli_query($con, $sql);
        if (mysqli_num_rows($sql) != 0) {
            echo "<script> alert('EL EQUIPO YA EXISTE EN LA BD');</script>";
        } else {

            //procesar foto
            if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
                //Copiar en el directorio
                $nombreFoto = explode('.', $_FILES['foto']['name']);
                $foto = time() . '.' . end($nombreFoto);
                copy($_FILES['foto']['tmp_name'], 'Imagenes/' . $foto);
            }
            //fin procesar foto

            //insertar equipo
            $sqlAgregarEquipo = "INSERT INTO equipos (nombre,idCategoria,foto,idEdicion) values ('$nombre', $categoria, '{$foto}', $idEdicion)";
            $resultadoAgregarEquipo = mysqli_query($con, $sqlAgregarEquipo);
            if (mysqli_error($con)) {
                echo "<script>alert('Error no se pudo insertar el registro');</script>";
            } else {
                echo "<script>alert('Equipo Agregado con Exito');</script>";
            }
        }
        echo "<script>window.location='index.php?modulo=listado-equipos&idEdicion=$idEdicion';</script>";
    }
}

?>

</html>