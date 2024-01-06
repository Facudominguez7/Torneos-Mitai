<?php
if (!empty($_GET['accion'])) {
    $idCategoria = $_GET['idCategoria'];
    $idGrupo = $_GET['idGrupo'];

    $sqlMostrarTablaPosiciones = "SELECT tp.*, e.nombre AS nombreEquipo, e.foto as fotoEquipo
    FROM tabla_posiciones tp 
    INNER JOIN equipos e ON tp.idEquipo = e.id 
    WHERE tp.idGrupo = $idGrupo
    ORDER BY tp.puntos DESC, tp.diferenciaGoles DESC";
    $stmtMostrarTabla = mysqli_prepare($con, $sqlMostrarTablaPosiciones);
    mysqli_stmt_execute($stmtMostrarTabla);
    $resultTablaPosiciones = mysqli_stmt_get_result($stmtMostrarTabla);

?>
    <header class="bg-[--color-primary] shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
            <?php
            $idCategoria = $_GET['idCategoria'];
            $idFecha = $_GET['idFecha'];
            $idGrupo = $_GET['idGrupo'];

            // Consulta para obtener el nombre del grupo y de la categoría desde las tablas correspondientes
            $sqlMostrarInfo = "SELECT g.nombre AS nombreGrupo, c.nombreCategoria AS nombreCategoria
                   FROM grupos g
                   INNER JOIN categorias c ON g.idCategoria = c.id
                   WHERE g.id = $idGrupo";

            $consultaInfo = mysqli_prepare($con, $sqlMostrarInfo);
            mysqli_stmt_execute($consultaInfo);
            $resultInfo = mysqli_stmt_get_result($consultaInfo);

            if ($resultInfo->num_rows > 0) {
                while ($filaInfo = mysqli_fetch_array($resultInfo)) {
                    $nombreGrupo = $filaInfo['nombreGrupo'];
                    $nombreCategoria = $filaInfo['nombreCategoria'];
            ?>
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
                        <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
                            Tabla de Posiciones <?php echo $nombreCategoria . ' - ' . $nombreGrupo; ?>
                        </h1>
                    </div>
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
                        <h1 class="text-xl font-bold tracking-tight flex justify-center text-white">
                            Los equipos son actualizados en la tabla de posiciones a medida que se van cargando los resultados de los partidos. Si algún equipo del grupo no aparece es porque todavía no jugó su partido.
                        </h1>
                        <br />
                    </div>
            <?php
                }
            }
            ?>

        </div>
    </header>
    <?php

    if ($resultTablaPosiciones->num_rows > 0) {
        $posicion = 1;
    ?>

        <section class="mx-auto w-full max-w-full flex justify-center items-stretch pb-4 px-4 sm:px-6 lg:px-8">
            <table class="border-collapse w-full mt-5">
                <thead>
                    <tr>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Puesto</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Logo</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Nombre</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Puntos</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Jugado</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Ganado</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Empatado</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Perdido</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">GF</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">GC</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">DF</th>
                    </tr>
                </thead>
                <?php
                while ($filaTabla = mysqli_fetch_array($resultTablaPosiciones)) {

                ?>

                    <tbody>
                        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Puesto</span>
                                <?php echo $posicion; ?>*
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 flex justify-center border border-b  lg:table-cell relative lg:static">
                                <img class="h-24 w-24" src="Imagenes/<?php echo $filaTabla['fotoEquipo']; ?>" alt="logo <?php echo $filaTabla['nombreEquipo']; ?>">
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">nombre</span>
                                <?php echo $filaTabla['nombreEquipo']; ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Puntos</span>
                                <?php echo $filaTabla['puntos']; ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Jugado</span>
                                <?php echo $filaTabla['jugado']; ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Ganado</span>
                                <?php echo $filaTabla['ganado']; ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Empatado</span>
                                <?php echo $filaTabla['empatado']; ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Perdido</span>
                                <?php echo $filaTabla['perdido']; ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">GF</span>
                                <?php echo $filaTabla['golesFavor']; ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">GC</span>
                                <?php echo $filaTabla['golesContra']; ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">DF</span>
                                <?php echo $filaTabla['diferenciaGoles']; ?>
                            </td>
                        </tr>
                    <?php
                    $posicion++;
                }
            } else {
                    ?>
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
                        <h1 class="text-xl font-bold tracking-tight flex justify-center text-white">
                            Por el momento no hubieron partidos jugados en este grupo.
                        </h1>
                        <br />
                    </div>
                <?php
            }
                ?>
                    </tbody>
            </table>
        </section>
    <?php
}
