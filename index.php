<?php
session_start();
include('includes/conexion.php');
conectar();
if (isset($_GET['idEdicion'])) {
    $_SESSION['edicionSeleccionada'] = $_GET['idEdicion'];
}
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
    <!--Google Anuncios-->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6431800148656534" crossorigin="anonymous">
    </script>
    <meta name="viewport" content="width=device-width , initial-scale=1.0">
    <link rel="stylesheet" href="Estilos/output.css">
    <link rel="stylesheet" href="Estilos/estilos-desplegableFechas.css">
    <meta charset="UTF-8">
    <title>Torneo Mitai</title>
    <link rel="shortcut icon" type="image/png" href="Imagenes/Logo_Mitai_SinFondo.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap');
    </style>
    <style>
        #dropdownNavbar a:hover {
            background-color: #4a90e2;
            color: white;
        }
    </style>

</head>

<body class="bg-[--color-primary]">
    <?php
    if (!isset($_GET['modulo']) || $_GET['modulo'] !== 'eliminar-equipo') {
    ?>
        <nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="<?php echo isset($_SESSION['edicionSeleccionada']) ? 'index.php?idEdicion=' . $_SESSION['edicionSeleccionada'] : 'index.php' ?>" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="Imagenes/Logo_Mitai_SinFondo.png" class="h-10 w-10" alt="MITAI Logo">
                    <?php
                    if (!isset($_GET['idEdicion'])) {
                    ?>
                        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Torneos Mitaí</span>
                        <?php
                    } else {
                        $idEdicion = $_GET['idEdicion'];
                        $sqlMostrarEdiciones = "SELECT ediciones.nombre, ediciones.id FROM ediciones WHERE id = $idEdicion";
                        $stmtEdiciones = mysqli_prepare($con, $sqlMostrarEdiciones);
                        mysqli_stmt_execute($stmtEdiciones);
                        $resultEdiciones = mysqli_stmt_get_result($stmtEdiciones);

                        if ($resultEdiciones->num_rows > 0) {
                            while ($filaEdiciones = mysqli_fetch_array($resultEdiciones)) {
                        ?>
                                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"><?php echo $filaEdiciones['nombre'] ?></span>
                            <?php
                            }
                        } else {
                            ?>
                            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Torneos Mitaí</span>
                        <?php
                        }
                        ?>
                    <?php
                    }

                    ?>
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
                            <a href="<?php echo isset($_SESSION['edicionSeleccionada']) ? 'index.php?idEdicion=' . $_SESSION['edicionSeleccionada'] : 'index.php' ?>" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500 dark:bg-blue-600 md:dark:bg-transparent" aria-current="page">Inicio</a>
                        </li>
                        <li>
                            <div class="flex flex-row items-center">
                                <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownEdiciones" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">Ediciones
                                    <svg class="w-2.5 h-2.5 ms-2.5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                                <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownCategorias" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">Categorias
                                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>
                            </div>
                            <!-- Dropdown menu -->
                            <div id="dropdownCategorias" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 absolute top-full left-0 mt-2">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-400">
                                    <?php
                                    if (!isset($_GET['idEdicion'])) {
                                    ?>
                                        <li>
                                            <a href="index.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Debe seleccionar una Edicion</a>
                                        </li>
                                        <?php
                                    } else {
                                        $idEdicion = $_GET['idEdicion'];
                                        $sqlMostrarCategorias = "SELECT categorias.nombreCategoria AS categoria, categorias.id FROM categorias 
                                        WHERE categorias.idEdicion = $idEdicion";
                                        $stmtCategorias = mysqli_prepare($con, $sqlMostrarCategorias);
                                        mysqli_stmt_execute($stmtCategorias);
                                        $resultCategorias = mysqli_stmt_get_result($stmtCategorias);

                                        if ($resultCategorias->num_rows > 0) {
                                            while ($filaCategorias = mysqli_fetch_array($resultCategorias)) {
                                        ?>
                                                <li>
                                                    <a href="index.php?modulo=categoria-2010&id=<?php echo $filaCategorias['id'] ?>&idEdicion=<?php echo $idEdicion ?>" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><?php echo $filaCategorias['categoria'] ?></a>
                                                </li>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <li>
                                                <a href="index.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Por el momento no se agregaron categorías</a>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    <?php
                                    }
                                    ?>

                                </ul>
                            </div>
                            <div id="dropdownEdiciones" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 absolute top-full left-0 mt-2">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-400">
                                    <?php
                                    $sqlMostrarEdiciones = "SELECT ediciones.nombre, ediciones.id FROM ediciones";
                                    $stmtEdiciones = mysqli_prepare($con, $sqlMostrarEdiciones);
                                    mysqli_stmt_execute($stmtEdiciones);
                                    $resultEdiciones = mysqli_stmt_get_result($stmtEdiciones);

                                    if ($resultEdiciones->num_rows > 0) {
                                        while ($filaEdiciones = mysqli_fetch_array($resultEdiciones)) {
                                    ?>
                                            <li>
                                                <a href="index.php?idEdicion=<?php echo $filaEdiciones['id'] ?>" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><?php echo $filaEdiciones['nombre'] ?></a>
                                            </li>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <li>
                                            <a href="index.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Por el momento no se agregaron ediciones para este torneo</a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </li>
                        <?php
                        if (isset($_SESSION['rol'])) {
                            if (!empty($_SESSION['rol'] == 2)) {
                                if (!isset($_GET['idEdicion'])) {
                        ?>
                                    <li>
                                        <a href="index.php?modulo=panel-administracion&idEdicion=<?php echo $idEdicion ?>" class="hidden  py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Panel de Administración</a>
                                    </li>
                                <?php
                                } else {
                                    $idEdicion = $_GET['idEdicion'];
                                ?>
                                    <li>
                                        <a href="index.php?modulo=panel-administracion&idEdicion=<?php echo $idEdicion ?>" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Panel de Administración</a>
                                    </li>
                                <?php
                                }
                                ?>
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
        const botonCategorias = document.querySelector('[data-dropdown-toggle="dropdownCategorias"]');
        const botonEdiciones = document.querySelector('[data-dropdown-toggle="dropdownEdiciones"]');
        const menu = document.getElementById('navbar-dropdown');
        const menuCategorias = document.getElementById('dropdownCategorias');
        const menuEdiciones = document.getElementById('dropdownEdiciones');

        button.addEventListener('click', function() {
            menu.classList.toggle('hidden');
        });

        botonCategorias.addEventListener('click', function(event) {
            const buttonRect = botonCategorias.getBoundingClientRect();

            if (window.innerWidth < 768) {
                menuCategorias.style.top = `${buttonRect.bottom}px`;
                menuCategorias.style.left = '0';
                menuCategorias.style.width = '100%';
            } else {
                const navRect = document.querySelector('nav').getBoundingClientRect();
                const menuWidth = navRect.width * 0.1; // Ancho ajustado

                menuCategorias.style.top = `${buttonRect.bottom}px`;
                menuCategorias.style.left = `${buttonRect.left}px`; // Ajuste de posición a la izquierda del botón
                menuCategorias.style.width = `${menuWidth}px`;
            }

            menuCategorias.classList.toggle('hidden');
        });

        botonEdiciones.addEventListener('click', function(event) {
            const buttonRect = botonEdiciones.getBoundingClientRect();

            if (window.innerWidth < 768) {
                menuEdiciones.style.top = `${buttonRect.bottom}px`;
                menuEdiciones.style.left = '0';
                menuEdiciones.style.width = '100%';
            } else {
                const navRect = document.querySelector('nav').getBoundingClientRect();
                const menuWidth = navRect.width * 0.1; // Ancho ajustado

                menuEdiciones.style.top = `${buttonRect.bottom}px`;
                menuEdiciones.style.left = `${buttonRect.left}px`; // Ajuste de posición a la izquierda del botón
                menuEdiciones.style.width = `${menuWidth}px`;
            }

            menuEdiciones.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            const isClickInsideMenuCategorias = menuCategorias.contains(event.target);
            const isClickOnButtonCategorias = event.target === botonCategorias;
            const isClickInsideEdiciones = menuEdiciones.contains(event.target);
            const isClickOnButtonEdiciones = event.target === botonEdiciones;

            if (!isClickInsideMenuCategorias && !isClickOnButtonCategorias) {
                menuCategorias.classList.add('hidden');
            }
            if (!isClickInsideEdiciones && !isClickOnButtonEdiciones) {
                menuEdiciones.classList.add('hidden');
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
                        <h1 id="parrafoRegistro" class="text-xl tracking-tight flex justify-center text-black">
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
            <div class="flex justify-center flex-wrap mt-4">
                <?php
                if (!isset($_GET['idEdicion'])) {
                ?>
                    <button class="hidden mb-4 middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                    <?php
                } else {
                    $idEdicion = $_GET['idEdicion'];
                    $botones = [
                        ['url' => 'index.php?modulo=campeones&idEdicion=' . $idEdicion, 'texto' => 'Campeones 2024'],
                        ['url' => 'index.php?modulo=subcampeones&idEdicion=' . $idEdicion, 'texto' => 'Subcampeones 2024'],
                        ['url' => 'index.php?modulo=valla-menos-vencida&idEdicion=' . $idEdicion, 'texto' => 'Valla menos vencida'],
                        ['url' => 'index.php?modulo=goleadores&idEdicion=' . $idEdicion,  'texto' => 'Goleadores'],
                    ];

                    foreach ($botones as $boton) {
                        if (!isset($_GET['idEdicion'])) {
                            echo '<button class="hidden mb-4 middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">';
                        } else {
                            echo '<button class="mb-4 middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">';
                        }
                        echo '<a href="' . $boton['url'] . '">' . $boton['texto'] . '</a>';
                        echo '</button>';
                    }
                    ?>
                    <?php
                }
                    ?>
            </div>

            <style>
                .carousel-inner {
                    transition: transform 1s ease;
                }

                .carousel-item {
                    flex: 0 0 100%;
                    padding: 0 10px;
                }
            </style>
            <div class="carousel-container flex justify-center items-center mt-5 mb-5">
                <div class="carousel w-full lg:w-2/6 overflow-hidden">
                    <div class="carousel-inner flex">
                        <div class="carousel-item rounded-lg">
                            <img class="w-full h-5/6" src="Imagenes/Banner-Mitai.jpeg" alt="Banner-Mitai">
                        </div>
                        <div class="carousel-item rounded-lg">
                            <img class="w-full h-5/6" src="Imagenes/Logo La Isla.jpg" alt="Escudo La Isla">
                        </div>
                        <div class="carousel-item rounded-lg">
                            <img class="w-full h-5/6" src="Imagenes/Deportivo Villa Cabello.jpg" alt="Escudo Deportivo Villa Cabello">
                        </div>
                    </div>
                </div>
            </div>
            <script>
                const carousel = document.querySelector('.carousel');
                const carouselInner = carousel.querySelector('.carousel-inner');
                const carouselItems = carousel.querySelectorAll('.carousel-item');

                let currentIndex = 0;

                function goToSlide(index) {
                    carouselInner.style.transform = `translateX(-${index * 100}%)`;
                    currentIndex = index;
                }

                function goToNextSlide() {
                    if (currentIndex < carouselItems.length - 1) {
                        goToSlide(currentIndex + 1);
                    } else {
                        goToSlide(0);
                    }
                }
                setInterval(goToNextSlide, 3000);
            </script>
        <?php
        }
        ?>
    </main>
</body>

</html>