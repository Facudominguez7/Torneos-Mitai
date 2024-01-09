<?php
session_start();
include('includes/conexion.php');
conectar();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-G2ZMN0053J"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-G2ZMN0053J');
    </script>
    <meta name="viewport" content="width=device-width , initial-scale=1.0">
    <link rel="stylesheet" href="Estilos/output.css">
    <link rel="stylesheet" href="Estilos/Carrusel.css">
    <link rel="stylesheet" href="Estilos/estilos-desplegableFechas.css">
    <meta charset="UTF-8">
    <title>Torneo Mitai</title>
    <link rel="shortcut icon" type="image/png" href="Imagenes/Logo_Mitai_SinFondo.png">
    <script defer src="js/carrusel.js"></script>
    <style>
        /* Estilo de hover para cada elemento de categoría */
        #dropdownNavbar a:hover {
            background-color: #4a90e2;
            /* Cambia este color al que desees */
            color: white;
            /* Cambia el color del texto si es necesario */
        }
    </style>

</head>




<body class="bg-[--color-primary]">
    <?php
    if (!isset($_GET['modulo']) || $_GET['modulo'] !== 'eliminar-equipo') {
    ?>
        <nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="Imagenes/Logo_Mitai_SinFondo.png" class="h-10 w-10" alt="MITAI Logo">
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
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-400">
                                    <li>
                                        <a href="index.php?modulo=categoria-2010&id=2" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Categoría 2011</a>
                                    </li>
                                    <li>
                                        <a href="index.php?modulo=categoria-2010&id=3" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Categoría 2012</a>
                                    </li>
                                    <li>
                                        <a href="index.php?modulo=categoria-2010&id=4" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Categoría 2013</a>
                                    </li>
                                    <li>
                                        <a href="index.php?modulo=categoria-2010&id=5" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Categoría 2014</a>
                                    </li>
                                    <li>
                                        <a href="index.php?modulo=categoria-2010&id=6" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Categoría 2015</a>
                                    </li>
                                    <li>
                                        <a href="index.php?modulo=categoria-2010&id=7" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Categoría 2016</a>
                                    </li>
                                    <li>
                                        <a href="index.php?modulo=categoria-2010&id=8" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Categoría 2017</a>
                                    </li>
                                    <li>
                                        <a href="index.php?modulo=categoria-2010&id=9" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Categoría 2018</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <?php
                        if (isset($_SESSION['rol'])) {
                            if (!empty($_SESSION['rol'] == 2)) {
                        ?>
                                <li>
                                    <a href="index.php?modulo=panel-administracion" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Panel de Administración</a>
                                </li>
                        <?php
                            }
                        }
                        ?>
                        <?php
                        if (!empty($_SESSION['nombre_usuario'])) {
                        ?>
                            <li>
                                <a href="index.php?modulo=iniciar-sesion&salir=ok" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Cerrar Sesión</a>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li>
                                <a href="index.php?modulo=iniciar-sesion" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Iniciar Sesión</a>
                            </li>
                        <?php
                        }
                        ?>
                        <li>
                            <button onclick="descargarPDF()" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Reglamento</button>
                        </li>
                        <script>
                            function descargarPDF() {
                                // Crea un enlace invisible
                                var enlace = document.createElement('a');
                                enlace.href = 'PDF/REGLAMENTO TORNEO MITAÍ CUP-CANTERA.pdf'; // Reemplaza 'ruta/al/archivo.pdf' con la URL del archivo PDF
                                enlace.download = 'ReglamentoMitaiCup.pdf'; // Establece el nombre del archivo
                                document.body.appendChild(enlace);
                                enlace.click();
                                document.body.removeChild(enlace);
                            }
                        </script>
                        <li>
                            <a href="https://www.facebook.com/ligamitaijb" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contacto</a>
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
            const buttonRect = button1.getBoundingClientRect();

            if (window.innerWidth < 768) {
                menu1.style.top = `${buttonRect.bottom}px`;
                menu1.style.left = '0';
                menu1.style.width = '100%';
            } else {
                const navRect = document.querySelector('nav').getBoundingClientRect();
                const menuWidth = navRect.width * 0.1; // Ancho ajustado

                menu1.style.top = `${buttonRect.bottom}px`;
                menu1.style.left = `${buttonRect.left}px`; // Ajuste de posición a la izquierda del botón
                menu1.style.width = `${menuWidth}px`;
            }

            menu1.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            const isClickInsideMenu = menu1.contains(event.target);
            const isClickOnButton = event.target === button1;

            if (!isClickInsideMenu && !isClickOnButton) {
                menu1.classList.add('hidden');
            }
        });
    </script>
    <?php
    if (!isset($_GET['modulo']) || ($_GET['modulo'] !== 'iniciar-sesion' && $_GET['modulo'] !== 'registro')) {
    ?>
        <header class="bg-[--color-primary] shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
                <?php
                if (!empty($_SESSION['nombre_usuario'])) {
                ?>
                    <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
                        Bienvenido/a <?php echo $_SESSION['nombre_usuario']; ?>
                    </h1>
                <?php
                }
                ?>
            </div>
        </header>
    <?php
    }
    ?>



    <main>
        <?php
        if (!empty($_GET['modulo'])) {
            include('./modulos/' . $_GET['modulo'] . '.php');
        } else {
        ?>
            <div class="flex justify-center items-center mt-5">
                <div class="bg-white py-1 w-screen lg:w-2/4 rounded-lg">
                    <div class="mx-auto max-w-7xl px-4 py-1 sm:px-3 lg:px-8">
                        <h1 class="text-xl italic font-bold tracking-tight flex justify-center text-black">
                            "Registrate para recibir nuestras actualizaciones por correo electrónico. Te mantendremos al día con nuestras últimas noticias y novedades del torneo directamente en tu bandeja de entrada."
                        </h1>
                        <br />
                        <div class="flex justify-center lg:justify-end items-center">
                            <button class=" mb-1 middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                                <a href="index.php?modulo=registro">
                                    Registrarse
                                </a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                echo 'Versión de PHP ' . phpversion();
            ?>

            <div class="flex justify-center flex-wrap mt-4">
                <button class=" mb-4 middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                    <a href="index.php?modulo=campeones">
                        Campeones 2024
                    </a>
                </button>
                <button class=" mb-4 middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                    <a href="index.php?modulo=subcampeones">
                        Subcampeones 2024
                    </a>
                </button>
                <button class=" mb-4 middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                    <a href="index.php?modulo=valla-menos-vencida">
                        Valla menos vencida
                    </a>
                </button>
            </div>
            <div class="mx-auto max-sm:w-full w-5/12 mt-9 flex justify-center items-stretch pb-4 px-4 sm:px-6 lg:px-8">
                <div class="w-full bg-white rounded-3xl overflow-x-hidden">
                    <div class="grande w-300p flex flex-row justify-start items-center">
                        <img src="Imagenes/Banner-Mitai.jpeg" alt="Banner-Mitai" class="img">
                        <img src="Imagenes/ImagenConRiver-carrusel.jpeg" alt="ImagenConRiver-carrusel" class="img">
                        <img src="Imagenes/RodrigoConPelota-carrusel.jpeg" alt="Foto-Portada" class="img">
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
</body>

</html>