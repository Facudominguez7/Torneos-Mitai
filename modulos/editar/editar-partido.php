<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<div class="flex items-center justify-center p-12">
    <div class="mx-auto w-full max-w-[550px]">
        <?php
        if (isset($_GET['accion'])) {
            $idPartido = $_GET['idPartido'];
            $sql = "SELECT p.*, e_local.nombre AS equipo_local, e_visitante.nombre AS equipo_visitante 
            FROM partidos p 
            JOIN equipos e_local ON p.idEquipoLocal = e_local.id 
            JOIN equipos e_visitante ON p.idEquipoVisitante = e_visitante.id 
            WHERE p.id = $idPartido";
            $sql = mysqli_query($con, $sql);
            if (mysqli_num_rows($sql) != 0) {
                $r = mysqli_fetch_array($sql);
            }
        }
        ?>
        <form action="index.php?modulo=editar-partido&accion=editar-partido&id=<?php echo $idPartido ?>" method="POST" enctype="multipart/form-data">
        <?php
            $idCategoria = $_GET['idCategoria'];
            $sql = "SELECT e.id, e.nombre FROM equipos e WHERE idCategoria = $idCategoria";
            $sql = mysqli_query($con, $sql);
            if (mysqli_num_rows($sql) != 0) {
                $re = mysqli_fetch_array($sql);
            }
        ?>
            <select name="equipoLocal" id="equipoLocal" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                <option value="<?php echo $re['id'] ?>"><?php echo $re['nombre'] ?></option>
            </select>
            <div class="mb-5">
                <label for="foto" class="mb-3 block text-base font-medium text-white">
                    Editar Logo
                </label>
                <img class="h-24 w-24 mb-5" src="Imagenes/<?php echo $r['foto']; ?>" alt="logo <?php echo $r['nombre']; ?>">
                <input type="file" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" id="foto" name="foto">
            </div>
            <div>
                <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                    Editar
                </button>
            </div>
        </form>
    </div>
</div>

<?php
if ($_GET['accion'] == 'editar-equipo') {
    $nombreEquipo = $_POST['nombre'];
    $idEquipo = $_GET['id'];
    $idEdicion = $_POST['idEdicion'];
    if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
        $nombre = explode('.', $_FILES['foto']['name']);
        $foto = time() . '.' . end($nombre);
        copy($_FILES['foto']['tmp_name'], 'Imagenes/' . $foto);

        //armo la cadena para editar las fotos
        $mas_datos = ", foto='" . $foto . "'";
    } else {
        $mas_datos = '';
    }

    $sql = "UPDATE equipos SET nombre = '$nombreEquipo' {$mas_datos} WHERE id = $idEquipo";
    $sql = mysqli_query($con, $sql);

    if (!mysqli_error($con))
        echo "<script> alert('EQUIPO editado con exito');</script>";
    else
        echo "<script> alert('ERROR NO SE PUDO editar el equipo);</script>";

    echo "<script>window.location='index.php?modulo=listado-equipos&idEdicion=" . $idEdicion . "';</script>";
}

?>