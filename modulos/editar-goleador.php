<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<div class="flex items-center justify-center p-12">
    <!-- Author: FormBold Team -->
    <!-- Learn More: https://formbold.com -->
    <div class="mx-auto w-full max-w-[550px]">
        <?php
        if (isset($_GET['accion'])) {
            $idJugador = $_GET['id'];
            $sql = "SELECT t.id, t.nombre, t.cantidadGoles, t.idEdicion, t.idCategoria From tabla_goleadores as t WHERE t.id = $idJugador";
            $sql = mysqli_query($con, $sql);
            if (mysqli_num_rows($sql) != 0) {
                $r = mysqli_fetch_array($sql);
            }
        }
        ?>
        <form action="index.php?modulo=editar-goleador&accion=editar-goleador&id=<?php echo $_GET['id']?>" method="POST">
            <div class="mb-5">
                <label for="nombre" class="mb-3 block text-base font-medium text-white">
                    Editar Nombre del Jugador
                </label>
                <input type="text" name="jugador" id="jugador" value="<?php echo $r['nombre']; ?>" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
            </div>
            <div class="mb-5">
                <label for="nombre" class="mb-3 block text-base font-medium text-white">
                    Editar Goles
                </label>
                <input type="number" name="goles" id="goles" value="<?php echo $r['cantidadGoles']; ?>" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                <input type="number" name="idJugador" id="idJugador" value="<?php echo $r['id']; ?>" class="hidden w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                <input type="number" name="idCategoria" id="idCategoria" value="<?php echo $r['idCategoria']; ?>" class="hidden w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                <input type="number" name="idEdicion" id="idEdicion" value="<?php echo $r['idEdicion']; ?>" class="hidden w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
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
if (isset($_GET['accion'])) {
    if ($_GET['accion'] == 'editar-goleador') {
        $jugador = $_POST['jugador'];
        $idJugador = $_POST['idJugador'];
        $idEdicion = $_POST['idEdicion'];
        $idCategoria = $_POST['idCategoria'];
        $goles = $_POST['goles'];

        $sql = "UPDATE tabla_goleadores SET nombre = '$jugador', cantidadGoles = $goles WHERE id = $idJugador";
        $sql = mysqli_query($con, $sql);

        if (!mysqli_error($con))
            echo "<script> alert('JUGADOR editado con exito');</script>";
        else
            echo "<script> alert('ERROR NO SE PUDO editar el jugador);</script>";

        echo "<script>window.location='index.php?modulo=tabla-goleadores&idEdicion=" . $idEdicion . "&idCategoria=" . $idCategoria . "';</script>";
    }
}
?>