<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<div class="flex items-center justify-center p-12">
    <div class="mx-auto w-full max-w-[550px]">
        <?php
        if ($_GET['accion'] == 'editar') {
            $idPartido = $_GET['idPartido'];
            $idFecha = $_GET['idFecha'];
            $idEdicion = $_GET['idEdicion'];
            $idCategoria = $_GET['idCategoria'];
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
        <form action="index.php?modulo=editar-partido&accion=editar-partido&idPartido=<?php echo $idPartido ?>&idCategoria=<?php echo $idCategoria?>" method="POST">
            <?php
            $idCategoria = $_GET['idCategoria'];
            $sql = "SELECT e.id, e.nombre FROM equipos e WHERE idCategoria = $idCategoria";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            ?>
            <label for="foto" class="mb-3 block text-base font-medium text-white">
                Editar Equipo Local
            </label>
            <select name="equipoLocal" id="equipoLocal" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md mb-5" required>
                <?php
                if ($result->num_rows > 0) {
                    while ($fila = mysqli_fetch_array($result)) {
                ?>
                        <option value="<?php echo $fila['id'] ?>"><?php echo $fila['nombre'] ?></option>
                <?php
                    }
                }
                ?>
            </select>
            <?php
            $idCategoria = $_GET['idCategoria'];
            $sql = "SELECT e.id, e.nombre FROM equipos e WHERE idCategoria = $idCategoria";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            ?>
            <label for="foto" class="mb-3 block text-base font-medium text-white">
                Editar Equipo Visitante
            </label>
            <select name="equipoVisitante" id="equipoVisitante" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md mb-5" required>
                <?php
                if ($result->num_rows > 0) {
                    while ($fila = mysqli_fetch_array($result)) {
                ?>
                        <option value="<?php echo $fila['id'] ?>"><?php echo $fila['nombre'] ?></option>
                <?php
                    }
                }
                ?>
            </select>
            <div class="mb-5">
                <div class="mb-5">
                    <label for="horario" class="mb-3 block text-base font-medium text-white">
                        Editar Horario del Partido Formato 00:00
                    </label>
                    <input type="text" id="horario" name="horario" value="<?php echo $r['horario'] ?>" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                </div>
            </div>
            <div class="mb-5">
                <div class="mb-5">
                    <label for="horario" class="mb-3 block text-base font-medium text-white">
                        Editar Cancha
                    </label>
                    <input type="number" id="cancha" name="cancha" value="<?php echo $r['cancha'] ?>" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                </div>
            </div>
            <input type="number" class="hidden" name="idEdicion" id="idEdicion" value="<?php echo $idEdicion?>">
            <input type="number" class="hidden" name="idCategoria" id="idCategoria" value="<?php echo $idCategoria?>">
            <input type="number" class="hidden" name="idFecha" id="idFecha" value="<?php echo $idFecha?>">
            <div>
                <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                    Editar
                </button>
            </div>
        </form>
    </div>
</div>

<?php
     if ($_GET['accion'] == 'editar-partido') {
        $idequipoLocal = $_POST['equipoLocal'];
        $idequipoVisitante = $_POST['equipoVisitante'];
        $horario = $_POST['horario'];
        $cancha = $_POST['cancha'];
        $idPartido = $_GET['idPartido'];
        $idCategoria = $_POST['idCategoria'];
        $idFecha = $_POST['idFecha'];
        $idEdicion = $_POST['idEdicion'];

        $sqlInsertarPartido = "UPDATE partidos SET idEquipoLocal=?, idEquipoVisitante=?, horario=?, cancha=? WHERE id=?";
        $stmtPartido = mysqli_prepare($con, $sqlInsertarPartido);
        mysqli_stmt_bind_param($stmtPartido, "iisii", $idequipoLocal, $idequipoVisitante, $horario, $cancha, $idPartido);
        mysqli_stmt_execute($stmtPartido);

        if (!mysqli_error($con))
            echo "<script> alert('PARTIDO editado con exito');</script>";
        else
            echo "<script> alert('ERROR NO SE PUDO editar el equipo);</script>";

        echo "<script>window.location='index.php?modulo=categoria-2010&id=" . $idCategoria . "&fecha=" . $idFecha . "&idEdicion=" . $idEdicion . "';</script>";
    }
?>