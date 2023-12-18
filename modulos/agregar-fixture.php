<?php
if (!empty($_GET['accion'])) {
    if ($_GET['accion'] == 'agregarFixture') {
        //Obtengo los valores del formulario
        $equipoLocal = $_POST['equipoLocal'];
        $equipoVisitante = $_POST['equipoVisitante'];
        $Fecha = $_POST['fecha'];
        $grupo = $_POST['grupo'];
        $horario = $_POST['horario'];

        //Verifico si el equipo local y visitante son diferentes
        if ($equipoLocal !== $equipoVisitante) {
            //Insertar datos en la tabla partidos
            $sqlInsertarPartido = "INSERT INTO partidos (idEquipoLocal, idEquipoVisitante, idFechas, idGrupo, horario) VALUES (?, ?, ?, ?, ?)";
            $stmtPartido = mysqli_prepare($con, $sqlInsertarPartido);
            mysqli_stmt_bind_param($stmtPartido, "iiiss", $equipoLocal, $equipoVisitante, $fecha, $grupo, $horario);
        
            if (mysqli_stmt_execute($stmtPartido)){
                echo "<script> alert('Partido porgramado correctamente');</script>";
            } else {
                echo "<script> alert('Error al programar el partido');</script>";
            }
        } else {
            echo "<script> alert('No se puede seleccionar el mismo equipo como local y visitante.');</script>";
        }
        echo "<script>window.location='index.php?modulo=categoria-2010&id=1';</script>";
    }
}
?>

<body>
    <div class="flex items-center justify-center p-12">
        <!-- Author: FormBold Team -->
        <!-- Learn More: https://formbold.com -->
        <div class="mx-auto w-full max-w-[550px]">
            <form action="index.php?modulo=agregar-fixture&accion=agregarFixture" method="POST" enctype="multipart/form-data">
                <div class="mb-5">
                    <label for="equipo" class="mb-3 block text-base font-medium text-white">
                        Seleccione el Equipo Local
                    </label>
                    <?php
                    $idCategoria = $_GET['idCategoria'];
                    $sqlMostrarEquipos = "SELECT equipos.id , equipos.nombre
                    FROM equipos
                    WHERE idCategoria = $idCategoria";
                    $stmt = mysqli_prepare($con, $sqlMostrarEquipos);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    ?>
                    <select name="equipoLocal" id="equipoLocal" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($fila = mysqli_fetch_array($result)) {
                        ?>
                                <option value="<?php echo $fila['id'] ?>"><?php echo $fila['nombre'] ?></option>
                        <?php
                            }
                        } else {
                            echo "<option value=''>No hay equipos disponibles</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="grupo" class="mb-3 block text-base font-medium text-white">
                        Seleccione el Equipo Visitante
                    </label>
                    <?php
                    $sqlMostrarEquipos = "SELECT equipos.id , equipos.nombre
                    FROM equipos
                    WHERE idCategoria = $idCategoria";
                    $stmt = mysqli_prepare($con, $sqlMostrarEquipos);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    ?>
                    <select name="equipoVisitante" id="equipoVisitante" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($fila = mysqli_fetch_array($result)) {
                        ?>
                                <option value="<?php echo $fila['id'] ?>"><?php echo $fila['nombre'] ?></option>
                        <?php
                            }
                        } else {
                            echo "<option value=''>No hay equipos disponibles</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="fecha" class="mb-3 block text-base font-medium text-white">
                        Seleccione la Fecha
                    </label>
                    <?php
                    $sqlMostrarFechas = "SELECT fechas.id , fechas.nombre
                    FROM fechas
                    WHERE idCategoria = $idCategoria";
                    $stmt = mysqli_prepare($con, $sqlMostrarFechas);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    ?>
                    <select name="fecha" id="fecha" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($fila = mysqli_fetch_array($result)) {
                        ?>
                                <option value="<?php echo $fila['id'] ?>"><?php echo $fila['nombre'] ?></option>
                        <?php
                            }
                        } else {
                            echo "<option value=''>No hay grupos disponibles</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-5">
                    <div class="mb-5">
                        <label for="horario" class="mb-3 block text-base font-medium text-white">
                            Seleccione el Horario del Partido
                        </label>
                        <input type="datetime-local" id="horario" name="horario" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                    </div>
                </div>
                <div>
                    <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Programar Partido
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>