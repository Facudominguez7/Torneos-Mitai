<?php
if (!empty($_GET['accion'])) {
    $idPartido = $_GET['idPartido'];
    $idGrupo = $_GET['idGrupo'];
    $idFecha = $_GET['idFecha'];
    $idCategoria = $_GET['idCategoria'];
    if ($_GET['accion'] == 'cargarResultado') {
        $golesEquipoLocal = $_POST['golesEquipoLocal'];
        $golesEquipoVisitante = $_POST['golesEquipoVisitante'];
        $jugado = 1;

        // Actualizar los resultados del partido en la tabla partidos
        $sqlActualizarResultado = "UPDATE partidos SET golesEquipoLocal = ?, golesEquipoVisitante = ?, jugado = ? WHERE id = ?";
        $stmtActualizarResultado = mysqli_prepare($con, $sqlActualizarResultado);
        mysqli_stmt_bind_param($stmtActualizarResultado, "iiii", $golesEquipoLocal, $golesEquipoVisitante, $jugado, $idPartido);
        mysqli_stmt_execute($stmtActualizarResultado);

        function verificarEquipoEnTablaPosiciones($con, $idEquipo, $idGrupo)
        {
            $sqlVerificarEquipo = "SELECT COUNT(*) AS count FROM tabla_posiciones WHERE idEquipo = ? AND idGrupo = ?";
            $stmtVerificarEquipo = mysqli_prepare($con, $sqlVerificarEquipo);
            mysqli_stmt_bind_param($stmtVerificarEquipo, "ii", $idEquipo, $idGrupo);
            mysqli_stmt_execute($stmtVerificarEquipo);
            $resultVerificarEquipo = mysqli_stmt_get_result($stmtVerificarEquipo);
            $row = mysqli_fetch_assoc($resultVerificarEquipo);
            return $row['count'] > 0;
        }

        function agregarEquipoATablaPosiciones($con, $idEquipo, $idGrupo)
        {
            $sqlAgregarEquipo = "INSERT INTO tabla_posiciones (idEquipo, idGrupo, golesFavor, golesContra, jugado, ganado, empatado, puntos) VALUES (?, ?, 0, 0, 0, 0, 0, 0)";
            $stmtAgregarEquipo = mysqli_prepare($con, $sqlAgregarEquipo);
            mysqli_stmt_bind_param($stmtAgregarEquipo, "ii", $idEquipo, $idGrupo);
            mysqli_stmt_execute($stmtAgregarEquipo);
            return mysqli_stmt_affected_rows($stmtAgregarEquipo);
            
        }

        // Verificar y agregar equipos ausentes en la tabla de posiciones
        function verificarYAgregarEquipo($con, $idEquipo, $idGrupo)
        {
            if (!verificarEquipoEnTablaPosiciones($con, $idEquipo, $idGrupo)) {
                agregarEquipoATablaPosiciones($con, $idEquipo, $idGrupo);
            }
        }


        //Obtener los datos de los equipos involucrados
        $sqlDatosEquiposInvolucrados = "SELECT idEquipoLocal, idEquipoVisitante FROM partidos WHERE id = ?";
        $stmtDatosEquiposInvolucrados = mysqli_prepare($con, $sqlDatosEquiposInvolucrados);
        mysqli_stmt_bind_param($stmtDatosEquiposInvolucrados, "i", $idPartido);
        mysqli_stmt_execute($stmtDatosEquiposInvolucrados);
        $resultDatosEquiposInvolucrados = mysqli_stmt_get_result($stmtDatosEquiposInvolucrados);
        $filaDatosEquiposInvolucrados = mysqli_fetch_assoc($resultDatosEquiposInvolucrados);

        $idEquipoLocal = $filaDatosEquiposInvolucrados['idEquipoLocal'];
        $idEquipoVisitante = $filaDatosEquiposInvolucrados['idEquipoVisitante'];

        // Verificar y agregar equipos ausentes en la tabla de posiciones
        verificarYAgregarEquipo($con, $idEquipoLocal, $idGrupo);
        verificarYAgregarEquipo($con, $idEquipoVisitante, $idGrupo);

        function actualizarTablaPosiciones($con, $idEquipo, $idGrupo, $golesFavor, $golesContra, $puntos, $ganados, $empatados)
        {
            $diferenciaGoles = $golesFavor - $golesContra;
            $perdidos = 0;
            if ($ganados == 0 && $empatados == 0) {
                $perdidos = 1; // Si no ganó ni empató, se cuenta como perdido
            }
             $sqlUpdateEquipo = "UPDATE tabla_posiciones SET 
                golesFavor = golesFavor + ?, 
                golesContra = golesContra + ?,
                diferenciaGoles = diferenciaGoles + ?,
                jugado = jugado + 1,
                ganado = ganado + ?, 
                empatado = empatado + ?,
                perdido = perdido + ?,
                puntos = puntos + ?
                WHERE idEquipo = ? AND idGrupo = ?";

            $stmtUpdateEquipo = mysqli_prepare($con, $sqlUpdateEquipo);
            mysqli_stmt_bind_param($stmtUpdateEquipo, "iiiiiiiii", $golesFavor, $golesContra, $diferenciaGoles, $ganados, $empatados, $perdidos, $puntos, $idEquipo, $idGrupo);
            mysqli_stmt_execute($stmtUpdateEquipo);

            return mysqli_stmt_affected_rows($stmtUpdateEquipo);
        }

        //Calcular resultados para el equipo local y visitante
        $ganadosLocal = 0;
        $ganadosVisitante = 0;
        $empatadosLocal = 0;
        $empatadosVisitante = 0;

        $puntosLocal = 0;
        $puntosVisitante = 0;

        //Determinar si hubo un ganador o empate
        if ($golesEquipoLocal > $golesEquipoVisitante) {
            $ganadosLocal = 1;
            $puntosLocal = 3;
        } else if ($golesEquipoLocal < $golesEquipoVisitante) {
            $ganadosVisitante = 1;
            $puntosVisitante = 3;
        } else {
            $empatadosLocal = 1;
            $empatadosVisitante = 1;
            $puntosLocal = 1;
            $puntosVisitante = 1;
        }

        // Para el equipo local
        actualizarTablaPosiciones($con, $idEquipoLocal, $idGrupo, $golesEquipoLocal, $golesEquipoVisitante, $puntosLocal, $ganadosLocal, $empatadosLocal);

        // Para el equipo visitante
        actualizarTablaPosiciones($con, $idEquipoVisitante, $idGrupo, $golesEquipoVisitante, $golesEquipoLocal, $puntosVisitante, $ganadosVisitante, $empatadosVisitante);

        echo "<script>window.location='index.php?modulo=categoria-2010&id=" . $idCategoria . "&fecha=" . $idFecha . "';</script>";
    }
}

