<section>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
        <?php
        $idCategoria = $_GET['idCategoria'];
        $sqlMostrarCategoria = "SELECT categorias.nombreCategoria
        FROM categorias 
        WHERE categorias.id = $idCategoria";
        $consultaNombre = mysqli_prepare($con, $sqlMostrarCategoria);
        mysqli_stmt_execute($consultaNombre);
        $resultNombreCat = mysqli_stmt_get_result($consultaNombre);

        if ($resultNombreCat->num_rows > 0) {
            while ($filaCat = mysqli_fetch_array($resultNombreCat)) {
        ?>
                <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
                    <?php echo $filaCat['nombreCategoria'] ?>
                </h1>
                <br>
        <?php
            }
        }
        ?>
    </div>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">

        <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
            Tumbadas
        </h1>

        <br />
        <div class="flex flex-row">
            <div class="mb-5">
                <a href="index.php?modulo=categoria-2010&id=<?php echo $idCategoria ?>&idEdicion=<?php echo $_GET['idEdicion'] ?>">
                    <button class="mb-4 middle none center mr-4 rounded-lg bg-gray-800 hover:bg-gray-900 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md  transition-all hover:shadow-lg focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"  data-ripple-light="true">
                        Volver
                    </button>
                </a>
            </div>
            <?php
            if (isset($_SESSION['rol'])) {
                if (!empty($_SESSION['rol'] == 2)) {
            ?>
                    <div class="mb-5">
                        <a href="index.php?modulo=agregar-tumbada&accion=agregar&idCategoria=<?php echo $idCategoria ?>&idEdicion=<?php echo $_GET['idEdicion'] ?>">
                            <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                Agregar Partidos
                            </button>
                        </a>
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <div class="border rounded-lg p-4 flex justify-center flex-col bg-gray-100">
            <div class="grid grid-cols-12 lg:grid-cols-24 gap-4 py-2 text-center  overflow-x-auto lg:overflow-x-hidden">
                <?php
                $idCategoria = $_GET['idCategoria'];
                $sqlMostrarTumbada = "SELECT t.*, el.nombre AS nombre_local, el.foto AS foto_local, ev.nombre AS nombre_visitante, ev.foto AS foto_visitante, 
                    d.diaPartido AS dia
                    FROM tumbada t 
                    INNER JOIN equipos el ON t.idEquipoLocal = el.id
                    INNER JOIN equipos ev ON t.idEquipoVisitante = ev.id
                    INNER JOIN dias d ON t.idDia = d.id
                    WHERE t.idCategoria = $idCategoria";
                $stmtTumbada = mysqli_prepare($con, $sqlMostrarTumbada);
                mysqli_stmt_execute($stmtTumbada);
                $resultTumbada = mysqli_stmt_get_result($stmtTumbada);

                if ($resultTumbada->num_rows > 0) {
                    while ($filaTumbada = mysqli_fetch_array($resultTumbada)) {
                        $resultadoEquipoLocal = $filaTumbada['golesEquipoLocal'];
                        $resultadoEquipoVisitante = $filaTumbada['golesEquipoVisitante'];
                        $idPartido = $filaTumbada['id'];
                        $penalesEquipoLocal = $filaTumbada['penalesEquipoLocal'];
                        $penalesEquipoVisitante = $filaTumbada['penalesEquipoVisitante'];
                        $partidosJugadosEquipoLocal = $filaTumbada['jugado'];
                        $partidosJugadosEquipoVisitante = $filaTumbada['jugado'];
                ?>
                        <div class="col-span-6 lg:col-span-3 flex lg:justify-end items-center">
                            <img class="h-14 w-14 text-xs ml-2 mr-2" src="Imagenes/<?php echo $filaTumbada['foto_local'] ?> " alt="<?php echo $filaTumbada['nombre_local'] ?>">
                            <span class="text-gray-800"><?php echo $filaTumbada['nombre_local'] ?></span>
                        </div>
                        <?php
                        if ($partidosJugadosEquipoLocal === 0 && $partidosJugadosEquipoVisitante === 0) {
                        ?>
                            <div class="flex col-span-2 lg:col-span-3 items-center font-bold justify-center">vs</div>
                            <?php
                        } else {
                            if ($resultadoEquipoLocal == $resultadoEquipoVisitante) {
                            ?>
                                <div class="flex col-span-3 lg:col-span-3 items-center font-bold justify-center" style="white-space: nowrap;">
                                    (<?php echo $penalesEquipoLocal ?>)<?php echo $resultadoEquipoLocal ?> - <?php echo $resultadoEquipoVisitante ?>(<?php echo $penalesEquipoVisitante ?>)
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="flex col-span-3 lg:col-span-3 items-center font-bold justify-center">
                                    <?php echo $resultadoEquipoLocal ?> - <?php echo $resultadoEquipoVisitante ?>
                                </div>
                            <?php
                            }
                            ?>
                        <?php
                        }
                        ?>
                        <div class="col-span-3 lg:col-span-3 flex lg:justify-start items-center ">
                            <span class="text-gray-800 m-0"><?php echo $filaTumbada['nombre_visitante'] ?></span>
                            <img class="h-14 w-14 text-xs ml-2 mr-2 lg:ml-2" src="Imagenes/<?php echo $filaTumbada['foto_visitante'] ?>" alt="<?php echo $filaTumbada['nombre_visitante'] ?>">
                        </div>
                        <div class="col-span-6 lg:col-span-1 flex flex-col items-center justify-center ml-10">
                            <span class="font-semibold text-gray-800 text-xl mb-3 mr-4">Horario</span>
                            <span class="text-gray-800 mr-2"><?php echo $filaTumbada['horario'] ?></span>
                        </div>
                        <div class="col-span-6 lg:col-span-2 flex flex-col items-center justify-center">
                            <span class="font-semibold text-gray-800 text-xl mb-3">Cancha</span>
                            <span class="text-gray-800 mr-2"><?php echo $filaTumbada['cancha'] ?></span>
                        </div>
                        <?php
                        if (isset($_SESSION['rol'])) {
                            if (!empty($_SESSION['rol'] == 2)) {
                        ?>
                                <div class="col-span-12 flex items-center justify-center">
                                    <a href="index.php?modulo=cargar-resultado-tumbada&accion=cargar&idCategoria=<?php echo $idCategoria ?>&idPartido=<?php echo $idPartido ?>&idEdicion=<?php echo $_GET['idEdicion'] ?>">
                                        <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                            Cargar Resultado
                                        </button>
                                    </a>
                                </div>
                        <?php
                            }
                        }
                        ?>
                        <hr class="col-span-12 py-2 border-t-4 ">
                    <?php
                    }
                } else {
                    ?>
                    <h1 class="col-span-12 py-2 border-t-4 text-center text-black">
                        Sin Partidos Cargados.
                    </h1>
                <?php
                }
                ?>

            </div>
        </div>
    </div>
</section>