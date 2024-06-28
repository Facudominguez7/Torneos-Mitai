<?php
if (!empty($_GET['accion'])) {
    $idCategoria = $_GET['idCategoria'];
    $idEdicion = $_GET['idEdicion'];
    if ($_GET['accion'] == 'agregarSemifinal') {
        // Obtener valores del formulario
        $equipoLocal = $_POST['equipoLocal'];
        $equipoVisitante = $_POST['equipoVisitante'];
        $horario = $_POST['horario'];
        $cancha = $_POST['cancha'];
        $dia = $_POST['dia'];
        $copa = $_POST['copa'];

        // Validar que los campos no estén vacíos
        if (empty($equipoLocal) || empty($equipoVisitante) || empty($horario) || empty($cancha) || empty($dia)) {
            echo "<script>alert('Todos los campos son obligatorios.');</script>";
        } elseif ($equipoLocal == $equipoVisitante) {
            echo "<script>alert('No se puede seleccionar el mismo equipo como local y visitante.');</script>";
        } else {
            // Verificar si el partido ya existe para esos equipos y esa categoría
            $sqlVerificarPartido = "SELECT COUNT(*) AS count FROM semifinales 
            WHERE idCategoria = ? AND ((idEquipoLocal = ? AND idEquipoVisitante = ?) OR (idEquipoLocal = ? AND idEquipoVisitante = ?))";
            $stmtVerificarPartido = mysqli_prepare($con, $sqlVerificarPartido);
            if (!$stmtVerificarPartido) {
                die("Error en la consulta: " . mysqli_error($con));
            }
            mysqli_stmt_bind_param($stmtVerificarPartido, "iiiii", $idCategoria, $equipoLocal, $equipoVisitante, $equipoVisitante, $equipoLocal);
            mysqli_stmt_execute($stmtVerificarPartido);
            $resultVerificarPartido = mysqli_stmt_get_result($stmtVerificarPartido);
            $rowPartido = mysqli_fetch_assoc($resultVerificarPartido);

            if ($rowPartido['count'] > 0) {
                echo "<script>alert('El partido ya está programado para estos equipos en esta categoría.');</script>";
            } else {
                // Insertar el partido si los equipos están disponibles
                $sqlInsertarPartido = "INSERT INTO semifinales (idCategoria, idEquipoLocal, idEquipoVisitante, horario, cancha, idDia, idCopa, idEdicion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmtPartido = mysqli_prepare($con, $sqlInsertarPartido);
                if (!$stmtPartido) {
                    die("Error en la consulta: " . mysqli_error($con));
                }
                mysqli_stmt_bind_param($stmtPartido, "iiisiiii", $idCategoria, $equipoLocal, $equipoVisitante, $horario, $cancha, $dia, $copa, $idEdicion);

                if (mysqli_stmt_execute($stmtPartido)) {
                    echo "<script>alert('Partido programado correctamente');</script>";
                } else {
                    echo "<script>alert('Error al programar el partido: " . mysqli_error($con) . "');</script>";
                }
                echo "<script>window.location='index.php?modulo=semifinal-nueva&idCategoria=" . $idCategoria . "&idEdicion=". $idEdicion ."';</script>";
            }
        }
    }
}
?>
<section>
    <div class="flex items-center justify-center p-12">
        <div class="mx-auto w-full max-w-[550px]">
            <form action="index.php?modulo=agregar-semis-nueva&accion=agregarSemifinal&idCategoria=<?php echo $idCategoria ?>&idEdicion=<?php echo $idEdicion?>" method="POST">
                <div class="mb-5">
                    <label for="equipoLocal" class="mb-3 block text-base font-medium text-white">
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
                    <label for="equipoVisitante" class="mb-3 block text-base font-medium text-white">
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
                    <label for="horario" class="mb-3 block text-base font-medium text-white">
                        Horario del Partido Formato 00:00
                    </label>
                    <input type="text" id="horario" name="horario" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                </div>
                <div class="mb-5">
                    <label for="cancha" class="mb-3 block text-base font-medium text-white">
                        Número de Cancha
                    </label>
                    <input type="number" id="cancha" name="cancha" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                </div>
                <div class="mb-5">
                    <label for="dia" class="mb-3 block text-base font-medium text-white">
                        Seleccione el día
                    </label>
                    <?php
                    $sqlMostrarDia = "SELECT * FROM dias";
                    $stmt = mysqli_prepare($con, $sqlMostrarDia);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    ?>
                    <select name="dia" id="dia" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($fila = mysqli_fetch_array($result)) {
                        ?>
                                <option value="<?php echo $fila['id'] ?>"><?php echo $fila['diaPartido'] ?></option>
                        <?php
                            }
                        } else {
                            echo "<option value=''>No hay días disponibles</option>";
                        }
                        ?>
                    </select>
                </div>
                <?php
                if ($idCategoria == 4 || $idCategoria == 3 || $idCategoria == 2) {
                ?>
                    <div class="mb-5">
                        <label for="copa" class="mb-3 block text-base font-medium text-white">
                            Seleccione la Copa
                        </label>
                        <?php
                        $sqlMostrarCopa = "SELECT * FROM copas";
                        $stmt = mysqli_prepare($con, $sqlMostrarCopa);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        ?>
                        <select name="copa" id="copa" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($fila = mysqli_fetch_array($result)) {
                            ?>
                                    <option value="<?php echo $fila['id'] ?>"><?php echo $fila['nombre'] ?></option>
                            <?php
                                }
                            } else {
                                echo "<option value=''>No hay Copas disponibles</option>";
                            }
                            ?>
                        </select>
                    </div>
                <?php
                } else {
                ?>
                    <input class="hidden" type="number" value="0" name="copa" id="copa">
                <?php
                }
                ?>
                <div>
                    <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Programar Partido
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
