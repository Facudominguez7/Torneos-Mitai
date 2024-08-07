<?php $idEdicion = $_GET['idEdicion'] ?>
<header class="bg-[--color-primary]">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
        <?php
        $idCategoria = $_GET['id'];
        if (empty($_GET['fecha'])) {
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
                        Fixture <?php echo $filaCat['nombreCategoria'] ?>
                    </h1>
                    <br>
            <?php
                }
            }
            ?>
            <?php
        } else {
            $idFecha = $_GET['fecha'];
            $sqlMostrarCategoria = "SELECT categorias.nombreCategoria, fechas.nombre AS nombreFecha
                FROM categorias 
                INNER JOIN fechas ON categorias.id = fechas.idCategoria 
                WHERE categorias.id = $idCategoria AND fechas.id = $idFecha";
            $consultaNombre = mysqli_prepare($con, $sqlMostrarCategoria);
            mysqli_stmt_execute($consultaNombre);
            $resultNombreCat = mysqli_stmt_get_result($consultaNombre);
            if ($resultNombreCat->num_rows > 0) {
                while ($filaCat = mysqli_fetch_array($resultNombreCat)) {
            ?>
                    <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
                        Fixture <?php echo $filaCat['nombreCategoria'] ?> <?php echo $filaCat['nombreFecha'] ?>
                    </h1>
                    <br>
        <?php
                }
            }
        }
        ?>
        <div class="flex justify-center items-center">
            <button onclick="descargarPDFDefinicion()" class="hidden mb-4 middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">Descargar Horarios Semifinales y Finales 07/01
            </button>
        </div>
        <script>
            function descargarPDFDefinicion() {
                // Crea un enlace invisible
                var enlace = document.createElement('a');
                enlace.href = 'PDF/Definicion.pdf'; // Reemplaza 'ruta/al/archivo.pdf' con la URL del archivo PDF
                enlace.download = 'HorarioDefinicionDomingo07/01.pdf'; // Establece el nombre del archivo
                document.body.appendChild(enlace);
                enlace.click();
                document.body.removeChild(enlace);
            }
        </script>
    </div>