?>

<section>
    <div class="flex items-center justify-center p-12">
        <div class="mx-auto w-full max-w-[550px]">
            <form action="index.php?modulo=cargar-resultado&accion=cargarResultado&idCategoria=<?php echo $idCategoria ?>&idPartido=<?php echo $idPartido ?>&idGrupo=<?php echo $idGrupo ?>&idFecha=<?php echo $idFecha ?>" method="POST">
                <?php
                $sqlMostrarEquipoLocal = "SELECT partidos.id, equipos.nombre AS nombreEquipoLocal
                    FROM partidos
                    INNER JOIN equipos ON partidos.idEquipoLocal = equipos.id
                    WHERE partidos.id = ?";
                $stmtMostrarEquipoLocal = mysqli_prepare($con, $sqlMostrarEquipoLocal);
                mysqli_stmt_bind_param($stmtMostrarEquipoLocal, "i", $idPartido);
                mysqli_stmt_execute($stmtMostrarEquipoLocal);
                $resultMostrarEquipoLocal = mysqli_stmt_get_result($stmtMostrarEquipoLocal);

                if ($resultMostrarEquipoLocal->num_rows > 0) {
                    $filaEquipoLocal = mysqli_fetch_assoc($resultMostrarEquipoLocal);
                    $nombreEquipoLocal = $filaEquipoLocal['nombreEquipoLocal'];
                ?>
                    <div class="mb-5">
                        <div class="mb-5">
                            <label for="golesEquipoLocal" class="mb-3 block text-base font-medium text-white">
                                Anotar goles del Equipo: <?php echo $nombreEquipoLocal ?>
                            </label>
                            <input type="number" id="golesEquipoLocal" name="golesEquipoLocal" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                        </div>
                    </div>
                <?php
                } else {
                    echo "No se encontró el partido con el ID especificado.";
                }
                ?>

                <?php
                $sqlMostrarEquipoVisitante = "SELECT partidos.id, equipos.nombre AS nombreEquipoVisitante
                    FROM partidos
                    INNER JOIN equipos ON partidos.idEquipoVisitante = equipos.id
                    WHERE partidos.id = ?";
                $stmtMostrarEquipoVisitante = mysqli_prepare($con, $sqlMostrarEquipoVisitante);
                mysqli_stmt_bind_param($stmtMostrarEquipoVisitante, "i", $idPartido);
                mysqli_stmt_execute($stmtMostrarEquipoVisitante);
                $resultMostrarEquipoVisitante = mysqli_stmt_get_result($stmtMostrarEquipoVisitante);

                if ($resultMostrarEquipoVisitante->num_rows > 0) {
                    $filaEquipoVisitante = mysqli_fetch_assoc($resultMostrarEquipoVisitante);
                    $nombreEquipoVisitante = $filaEquipoVisitante['nombreEquipoVisitante'];
                ?>
                    <div class="mb-5">
                        <div class="mb-5">
                            <label for="golesEquipoVisitante" class="mb-3 block text-base font-medium text-white">
                                Anotar goles del Equipo: <?php echo $nombreEquipoVisitante ?>
                            </label>
                            <input type="number" id="golesEquipoVisitante" name="golesEquipoVisitante" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                        </div>
                    </div>
                <?php
                } else {
                    echo "No se encontró el partido con el ID especificado.";
                }
                ?>
                <div>
                    <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Cargar Resultado
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>