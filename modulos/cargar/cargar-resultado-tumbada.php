<?php
if (!empty($_GET['accion'])) {
    $idPartido = $_GET['idPartido'];
    $idCategoria = $_GET['idCategoria'];
    $idEdicion = $_GET['idEdicion'];
    if ($_GET['accion'] == 'cargarResultadoTumbada') {
        $golesEquipoLocal = $_POST['golesEquipoLocal'];
        $golesEquipoVisitante = $_POST['golesEquipoVisitante'];
        $penalesEquipoLocal = $_POST['penalesEquipoLocal'];
        $penalesEquipoVisitante = $_POST['penalesEquipoVisitante'];
        $idEquipoLocal = $_POST['idEquipoLocal'];
        $idEquipoVisitante = $_POST['idEquipoVisitante'];
        $jugado = $_POST['jugado'];

        // Actualizar los resultados del partido en la tabla semifinales
        $sqlActualizarResultado = "UPDATE tumbada SET golesEquipoLocal = ?, golesEquipoVisitante = ?, penalesEquipoLocal = ?, penalesEquipoVisitante = ?, jugado = ? WHERE id = ?";
        $stmtActualizarResultado = mysqli_prepare($con, $sqlActualizarResultado);
        mysqli_stmt_bind_param($stmtActualizarResultado, "iiiiii", $golesEquipoLocal, $golesEquipoVisitante, $penalesEquipoLocal, $penalesEquipoVisitante, $jugado, $idPartido);
        mysqli_stmt_execute($stmtActualizarResultado);

        if (mysqli_stmt_execute($stmtActualizarResultado)) {
            echo "<script>alert('Resultados actualizados correctamente.');</script>";
        } else {
            echo "<script>alert('Error al actualizar los resultados: " . mysqli_stmt_error($stmtActualizarResultado) . "');</script>";
        }

        //Determinar el Equipo ganador y perdedor
        if ($golesEquipoLocal > $golesEquipoVisitante) {
            $equipoGanador = $idEquipoLocal;
            $equipoPerdedor = $idEquipoVisitante;
        } elseif ($golesEquipoLocal < $golesEquipoVisitante) {
            $equipoGanador = $idEquipoVisitante;
            $equipoPerdedor = $idEquipoLocal;
        } else {
            //Si hay definición por penales
            if ($penalesEquipoLocal > $penalesEquipoVisitante) {
                $equipoGanador = $idEquipoLocal;
                $equipoPerdedor = $idEquipoVisitante;
            } elseif ($penalesEquipoLocal < $penalesEquipoVisitante) {
                $equipoGanador = $idEquipoVisitante;
                $equipoPerdedor = $idEquipoLocal;
            } else {
                echo "<script>alert('Tiene que haber un ganador si o si');</script>";
                echo "<script>window.location='index.php?modulo=cargar-resultado-semi&idCategoria=" . $idCategoria . "&idPartido=" . $idPartido . "';</script>";
            }
        }
        echo "<script>window.location='index.php?modulo=tumbada&idCategoria=" . $idCategoria . "&idEdicion=". $idEdicion ."';</script>";
    }
}
?>
<section>
    <div class="flex items-center justify-center p-12">
        <div class="mx-auto w-full max-w-[550px]">
            <form action="index.php?modulo=cargar-resultado-tumbada&accion=cargarResultadoTumbada&idCategoria=<?php echo $idCategoria ?>&idPartido=<?php echo $idPartido ?>&idEdicion=<?php echo $idEdicion ?>" method="POST">
                <?php
                $sqlMostrarEquipoLocal = "SELECT t.id, equipos.nombre AS nombreEquipoLocal, equipos.id AS idEquipoLocal
                    FROM tumbada t
                    INNER JOIN equipos ON t.idEquipoLocal = equipos.id
                    WHERE t.id = ?";
                $stmtMostrarEquipoLocal = mysqli_prepare($con, $sqlMostrarEquipoLocal);
                mysqli_stmt_bind_param($stmtMostrarEquipoLocal, "i", $idPartido);
                mysqli_stmt_execute($stmtMostrarEquipoLocal);
                $resultMostrarEquipoLocal = mysqli_stmt_get_result($stmtMostrarEquipoLocal);

                if ($resultMostrarEquipoLocal->num_rows > 0) {
                    $filaEquipoLocal = mysqli_fetch_assoc($resultMostrarEquipoLocal);
                    $nombreEquipoLocal = $filaEquipoLocal['nombreEquipoLocal'];
                    $idEquipoLocal = $filaEquipoLocal['idEquipoLocal'];
                ?>
                    <div class="mb-5">
                        <div class="mb-5">
                            <label for="golesEquipoLocal" class="mb-3 block text-base font-medium text-white">
                                Anotar goles del Equipo: <?php echo $nombreEquipoLocal; ?>
                            </label>
                            <input type="number" id="golesEquipoLocal" name="golesEquipoLocal" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                            <label for="golesEquipoVisitante" class="mb-3 mt-5 block text-base font-medium text-white">
                                Anotar penales convertidos del Equipo: <?php echo $nombreEquipoLocal ?> (si es necesario)
                            </label>
                            <input type="number" id="penalesEquipoLocal" name="penalesEquipoLocal" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                            <input class="hidden" type="number" id="idEquipoLocal" name="idEquipoLocal" value="<?php echo $idEquipoLocal; ?>" readonly>
                        </div>
                    </div>
                <?php
                } else {
                    echo "No se encontró el partido con el ID especificado.";
                }
                ?>

                <?php
                $sqlMostrarEquipoVisitante = "SELECT t.id, equipos.nombre AS nombreEquipoVisitante, equipos.id AS idEquipoVisitante
                    FROM tumbada t
                    INNER JOIN equipos ON t.idEquipoVisitante = equipos.id
                    WHERE t.id = ?";
                $stmtMostrarEquipoVisitante = mysqli_prepare($con, $sqlMostrarEquipoVisitante);
                mysqli_stmt_bind_param($stmtMostrarEquipoVisitante, "i", $idPartido);
                mysqli_stmt_execute($stmtMostrarEquipoVisitante);
                $resultMostrarEquipoVisitante = mysqli_stmt_get_result($stmtMostrarEquipoVisitante);

                if ($resultMostrarEquipoVisitante->num_rows > 0) {
                    $filaEquipoVisitante = mysqli_fetch_assoc($resultMostrarEquipoVisitante);
                    $nombreEquipoVisitante = $filaEquipoVisitante['nombreEquipoVisitante'];
                    $idEquipoVisitante = $filaEquipoVisitante['idEquipoVisitante']
                ?>
                    <div class="mb-5">
                        <div class="mb-5">
                            <label for="golesEquipoVisitante" class="mb-3 block text-base font-medium text-white">
                                Anotar goles del Equipo: <?php echo $nombreEquipoVisitante ?>
                            </label>
                            <input type="number" id="golesEquipoVisitante" name="golesEquipoVisitante" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                            <label for="golesEquipoVisitante" class="mb-3 mt-5 block text-base font-medium text-white">
                                Anotar penales convertidos del Equipo: <?php echo $nombreEquipoVisitante ?> (si es necesario)
                            </label>
                            <input type="number" id="penalesEquipoVisitante" name="penalesEquipoVisitante" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                            <input class="hidden" type="number" id="idEquipoVisitante" name="idEquipoVisitante" value="<?php echo $idEquipoVisitante; ?>" readonly>
                        </div>
                    </div>
                <?php
                } else {
                    echo "No se encontró el partido con el ID especificado.";
                }
                ?>
                <input class="hidden" type="number" id="jugado" name="jugado" value="1" readonly>
                <div>
                    <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Cargar Resultado
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>