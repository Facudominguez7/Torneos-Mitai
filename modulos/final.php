<header class="bg-[--color-primary] shadow">
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
                <br />
        <?php
            }
        }
        ?>

    </div>
</header>
<section>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
        <?php
        $idCategoria = $_GET['idCategoria'];

        if ($idCategoria === 9) {
        ?>
            <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
                Final Copa de Oro
            </h1>
            <br />
        <?php
        }
        ?>
        <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
            Final Copa de Oro
        </h1>
        <br />
        <?php
        if (isset($_SESSION['rol'])) {
            if (!empty($_SESSION['rol'] == 2)) {
        ?>
                <div class="mb-5">
                    <a href="index.php?modulo=agregar-final&accion=agregar&idCategoria=<?php echo $idCategoria ?>&idCopa=1">
                        <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                            Agregar Final Copa de Oro
                        </button>
                    </a>
                </div>
        <?php
            }
        }
        ?>
        <div class="border rounded-lg p-4 flex justify-center flex-col bg-gray-100">
            <div class="grid grid-cols-12 lg:grid-cols-24 gap-4 py-2 text-center  overflow-x-auto lg:overflow-x-hidden">
                <?php
                $idCategoria = $_GET['idCategoria'];
                $sqlMostrarFinal = "SELECT f.*, el.nombre AS nombre_local, el.foto AS foto_local, ev.nombre AS nombre_visitante, ev.foto AS foto_visitante, 
                    d.diaPartido AS dia
                    FROM finales f 
                    INNER JOIN equipos el ON f.idEquipoLocal = el.id
                    INNER JOIN equipos ev ON f.idEquipoVisitante = ev.id
                    INNER JOIN dias d ON f.idDia = d.id
                    INNER JOIN copas c ON f.idCopa = c.id
                    WHERE f.idCategoria = $idCategoria AND f.idCopa = 1";
                $stmtFinal = mysqli_prepare($con, $sqlMostrarFinal);
                mysqli_stmt_execute($stmtFinal);
                $resultFinal = mysqli_stmt_get_result($stmtFinal);

                if ($resultFinal->num_rows > 0) {
                    while ($filaFinal = mysqli_fetch_array($resultFinal)) {
                        $resultadoEquipoLocal = $filaFinal['golesEquipoLocal'];
                        $resultadoEquipoVisitante = $filaFinal['golesEquipoVisitante'];
                        $idPartido = $filaFinal['id'];
                        $idCopa = $filaFinal['idCopa'];
                        $penalesEquipoLocal = $filaFinal['penalesEquipoLocal'];
                        $penalesEquipoVisitante = $filaFinal['penalesEquipoVisitante'];
                ?>
                        <div class="col-span-6 lg:col-span-3 flex lg:justify-end items-center">
                            <img class="h-14 w-14 text-xs ml-2 mr-2" src="Imagenes/<?php echo $filaFinal['foto_local'] ?> " alt="<?php echo $filaFinal['nombre_local'] ?>">
                            <span class="text-gray-800"><?php echo $filaFinal['nombre_local'] ?></span>
                        </div>
                        <?php
                        if ($resultadoEquipoLocal === 0 && $resultadoEquipoVisitante === 0) {
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
                            <span class="text-gray-800 m-0"><?php echo $filaFinal['nombre_visitante'] ?></span>
                            <img class="h-14 w-14 text-xs ml-2 mr-2 lg:ml-2" src="Imagenes/<?php echo $filaFinal['foto_visitante'] ?>" alt="<?php echo $filaFinal['nombre_visitante'] ?>">
                        </div>
                        <div class="col-span-6 lg:col-span-1 flex flex-col items-center justify-center ml-10">
                            <span class="font-semibold text-gray-800 text-xl mb-3 mr-4">Horario</span>
                            <span class="text-gray-800 mr-2"><?php echo $filaFinal['horario'] ?></span>
                        </div>
                        <div class="col-span-6 lg:col-span-2 flex flex-col items-center justify-center">
                            <span class="font-semibold text-gray-800 text-xl mb-3">Cancha</span>
                            <span class="text-gray-800 mr-2"><?php echo $filaFinal['cancha'] ?></span>
                        </div>
                        <?php
                        if (isset($_SESSION['rol'])) {
                            if (!empty($_SESSION['rol'] == 2)) {
                        ?>
                                <div class="col-span-12 flex items-center justify-center">
                                    <a href="index.php?modulo=cargar-resultado-final&accion=cargar&idCategoria=<?php echo $idCategoria ?>&idPartido=<?php echo $idPartido ?>&idCopa=<?php echo $idCopa ?>">
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
                    <div class="col-span-6 lg:col-span-3 flex justify-center lg:justify-end  items-center">
                        <h1 class="text-gray-800">Ganador Semifinal Oro</h1>
                    </div>
                    <div class="flex col-span-2 lg:col-span-3 items-center font-bold justify-start lg:justify-center">vs</div>
                    <div class="col-span-3 lg:col-span-3 flex justify-center items-center lg:justify-start">
                        <span class="text-gray-800 m-0">Ganador Semifinal Oro</span>
                    </div>
                    <div class="col-span-6 lg:col-span-1 flex flex-col items-center justify-center ml-10">
                        <span class="font-semibold text-gray-800 text-xl mb-3 mr-4">Horario</span>
                        <span class="text-gray-800 mr-2">A definir</span>
                    </div>
                    <div class="col-span-6 lg:col-span-2 flex flex-col items-center justify-center">
                        <span class="font-semibold text-gray-800 text-xl mb-3">Cancha</span>
                        <span class="text-gray-800 mr-2">A definir</span>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
        <hr>
        <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white mt-8 mb-8">
            Final Copa de Plata
        </h1>
        <br>
        <?php
        if (isset($_SESSION['rol'])) {
            if (!empty($_SESSION['rol'] == 2)) {
        ?>
                <div class="mb-5">
                    <a href="index.php?modulo=agregar-final&accion=agregar&idCategoria=<?php echo $idCategoria ?>&idCopa=2">
                        <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                            Agregar Final Copa de Plata
                        </button>
                    </a>
                </div>
        <?php
            }
        }
        ?>
        <div class="border rounded-lg p-4 flex justify-center flex-col bg-gray-100">
            <div class="grid grid-cols-12 lg:grid-cols-24 gap-4 py-2 text-center  overflow-x-auto lg:overflow-x-hidden">
                <?php
                $idCategoria = $_GET['idCategoria'];
                $sqlMostrarFinal = "SELECT f.*, el.nombre AS nombre_local, el.foto AS foto_local, ev.nombre AS nombre_visitante, ev.foto AS foto_visitante, 
                    d.diaPartido AS dia
                    FROM finales f 
                    INNER JOIN equipos el ON f.idEquipoLocal = el.id
                    INNER JOIN equipos ev ON f.idEquipoVisitante = ev.id
                    INNER JOIN dias d ON f.idDia = d.id
                    INNER JOIN copas c ON f.idCopa = c.id
                    WHERE f.idCategoria = $idCategoria AND f.idCopa = 2";
                $stmtFinal = mysqli_prepare($con, $sqlMostrarFinal);
                mysqli_stmt_execute($stmtFinal);
                $resultFinal = mysqli_stmt_get_result($stmtFinal);


                if ($resultFinal->num_rows > 0) {
                    while ($filaFinal = mysqli_fetch_array($resultFinal)) {
                        $resultadoEquipoLocal = $filaFinal['golesEquipoLocal'];
                        $resultadoEquipoVisitante = $filaFinal['golesEquipoVisitante'];
                        $idPartido = $filaFinal['id'];
                        $idCopa = $filaFinal['idCopa'];
                        $penalesEquipoLocal = $filaFinal['penalesEquipoLocal'];
                        $penalesEquipoVisitante = $filaFinal['penalesEquipoVisitante'];

                ?>
                        <div class="col-span-6 lg:col-span-3 flex lg:justify-end items-center">
                            <img class="h-14 w-14 text-xs ml-2 mr-2" src="Imagenes/<?php echo $filaFinal['foto_local'] ?> " alt="<?php echo $filaFinal['nombre_local'] ?>">
                            <span class="text-gray-800"><?php echo $filaFinal['nombre_local'] ?></span>
                        </div>
                        <?php
                        if ($resultadoEquipoLocal === 0 && $resultadoEquipoVisitante === 0) {
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
                            <span class="text-gray-800 m-0"><?php echo $filaFinal['nombre_visitante'] ?></span>
                            <img class="h-14 w-14 text-xs ml-2 mr-2 lg:ml-2" src="Imagenes/<?php echo $filaFinal['foto_visitante'] ?>" alt="<?php echo $filaFinal['nombre_visitante'] ?>">
                        </div>
                        <div class="col-span-6 lg:col-span-1 flex flex-col items-center justify-center ml-10">
                            <span class="font-semibold text-gray-800 text-xl mb-3 mr-4">Horario</span>
                            <span class="text-gray-800 mr-2"><?php echo $filaFinal['horario'] ?></span>
                        </div>
                        <div class="col-span-6 lg:col-span-2 flex flex-col items-center justify-center">
                            <span class="font-semibold text-gray-800 text-xl mb-3">Cancha</span>
                            <span class="text-gray-800 mr-2"><?php echo $filaFinal['cancha'] ?></span>
                        </div>
                        <?php
                        if (isset($_SESSION['rol'])) {
                            if (!empty($_SESSION['rol'] == 2)) {
                        ?>
                                <div class="col-span-12 flex items-center justify-center">
                                    <a href="index.php?modulo=cargar-resultado-final&accion=cargar&idCategoria=<?php echo $idCategoria ?>&idPartido=<?php echo $idPartido ?>&idCopa=<?php echo $idCopa ?>">
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
                    <div class="col-span-6 lg:col-span-3 flex justify-center lg:justify-end  items-center">
                        <h1 class="text-gray-800">Ganador Semifinal Plata</h1>
                    </div>
                    <div class="flex col-span-2 lg:col-span-3 items-center font-bold justify-start lg:justify-center">vs</div>
                    <div class="col-span-3 lg:col-span-3 flex justify-center items-center lg:justify-start">
                        <span class="text-gray-800 m-0">Ganador Semifinal Plata</span>
                    </div>
                    <div class="col-span-6 lg:col-span-1 flex flex-col items-center justify-center ml-10">
                        <span class="font-semibold text-gray-800 text-xl mb-3 mr-4">Horario</span>
                        <span class="text-gray-800 mr-2">A definir</span>
                    </div>
                    <div class="col-span-6 lg:col-span-2 flex flex-col items-center justify-center">
                        <span class="font-semibold text-gray-800 text-xl mb-3">Cancha</span>
                        <span class="text-gray-800 mr-2">A definir</span>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
    </div>
</section>