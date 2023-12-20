<head>
    <link rel="stylesheet" href="./Estilos/estilos-desplegableFechas.css">
</head>

<body>
    <header class="bg-[--color-primary] shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
                Fixture
            </h1>
            <br />
        </div>
    </header>
    <section>
        <div id="navbar-dropdown" class="relative">
            <div id="desplegableFecha" class="flex justify-start mb-4 mt-10 ml-10">
                <button id="dropdownButton" class="flex items-center middle none rounded-lg bg-blue-500 py-6 px-12 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                    <span class="mr-1 text-2xl">Fechas</span>
                    <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>
            </div>
            <!-- Dropdown menu -->
            <div id="dropdownMenu" class="hidden font-normal bg-blue-500 divide-y divide-gray-100  rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 absolute top-full left-0 mt-2 ml-10 z-10">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                    <?php
                    $idCategoria = $_GET['id'];
                    $sqlMostrarFechas = "SELECT DISTINCT fechas.nombre, fechas.id FROM fechas WHERE idCategoria = $idCategoria";
                    $consultaFechas = mysqli_prepare($con, $sqlMostrarFechas);
                    mysqli_stmt_execute($consultaFechas);
                    $resultFechas = mysqli_stmt_get_result($consultaFechas);

                    if ($resultFechas->num_rows > 0) {
                        while ($filaFecha = mysqli_fetch_array($resultFechas)) {
                    ?>
                            <li>
                                <a href="index.php?modulo=categoria-2010&id=<?php echo $idCategoria; ?>&fecha=<?php echo $filaFecha['id']; ?>" class="block px-4 py-2 text-white text-xl"><?php echo $filaFecha['nombre']; ?></a>
                            </li>
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
        <div class="flex justify-center">
            <?php
            $id = $_GET['id'];
            ?>
            <a href="index.php?modulo=agregar-fechas&accion=agregar&id=<?php echo $id ?>">
                <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                    Agregar Fechas
                </button>
            </a>
            <a href="index.php?modulo=agregar-grupo&accion=agregar&id=<?php echo $id ?>">
                <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                    Agregar Grupos
                </button>
            </a>
            <a href="index.php?modulo=agregar-equipo-a-grupo&accion=agregar&id=<?php echo $id ?>">
                <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                    Agregar Equipo a Grupo
                </button>
            </a>
        </div>
        <div class="container mx-auto py-8">
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <?php
                $sqlMostrarGrupos = "SELECT grupos.nombre , grupos.id FROM grupos 
                INNER JOIN categorias ON grupos.idCategoria = categorias.id
                WHERE categorias.id = $id";
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
                                <h3 class="text-xl font-semibold mb-4 text-gray-800 text-center"><?php echo htmlspecialchars($fila['nombre']) ?></h3>
                                <div class="space-y-2">
                                    <!-- Agrega más partidos según sea necesario -->
                                    <a href="index.php?modulo=categoria-2010&id=<?php echo $idCategoria ?>">
                                        <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                            Debe seleccionar una fecha para continuar
                                        </button>
                                    </a>
                                </div>
                            </div>
                        <?php
                        } else {
                            $idFecha = $_GET['fecha'];
                            $sqlMostrarPartidos = "SELECT p.*, el.nombre AS nombre_local, ev.nombre AS nombre_visitante, el.foto AS foto_local, ev.foto AS foto_visitante
                                                  FROM partidos p
                                                  INNER JOIN equipos el ON p.idEquipoLocal = el.id
                                                  INNER JOIN equipos ev ON p.idEquipoVisitante = ev.id
                                                  WHERE p.idGrupo = $idGrupo AND p.idFechas = $idFecha";

                            $stmtPartidos = mysqli_prepare($con, $sqlMostrarPartidos);
                            mysqli_stmt_execute($stmtPartidos);
                            $resultPartidos = mysqli_stmt_get_result($stmtPartidos);
                        ?>
                            <!-- Grupo A -->
                            <div id="grupos" class="border rounded-lg p-4 flex justify-center flex-col bg-gray-100">
                                <h3 class="text-xl font-semibold mb-4 text-gray-800 text-center"><?php echo htmlspecialchars($fila['nombre']) ?></h3>
                                <div class="space-y-2">
                                    <?php
                                    if ($resultPartidos->num_rows > 0) {
                                        while ($filaPartido = mysqli_fetch_array($resultPartidos)) {
                                            $nombreEquipoLocal = $filaPartido['nombre_local'];
                                            $fotoLocal = $filaPartido['foto_local'];
                                            $nombreEquipoVisitante = $filaPartido['nombre_visitante'];
                                            $fotoVisitante = $filaPartido['foto_visitante'];
                                    ?>
                                            <div class="py-2 text-center flex items-center justify-center">
                                                <div id="imagenesLogoIzquierda">
                                                    <img class="h-14 w-14 mr-2" src="Imagenes/<?php echo $fotoLocal?>" alt="">
                                                </div>
                                                <span class="font-semibold text-gray-800 text-center"><?php echo $nombreEquipoLocal?></span>
                                                <span class="text-gray-600 mx-3">vs</span>
                                                <span class="font-semibold text-gray-800"><?php echo $nombreEquipoVisitante?></span>
                                                <div id="imagenesLogoDerecha">
                                                <img class="h-14 w-14 mr-2" src="Imagenes/<?php echo $fotoVisitante?>" alt="">
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>

                                    <a href="index.php?modulo=agregar-fixture&accion=agregar&idCategoria=<?php echo $id ?>&idGrupo=<?php echo $fila['id'] ?>&idFecha=<?php echo $idFecha ?>">
                                        <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                            Agregar Fixture
                                        </button>
                                    </a>
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
</body>