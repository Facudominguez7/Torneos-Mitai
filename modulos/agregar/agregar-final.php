<?php
if (!empty($_GET['accion'])) {
    $idEdicion = $_GET['idEdicion'];
    $idCategoria = $_GET['idCategoria'];
    if ($_GET['accion'] == 'agregarFinal') {
        // Obtener valores del formulario
        $equipoLocal = $_POST['equipoLocal'];
        $equipoVisitante = $_POST['equipoVisitante'];
        $horario = $_POST['horario'];
        $cancha = $_POST['cancha'];
        $dia = $_POST['dia'];
        $copa = $_POST['copa'];

        if ($equipoLocal == $equipoVisitante) {
            echo "<script>alert('No se puede seleccionar el mismo equipo como local y visitante.');</script>";
        } else {
            // Verificar si el partido ya existe para esos equipos y esa copa
            $sqlVerificarPartido = "SELECT COUNT(*) AS count FROM finales 
                                    WHERE idCopa = ? AND ((idEquipoLocal = ? AND idEquipoVisitante = ?) 
                                    OR (idEquipoLocal = ? AND idEquipoVisitante = ?))";
            $stmtVerificarPartido = mysqli_prepare($con, $sqlVerificarPartido);
            mysqli_stmt_bind_param($stmtVerificarPartido, "iiiii", $copa, $equipoLocal, $equipoVisitante, $equipoVisitante, $equipoLocal);
            mysqli_stmt_execute($stmtVerificarPartido);
            $resultVerificarPartido = mysqli_stmt_get_result($stmtVerificarPartido);
            $rowPartido = mysqli_fetch_assoc($resultVerificarPartido);

            if ($rowPartido['count'] > 0) {
                echo "<script>alert('Al menos uno de los equipos ya tiene un partido en esta instancia');</script>";
            } else {
                // Insertar el partido si los equipos están disponibles
                $sqlInsertarPartido = "INSERT INTO finales (idCategoria, idEquipoLocal, idEquipoVisitante, horario, cancha, idDia, idCopa, idEdicion) 
                                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmtPartido = mysqli_prepare($con, $sqlInsertarPartido);
                mysqli_stmt_bind_param($stmtPartido, "iiiisiii",$idCategoria, $equipoLocal, $equipoVisitante, $horario, $cancha, $dia, $copa, $idEdicion);

                if (mysqli_stmt_execute($stmtPartido)) {
                    echo "<script>alert('Partido programado correctamente');</script>";
                } else {
                    echo "<script>alert('Error al programar el partido');</script>";
                    // Mostrar error específico
                    echo mysqli_error($con);
                }
                echo "<script>window.location='index.php?modulo=final&idCategoria=" . $idCategoria . "&idEdicion=" . $idEdicion . "';</script>";
            }
        }
    }
}
?>
<header class="bg-[--color-primary] shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
        <?php
        $idCopa = $_GET['idCopa'];
        $sqlMostrarTipoFinal = "SELECT copas.nombre FROM copas WHERE copas.id = $idCopa";
        $consultaNombre = mysqli_prepare($con, $sqlMostrarTipoFinal);
        mysqli_stmt_execute($consultaNombre);
        $resultNombreCop = mysqli_stmt_get_result($consultaNombre);

        if ($resultNombreCop->num_rows > 0) {
            while ($filaCop = mysqli_fetch_array($resultNombreCop)) {
        ?>
                <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
                    Final <?php echo $filaCop['nombre'] ?>
                </h1>
                <br />
        <?php
            }
        }
        ?>
    </div>
</header>
<section>
    <div class="flex items-center justify-center p-12">
        <div class="mx-auto w-full max-w-[550px]">
            <form action="index.php?modulo=agregar-final&accion=agregarFinal&idCategoria=<?php echo $idCategoria ?>&idEdicion=<?php echo $idEdicion ?>" method="POST">
                <div class="mb-5">
                    <label for="equipoLocal" class="mb-3 block text-base font-medium text-white">
                        Seleccione el Equipo Local
                    </label>
                    <?php
                    $idEdicion = $_GET['idEdicion'];
                    // Determinar la tabla de equipos según el idCopa
                    if ($idCopa == 1) {
                        $sqlMostrarEquipos = "SELECT equipos.id AS idEquipo, equipos.nombre AS nombreEquipo
                        FROM equipos
                        INNER JOIN equipos_ganadores_semifinales_unicas as egsu ON equipos.id = egsu.idEquipo
                        WHERE egsu.idEdicion = $idEdicion AND egsu.idCategoria = $idCategoria";
                    } else if ($idCopa == 2) {
                        $sqlMostrarEquipos = "SELECT equipos.id AS idEquipo, equipos.nombre AS nombreEquipo
                        FROM equipos
                        INNER JOIN equipos_perdedores_semifinales_unicas AS epsu ON equipos.id = epsu.idEquipo
                        WHERE epsu.idEdicion = $idEdicion AND epsu.idCategoria = $idCategoria";
                    }
                    $stmt = mysqli_prepare($con, $sqlMostrarEquipos);
                    $stmt = mysqli_prepare($con, $sqlMostrarEquipos);
                    if ($stmt === false) {
                        die('Error en la consulta SQL: ' . mysqli_error($con));
                    }
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    ?>
                    <select name="equipoLocal" id="equipoLocal" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($fila = mysqli_fetch_array($result)) {
                        ?>
                                <option value="<?php echo $fila['idEquipo'] ?>"><?php echo $fila['nombreEquipo'] ?></option>
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
                    $stmt = mysqli_prepare($con, $sqlMostrarEquipos);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    ?>
                    <select name="equipoVisitante" id="equipoVisitante" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($fila = mysqli_fetch_array($result)) {
                        ?>
                                <option value="<?php echo $fila['idEquipo'] ?>"><?php echo $fila['nombreEquipo'] ?></option>
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
                        Horario del Partido (Formato 00:00)
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
                        Día
                    </label>
                    <?php
                    // Consulta para obtener el último día agregado
                    $sqlMostrarDia = "SELECT * FROM dias ORDER BY id DESC LIMIT 1";
                    $stmt = mysqli_prepare($con, $sqlMostrarDia);
                    if ($stmt === false) {
                        die('Error en la consulta SQL: ' . mysqli_error($con));
                    }
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

                <div class="mb-5">
                    <label for="copa" class="mb-3 block text-base font-medium text-white">
                        Copa
                    </label>
                    <?php
                    $idCopa = $_GET['idCopa'];
                    $sqlMostrarCopa = "SELECT * FROM copas WHERE id = $idCopa"; // Copas de Oro y Plata
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
                            echo "<option value=''>No hay copas disponibles</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <button type="submit" class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                        Programar Partido
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>