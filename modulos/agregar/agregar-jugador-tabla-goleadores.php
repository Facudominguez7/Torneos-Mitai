<!doctype html>
<html lang="es">
<?php
if (!empty([$_GET['accion']])) {
    if ($_GET['accion'] == 'agregar-jugador') {
        $nombre = $_POST['jugador'];
        $categoria = $_POST['categoria'];
        $edicion = $_POST['edicion'];
        $equipo = $_POST['equipo'];
        $goles = $_POST['goles'];
        //Verifico que no exista ese equipo
        $sql = "SELECT * FROM tabla_goleadores where nombre = '$nombre' AND idCategoria = $categoria AND idEdicion = $edicion AND cantidadGoles = $goles";
        $sql = mysqli_query($con, $sql);
        if (mysqli_num_rows($sql) != 0) {
            echo "<script> alert('EL JUGADOR YA EXISTE EN LA BD');</script>";
        } else {

            //insertar jugador
            $sql = "INSERT INTO tabla_goleadores (nombre,idCategoria,idEquipo,idEdicion, cantidadGoles) values ('$nombre', $categoria, '$equipo', $edicion, $goles)";
            $resultado = mysqli_query($con, $sql);
            if (mysqli_error($con)) {
                echo "<script>alert('Error no se pudo insertar el registro');</script>";
            } else {
                echo "<script>alert('Jugador Agregado con Exito');</script>";
            }
        }
        echo "<script>window.location='index.php?modulo=tabla-goleadores&idCategoria=$categoria&idEdicion=$edicion';</script>";
    }
}

?>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<header class="bg-[--color-primary] shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
        <?php
        $idEdicion = $_GET['idEdicion'];
        $idCategoria = $_GET['idCategoria'];
        $sql = "SELECT categorias.nombreCategoria AS categoria, categorias.id FROM categorias 
                       WHERE categorias.idEdicion = $idEdicion AND categorias.id = $idCategoria";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows > 0) {
            while ($r = mysqli_fetch_array($result)) {
        ?>
                <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
                    Tabla de Goleadores <?php echo $r['categoria'] ?>
                </h1>
                <br />
        <?php
            }
        }
        ?>
    </div>
</header>

<body>
    <div class="flex items-center justify-center p-12">
        <!-- Author: FormBold Team -->
        <!-- Learn More: https://formbold.com -->
        <div class="mx-auto w-full max-w-[550px]">
            <?php $idEdicion = $_GET['idEdicion'] ?>
            <form action="index.php?modulo=agregar-jugador-tabla-goleadores&accion=agregar-jugador" method="POST">
                <div class="mb-5">
                    <label for="nombre" class="mb-3 block text-base font-medium text-white">
                        Jugador
                    </label>
                    <input type="text" name="jugador" id="jugador" placeholder="Apellido y Nombre" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div class="mb-5">
                    <label for="category" class="mb-3 block text-base font-medium text-white">
                        Equipo del Jugador
                    </label>
                    <select name="equipo" id="equipo" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                        <?php
                        $idEdicion = $_GET['idEdicion'];
                        $idCategoria = $_GET['idCategoria'];
                        $sql = "SELECT equipos.nombre AS equipo, equipos.id FROM equipos 
                             WHERE equipos.idEdicion = $idEdicion AND equipos.idCategoria = $idCategoria";
                        $stmt = mysqli_prepare($con, $sql);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        if ($result->num_rows > 0) {
                            while ($r = mysqli_fetch_array($result)) {
                        ?>
                                <option value="<?php echo $r['id'] ?>"><?php echo $r['equipo'] ?></option>
                            <?php
                            }
                        } else {
                            ?>
                            <h1>No se agregaron equipos para esta edicion de mitai</h1>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="goles" class="mb-3 block text-base font-medium text-white">
                        Goles
                    </label>
                    <input type="number" name="goles" id="goles"  class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <input type="text" name="edicion" id="edicion" value="<?php echo $_GET['idEdicion'] ?>" class="hidden w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                <input type="text" name="categoria" id="categoria" value="<?php echo $_GET['idCategoria'] ?>" class="hidden w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                <div>
                    <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Agregar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>