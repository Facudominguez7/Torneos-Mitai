<?php
if (!empty($_GET['accion'])) {
    $fecha = $_GET['idFecha'];
    $grupo = $_GET['idGrupo'];
    $idCategoria = $_GET['idCategoria'];
    if ($_GET['accion'] == 'agregarFixture') {
        // Obtener valores del formulario
        $equipoLocal = $_POST['equipoLocal'];
        $equipoVisitante = $_POST['equipoVisitante'];
        $horario = $_POST['horario'];
    
        if ($equipoLocal == $equipoVisitante) {
            echo "<script>alert('No se puede seleccionar el mismo equipo como local y visitante.');</script>";
        } else {
            // Verificar si alguno de los equipos ya tiene un partido en esta fecha y grupo
            $sqlVerificarEquipos = "SELECT COUNT(*) AS count FROM partidos 
                WHERE idFechas = ? AND idGrupo = ? AND (idEquipoLocal IN (?, ?) OR idEquipoVisitante IN (?, ?))";
            $stmtVerificarEquipos = mysqli_prepare($con, $sqlVerificarEquipos);
            mysqli_stmt_bind_param($stmtVerificarEquipos, "iiiiii", $fecha, $grupo, $equipoLocal, $equipoVisitante, $equipoLocal, $equipoVisitante);
            mysqli_stmt_execute($stmtVerificarEquipos);
            $resultVerificarEquipos = mysqli_stmt_get_result($stmtVerificarEquipos);
            $rowEquipos = mysqli_fetch_assoc($resultVerificarEquipos);
    
            if ($rowEquipos['count'] > 0) {
                echo "<script>alert('Al menos uno de los equipos ya tiene un partido en esta fecha y grupo');</script>";
            } else {
                // Insertar el partido si los equipos están disponibles
                $sqlInsertarPartido = "INSERT INTO partidos (idEquipoLocal, idEquipoVisitante, idFechas, idGrupo, horario) VALUES (?, ?, ?, ?, ?)";
                $stmtPartido = mysqli_prepare($con, $sqlInsertarPartido);
                mysqli_stmt_bind_param($stmtPartido, "iiiss", $equipoLocal, $equipoVisitante, $fecha, $grupo, $horario);
    
                if (mysqli_stmt_execute($stmtPartido)) {
                    echo "<script>alert('Partido programado correctamente');</script>";
                } else {
                    echo "<script>alert('Error al programar el partido');</script>";
                }
            }
        }
        echo "<script>window.location='index.php?modulo=categoria-2010&id=" . $idCategoria . "&fecha=" . $fecha . "';</script>";
    }
  
}
?>

<body>
    <div class="flex items-center justify-center p-12">
        <!-- Author: FormBold Team -->
        <!-- Learn More: https://formbold.com -->
        <div class="mx-auto w-full max-w-[550px]">
            <form action="index.php?modulo=agregar-fixture&accion=agregarFixture&idCategoria=<?php echo $idCategoria ?>&idGrupo=<?php echo $grupo ?>&idFecha=<?php echo $fecha ?>" method="POST">
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