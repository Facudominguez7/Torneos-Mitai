<?php
include('includes/conexion.php');
conectar();
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width , initial-scale=1.0">
    <link rel="stylesheet" href="Estilos/output.css">
    <link rel="stylesheet" href="Estilos/Carrusel.css">
    <meta charset="UTF-8">
    <title>Torneo Mitai</title>
    <script defer src="js/carrusel.js"></script>
</head>

<body class="bg-[--color-primary]">
    <?php
    if (!isset($_GET['modulo']) || $_GET['modulo'] !== 'eliminar-equipo') {
    ?>
        <nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="Imagenes/Logo_Mitai.jpeg" class="h-10 w-10" alt="Flowbite Logo" />
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Torneos Mitai</span>
                </a>
                <button data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-dropdown" aria-expanded="false">
                    <span class="sr-only">Categorias</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
                <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
                    <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                        <li>
                            <a href="index.php" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500 dark:bg-blue-600 md:dark:bg-transparent" aria-current="page">Inicio</a>
                        </li>
                        <li>
                            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">Categorias 
                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownNavbar" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 absolute top-full left-0 mt-2">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                                    <li>
                                        <a href="index.php?modulo=categoria-2010&id=1" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cat.2010</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cat.2011</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cat.2012</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cat.2013</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cat.2014</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cat.2015</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cat.2016</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cat.2017</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cat.2018</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="index.php?modulo=listado-equipos" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Tabla de Equipos</a>
                        </li>
                        <li>
                            <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Pricing</a>
                        </li>
                        <li>
                            <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <?php
    }
    ?>


    <script>
        const button = document.querySelector('[data-collapse-toggle="navbar-dropdown"]');
        const button1 = document.querySelector('[data-dropdown-toggle="dropdownNavbar"]');
        const menu = document.getElementById('navbar-dropdown');
        const menu1 = document.getElementById('dropdownNavbar');

        button.addEventListener('click', function() {
            menu.classList.toggle('hidden');
        });

        button1.addEventListener('click', function(event) {
            if (window.innerWidth >= 768) { // Cambiar el 768 según sea necesario para definir cuándo mostrar el menú afuera
                const navbar = document.getElementById('navbar-dropdown');
                const navbarRect = navbar.getBoundingClientRect();

                menu1.style.top = `${navbarRect.bottom}px`;
                menu1.style.left = `${navbarRect.left}px`;
            }

            menu1.classList.toggle('hidden');
        });

        // Cerrar el menú de categorías si se hace clic fuera de él
        document.addEventListener('click', function(event) {
            const isClickInsideMenu = menu1.contains(event.target);
            const isClickOnButton = event.target === button1;

            if (!isClickInsideMenu && !isClickOnButton) {
                menu1.classList.add('hidden');
            }
        });
    </script>

    <header>

    </header>
    <!--Inicio Contenido-->
    <main>
        <?php
        if (!empty($_GET['modulo'])) {
            include('./modulos/' . $_GET['modulo'] . '.php');
        } else {
        ?>
            <div class="mx-auto max-sm:w-full w-5/12 mt-9 flex justify-center items-stretch pb-4 px-4 sm:px-6 lg:px-8">
                <div class="w-full bg-white rounded-3xl overflow-x-hidden">
                    <div class="grande w-300p flex flex-row justify-start items-center">
                        <img src="Imagenes/Banner-Mitai.jpeg" alt="Banner-Mitai" class="img" />
                        <img src="Imagenes/ImagenConRiver-carrusel.jpeg" alt="ImagenConRiver-carrusel" class="img" />
                        <img src="Imagenes/RodrigoConPelota-carrusel.jpeg" alt="Foto-Portada" class="img" />
                    </div>

                    <ul class="w-full p-4 flex flex-row justify-center items-center">
                        <li class="w-8 h-8 m-4 bg-black cursor-pointer rounded-3xl punto activo"></li>
                        <li class="w-8 h-8 m-4 bg-black cursor-pointer rounded-3xl punto"></li>
                        <li class="w-8 h-8 m-4 bg-black cursor-pointer rounded-3xl punto"></li>
                    </ul>
                </div>
            </div>
        <?php
        }
        ?>


    </main>
    <!--Fin Contenido-->
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</body>

</html>