</header>
<section>
    <div class="relative">
        <div id="desplegableFecha" class="flex justify-start mb-4 mt-10 ml-10">
            <button id="dropdownButton" class="flex items-center middle none rounded-lg bg-gray-800 hover:bg-gray-900 py-3 px-10 font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-500/20 transition-all hover:shadow-lg focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                <span class="mr-1 text-2xl">Fechas</span>
                <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="https://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
        </div>
        <!-- Dropdown menu -->
        <div id="dropdownMenu" class="hidden overflow-y-auto font-normal bg-gray-800 divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 absolute top-full left-0 mt-2 ml-10 z-10 max-h-80">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-400">
                <?php
                $idCategoria = $_GET['id'];
                $sqlMostrarFechas = "SELECT DISTINCT fechas.nombre, fechas.id FROM fechas WHERE idCategoria = $idCategoria";
                $consultaFechas = mysqli_prepare($con, $sqlMostrarFechas);
                mysqli_stmt_execute($consultaFechas);
                $resultFechas = mysqli_stmt_get_result($consultaFechas);

                if ($resultFechas->num_rows > 0) {
                    while ($filaFecha = mysqli_fetch_array($resultFechas)) {

                ?>
                        <li class="py-1">
                            <a href="index.php?modulo=categoria-2010&id=<?php echo $idCategoria; ?>&fecha=<?php echo $filaFecha['id']; ?>&idEdicion=<?php echo $idEdicion ?>" class="block px-4 py-2 text-white text-xl"><?php echo $filaFecha['nombre']; ?></a>
                        </li>
                        <hr class="border-t border-white">
                    <?php
                    }
                } else {
                    ?>
                    <li>
                        <a class="block px-4 py-2 text-white text-xl">No hay Fechas para mostrar</a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>

    <script>
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', function(event) {
            event.stopPropagation(); // Evita que el evento se propague al documento
            dropdownMenu.classList.toggle('hidden');
        });

        // Cerrar el menú si se hace clic fuera de él
        document.addEventListener('click', function(event) {
            if (!dropdownMenu.contains(event.target) && event.target !== dropdownButton) {
                dropdownMenu.classList.add('hidden'); // Oculta el menú
            }
        });
    </script>
    <div class="flex justify-center flex-wrap">
        <?php
        $id = $_GET['id'];
        if ($_GET['idEdicion'] == 1) {
        ?>
            <button class="mb-4 middle none center mr-4 rounded-lg bg-gray-800 hover:bg-gray-900 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md  transition-all hover:shadow-lg focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                <a href="index.php?modulo=semifinal&accion=cargar&idCategoria=<?php echo $id ?>&idEdicion=<?php echo $_GET['idEdicion']?>">
                    SemiFinales
                </a>
            </button>
        <?php
        } else {
            ?>
             <button class="mb-4 middle none center mr-4 rounded-lg bg-gray-800 hover:bg-gray-900 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md  transition-all hover:shadow-lg focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                <a href="index.php?modulo=semifinal-nueva&accion=cargar&idCategoria=<?php echo $id ?>&idEdicion=<?php echo $_GET['idEdicion']?>">
                    SemiFinales
                </a>
            </button>
            <?php
        }
        //Caso especial 16 edicion mitai - Tumbada en algunas categorias $id = idCategoria
        if($id == 17 || $id == 16 || $id == 12){
            ?>
            <button class="mb-4 middle none center mr-4 rounded-lg bg-gray-800 hover:bg-gray-900 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md  transition-all hover:shadow-lg focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
            <a href="index.php?modulo=tumbada&idCategoria=<?php echo $id ?>&idEdicion=<?php echo $_GET['idEdicion'] ?>">
                Tumbada
            </a>
        </button>
            <?php
        }
        ?>

        <button class="mb-4 middle none center mr-4 rounded-lg bg-gray-800 hover:bg-gray-900 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md  transition-all hover:shadow-lg focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
            <a href="index.php?modulo=final&idCategoria=<?php echo $id ?>&idEdicion=<?php echo $_GET['idEdicion'] ?>">
                Finales
            </a>
        </button>
        <?php
        if (isset($_SESSION['rol'])) {
            if (!empty($_SESSION['rol'] == 2)) {
        ?>

                <button class="mb-4 middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                    <a href="index.php?modulo=agregar-fechas&accion=agregar&idCategoria=<?php echo $id ?>&idEdicion=<?php echo $idEdicion ?>">
                        Agregar Fechas
                    </a>
                </button>
                <button class="middle mb-4 none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                    <a href="index.php?modulo=agregar-grupo&accion=agregar&idCategoria=<?php echo $id ?>&idEdicion=<?php echo $idEdicion ?>">
                        Agregar Grupos
                    </a>
                </button>
                <button class="middle mb-4 none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                    <a href="index.php?modulo=agregar-equipo-a-grupo&accion=agregar&idCategoria=<?php echo $id ?>&idEdicion=<?php echo $idEdicion ?>">
                        Agregar Equipo a Grupo
                    </a>
                </button>
        <?php
            }
        }
        ?>
        <a href="index.php?modulo=tabla-goleadores&idCategoria=<?php echo $id ?>&idEdicion=<?php echo $idEdicion ?>">
            <button class="mb-4 middle none center mr-4 rounded-lg bg-gray-800 hover:bg-gray-900 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md  transition-all hover:shadow-lg focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                Tabla de Goleadores
            </button>
        </a>
    </div>
    <div class="container mx-auto">
        <div class="flex flex-wrap justify-start">
            <?php
            // Consulta para obtener los grupos de la categoría
            $sqlMostrarGrupos = "SELECT DISTINCT id, nombre FROM grupos WHERE idCategoria = $idCategoria";
            $consultaGrupos = mysqli_query($con, $sqlMostrarGrupos);

            if (mysqli_num_rows($consultaGrupos) > 0) {
                while ($filaGrupo = mysqli_fetch_array($consultaGrupos)) {
                    $idGrupo = $filaGrupo['id'];
                    $nombreGrupo = $filaGrupo['nombre'];
            ?>
                    <div class="border rounded-lg p-1 lg:w-1/3 lg:mt-0 lg:mr-5 w-full flex justify-start flex-col bg-gray-100 mt-2">
                        <h2 class="text-center mb-3 font-bold text-xl"><?php echo $nombreGrupo; ?></h2>
                        <table class="border-collapse w-auto">
                            <thead>
                                <tr>
                                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Equipos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Consulta para mostrar los equipos del grupo actual
                                $sqlEquiposGrupo = "SELECT e.id AS idEquipo, e.nombre AS nombreEquipo, e.foto AS fotoEquipo
                                                FROM equipos_grupos eg
                                                INNER JOIN equipos e ON eg.idEquipo = e.id
                                                WHERE eg.idGrupo = $idGrupo";
                                $consultaEquiposGrupo = mysqli_query($con, $sqlEquiposGrupo);

                                if (mysqli_num_rows($consultaEquiposGrupo) > 0) {
                                    while ($filaEquipoGrupo = mysqli_fetch_array($consultaEquiposGrupo)) {
                                        $idEquipo = $filaEquipoGrupo['idEquipo'];
                                        $nombreEquipo = $filaEquipoGrupo['nombreEquipo'];
                                        $fotoEquipo = $filaEquipoGrupo['fotoEquipo'];
                                ?>
                                        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-1 lg:mb-0">
                                            <td class="w-full lg:w-auto p-0 lg:p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                                <?php echo $nombreEquipo ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='2'>No hay equipos registrados para este grupo.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="flex justify-center items-center mt-5">
                    <div class="bg-white py-1 w-screen lg:w-full rounded-lg">
                        <div class=" px-4 py-1 sm:px-3 lg:px-8">
                            <h1 id="parrafoRegistro" class="text-xl tracking-tight flex justify-center text-black">
                                "Por el momento no se ha cargado información".
                            </h1>
                            <br />
                            <div class="flex justify-center lg:justify-end items-center">
                                <button class=" mb-1 middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                    <a href="index.php">
                                        Volver al Inicio
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="container mx-auto py-8">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-2 overflow-x-auto">
            <?php
            $sqlMostrarGrupos = "SELECT grupos.nombre , grupos.id FROM grupos 
                INNER JOIN categorias ON grupos.idCategoria = categorias.id
                WHERE categorias.id = $id AND categorias.idEdicion = $idEdicion";
            $stmt = mysqli_prepare($con, $sqlMostrarGrupos);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {

                while ($fila = mysqli_fetch_array($result)) {
                    $idGrupo = $fila['id'];
                    if (empty($_GET['fecha'])) {
            ?>
                        <!-- Grupo A -->
                        <div id="grupos" class="border rounded-lg p-4 flex justify-center flex-col bg-gray-100">
                            <a class="flex justify-center" href="index.php?modulo=tabla-posiciones&accion=cargar&idCategoria=<?php echo $id ?>&idGrupo=<?php echo $fila['id'] ?>">
                                <button class="middle none center mr-4 rounded-lg bg-gray-800 hover:bg-gray-900 py-3 px-6 font-sans text-xs font-semibold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg  focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                    Tabla de Posiciones <?php echo htmlspecialchars($fila['nombre']) ?>
                                </button>
                            </a>
                            <a class="block px-4 py-2 text-black text-xl">Debe seleccionar una fecha para ver los partidos</a>

                            <div class="w-full">
                                <?php
                                if (isset($_SESSION['rol'])) {
                                    if (!empty($_SESSION['rol'] == 2)) {
                                ?>
                                        <!-- Agrega más partidos según sea necesario -->

                                        <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                            Debe seleccionar una fecha para Agregar Partidos
                                        </button>

                                <?php
                                    }
                                }
                                ?>

                            </div>
                        </div>
                    <?php
                    } else {
                        $idFecha = $_GET['fecha'];
                        $sqlMostrarPartidos = "SELECT p.*, el.nombre AS nombre_local, ev.nombre AS nombre_visitante, el.foto AS foto_local, ev.foto AS foto_visitante, d.diaPartido AS dia
                                                  FROM partidos p
                                                  INNER JOIN equipos el ON p.idEquipoLocal = el.id
                                                  INNER JOIN equipos ev ON p.idEquipoVisitante = ev.id
                                                  INNER JOIN dias d ON p.idDia = d.id
                                                  WHERE p.idGrupo = $idGrupo AND p.idFechas = $idFecha AND p.idEdicion = $idEdicion";

                        $stmtPartidos = mysqli_prepare($con, $sqlMostrarPartidos);
                        mysqli_stmt_execute($stmtPartidos);
                        $resultPartidos = mysqli_stmt_get_result($stmtPartidos);
                    ?>
                        <!-- Grupo A -->
                        <div id="grupos" class="border rounded-lg p-4 flex justify-center flex-col bg-gray-100">
                            <?php
                            $sqlMostrarDiaPartido = "SELECT DISTINCT d.diaPartido AS dia 
                                FROM partidos p 
                                RIGHT JOIN dias d ON p.idDia = d.id 
                                WHERE p.idGrupo = $idGrupo AND p.idFechas = $idFecha";

                            $stmtDiaPartido = mysqli_prepare($con, $sqlMostrarDiaPartido);
                            mysqli_stmt_execute($stmtDiaPartido);
                            $resultDiaPartido = mysqli_stmt_get_result($stmtDiaPartido);

                            // Verifica si no hay resultados
                            if (!$resultDiaPartido || $resultDiaPartido->num_rows === 0) {
                            ?>
                                <h3 class="text-xl font-semibold mb-4 text-gray-800 text-center"><?php echo htmlspecialchars($fila['nombre']) ?></h3>
                                <?php
                            } else {
                                // Hay resultados, mostrar el día del partido
                                while ($filaDiaPartido = mysqli_fetch_array($resultDiaPartido)) {
                                    $diaPartido = $filaDiaPartido['dia'];
                                ?>
                                    <h3 class="text-xl font-semibold mb-4 text-gray-800 text-center"><?php echo htmlspecialchars($fila['nombre']) ?> <?php echo $diaPartido ?></h3>
                                    <a class="flex justify-center mb-4" href="index.php?modulo=tabla-posiciones&accion=cargar&idCategoria=<?php echo $id ?>&idGrupo=<?php echo $fila['id'] ?>&idFecha=<?php echo $idFecha ?>">
                                        <button class="middle none center mr-4 rounded-lg bg-gray-800 hover:bg-gray-900 py-3 px-6 font-sans text-xs font-semibold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg  focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                            Tabla de Posiciones <?php echo htmlspecialchars($fila['nombre']) ?>
                                        </button>
                                    </a>
                            <?php
                                }
                            }
                            ?>
                            <div class="w-auto">
                                <?php
                                if ($resultPartidos->num_rows > 0) {
                                    while ($filaPartido = mysqli_fetch_array($resultPartidos)) {
                                        $nombreEquipoLocal = $filaPartido['nombre_local'];
                                        $fotoLocal = $filaPartido['foto_local'];
                                        $nombreEquipoVisitante = $filaPartido['nombre_visitante'];
                                        $fotoVisitante = $filaPartido['foto_visitante'];
                                        $diaPartido = $filaPartido['dia'];
                                        $horario = $filaPartido['horario'];
                                        $cancha = $filaPartido['cancha'];
                                        $idPartido = $filaPartido['id'];
                                        $idFecha = $filaPartido['idFechas'];
                                        $idCategoria = $_GET['id'];
                                        $resultadoEquipoLocal = $filaPartido['golesEquipoLocal'];
                                        $resultadoEquipoVisitante = $filaPartido['golesEquipoVisitante'];
                                        $partidosJugadosEquipoLocal = $filaPartido['jugado'];
                                        $partidosJugadosEquipoVisitante = $filaPartido['jugado'];

                                ?>
                                        <div class="grid grid-cols-12 lg:grid-cols-24 gap-4 py-2 text-center overflow-x-auto lg:overflow-x-hidden">
                                            <div class="col-span-5 md:col-span-5 lg:col-span-3 flex items-center">
                                                <img class="h-14 w-14 text-xs ml-2 mr-2" src="Imagenes/<?php echo $fotoLocal ?>" alt="Logo <?php echo $nombreEquipoLocal ?>">
                                                <span class="text-gray-800"><?php echo $nombreEquipoLocal ?></span>
                                            </div>
                                            <?php
                                            if ($partidosJugadosEquipoLocal === 0 && $partidosJugadosEquipoVisitante === 0) {
                                            ?>
                                                <div class="flex col-span-2 lg:col-span-3 items-center font-bold justify-center">vs</div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="flex col-span-3 lg:col-span-3 items-center font-bold justify-center">
                                                    <?php echo $resultadoEquipoLocal ?> - <?php echo $resultadoEquipoVisitante ?>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            <div class="col-span-4 lg:col-span-3 flex items-center ">
                                                <span class="text-gray-800 m-0"><?php echo $nombreEquipoVisitante ?></span>
                                                <img class="h-14 w-14 text-xs ml-2 mr-2 lg:ml-2" src="Imagenes/<?php echo $fotoVisitante ?>" alt="Logo <?php echo $nombreEquipoVisitante ?>">
                                            </div>
                                            <div class="col-span-6 lg:col-span-1 flex flex-col items-center justify-center ml-10">
                                                <span class="font-semibold text-gray-800 text-xl mb-3 md:mr-10 lg:mr-10 mr-4">Horario</span>
                                                <span class="text-gray-800 mr-2"><?php echo $horario ?></span>
                                            </div>
                                            <div class="col-span-6 lg:col-span-2 flex flex-col items-center justify-center">
                                                <span class="font-semibold text-gray-800 text-xl mb-3">Cancha</span>
                                                <span class="text-gray-800 mr-2"><?php echo $cancha ?></span>
                                            </div>
                                            <?php
                                            if (isset($_SESSION['rol'])) {
                                                if (!empty($_SESSION['rol'] == 2)) {
                                            ?>
                                                    <div class="col-span-6 lg:col-span-3 flex items-center justify-center">
                                                        <a href="index.php?modulo=cargar-resultado&accion=cargar&idCategoria=<?php echo $idCategoria ?>&idPartido=<?php echo $idPartido ?>&idGrupo=<?php echo $idGrupo ?>&idFecha=<?php echo $idFecha ?>&idEdicion=<?php echo $idEdicion ?>">
                                                            <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                                                Cargar Resultado
                                                            </button>
                                                        </a>
                                                    </div>
                                                    <div class="col-span-6 lg:col-span-3 flex items-center justify-center">
                                                        <a href="index.php?modulo=editar-partido&accion=editar&idPartido=<?php echo $idPartido ?>&idCategoria=<?php echo $idCategoria ?>&idFecha=<?php echo $idFecha ?>&idEdicion=<?php echo $idEdicion ?>">
                                                            <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                                                Editar
                                                            </button>
                                                        </a>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <hr class="py-2 border-t-4 ">
                                <?php
                                    }
                                }
                                ?>
                                <?php
                                if (isset($_SESSION['rol'])) {
                                    if (!empty($_SESSION['rol'] == 2)) {
                                ?>
                                        <a href="index.php?modulo=agregar-fixture&accion=agregar&idCategoria=<?php echo $id ?>&idGrupo=<?php echo $fila['id'] ?>&idFecha=<?php echo $idFecha ?>&idEdicion=<?php echo $idEdicion ?>">
                                            <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                                Agregar Partidos
                                            </button>
                                        </a>
                                <?php
                                    }
                                }
                                ?>

                            </div>
                        </div>
                    <?php
                    }
                    ?>
            <?php
                }
            }
            ?>
        </div>

    </div>
</section>