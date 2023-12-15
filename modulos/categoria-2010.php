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
                    <li>
                        <a href="index.php?modulo=categoria-2010&id=1" class="block px-4 py-2 text-white text-xl">Fecha 1</a>
                    </li>
                    <li>
                        <a href="index.php?modulo=categoria-2010&id=1" class="block px-4 py-2 text-white text-xl">Fecha 2</a>
                    </li>
                    <li>
                        <a href="index.php?modulo=categoria-2010&id=1" class="block px-4 py-2 text-white text-xl">Fecha 3</a>
                    </li>
                    <li>
                        <a href="index.php?modulo=categoria-2010&id=1" class="block px-4 py-2 text-white text-xl">Fecha 4</a>
                    </li>
                    <li>
                        <a href="index.php?modulo=categoria-2010&id=1" class="block px-4 py-2 text-white text-xl">Fecha 5</a>
                    </li>
                    <!-- ... (resto de elementos del menú aquí) ... -->
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
            <a href="index.php?modulo=agregar-grupo&accion=agregar&id=<?php echo $id ?>">
                <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                    Agregar Grupos
                </button>
            </a>
        </div>
        <div class="container mx-auto py-8">
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <?php
                $sqlMostrarGrupos = "SELECT nombre FROM grupos";
                $stmt = mysqli_prepare($con, $sqlMostrarGrupos);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($result->num_rows > 0) {
                    while ($fila = mysqli_fetch_array($result)) {
                ?>
                        <!-- Grupo A -->
                        <div id="grupos" class="border rounded-lg p-4 flex justify-center flex-col bg-gray-100">
                            <h3 class="text-xl font-semibold mb-4 text-gray-800 text-center"><?php echo htmlspecialchars($fila['nombre']) ?></h3>
                            <div class="space-y-2">
                                <div class="py-2 text-center flex items-center justify-center">
                                    <div id="imagenesLogoIzquierda">
                                        <img class="h-14 w-14 mr-2" src="Imagenes/1701875050.jpg" alt="">
                                    </div>
                                    <span class="font-semibold text-gray-800 text-center">Equipo 5</span>
                                    <span class="text-gray-600 mx-3">vs</span>
                                    <span class="font-semibold text-gray-800">Equipo 6</span>
                                    <div id="imagenesLogoDerecha">
                                        <img class="h-14 w-14 ml-2" src="Imagenes/1701875050.jpg" alt="">
                                    </div>
                                </div>
                                <div class="py-2 text-center">
                                    <span class="font-semibold text-gray-800">Equipo 7</span> vs <span class="font-semibold text-gray-800">Equipo 8</span>
                                </div>
                                <!-- Agrega más partidos según sea necesario -->
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>

        </div>
    </section>
</body>