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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        #mi_mapa {
            height: 400px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<?php
if (!isset($_GET['modulo']) || $_GET['modulo'] !== 'iniciar-sesion' && $_GET['modulo'] !== 'registro' && $_GET['modulo'] !== 'recuperar-clave' && $_GET['modulo'] !== 'formulario-clave') {
?>

    <body class="bg-[--color-primary]">
    <?php
} else {
    ?>

        <body class="bg-cover bg-no-repeat" style="background-image:url('Imagenes/fondo_en_cancha_gpt.webp')">
        <?php
    }
        ?>

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
                            <span class="self-center text-lg font-semibold whitespace-nowrap dark:text-white">Torneos Mitaí</span>
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
                                    <span class="self-center text-lg font-semibold whitespace-nowrap dark:text-white"><?php echo $filaEdiciones['nombre'] ?></span>
                                <?php
                                }
                            } else {
                                ?>
                                <span class="self-center text-lg font-semibold whitespace-nowrap dark:text-white">Torneos Mitaí</span>
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
                                <a href="<?php echo isset($_SESSION['edicionSeleccionada']) ? 'index.php?idEdicion=' . $_SESSION['edicionSeleccionada'] : 'index.php' ?>" class="block py-2 px-3 text-white bg-gray-800  rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500 dark:bg-blue-600 md:dark:bg-transparent" aria-current="page">Inicio</a>
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
                                        WHERE categorias.idEdicion = $idEdicion
                                        ORDER BY categorias.nombreCategoria ASC";
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
                                            <a href="index.php?modulo=panel-administracion&idEdicion=<?php echo $idEdicion ?>" class="py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Panel de Administración</a>
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
                                    enlace.href = ''; // Reemplaza 'ruta/al/archivo.pdf' con la URL del archivo PDF
                                    enlace.download = 'ReglamentoMitaiCup.pdf'; // Establece el nombre del archivo
                                    document.body.appendChild(enlace);
                                    enlace.click();
                                    document.body.removeChild(enlace);
                                }
                            </script>
                            <li>
                                <a href="https://www.facebook.com/ligamitaijb" target="_blank" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contacto</a>
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
        if (!isset($_GET['modulo']) || ($_GET['modulo'] !== 'iniciar-sesion' && $_GET['modulo'] !== 'registro' && $_GET['modulo'] !== 'recuperar-clave' && $_GET['modulo'] !== 'formulario-clave')) {
        ?>
            <header class="bg-[--color-primary]">
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
                $modulo = $_GET['modulo'];

                switch (true) {
                    case strpos($modulo, 'editar') !== false:
                        $ruta_modulo = './modulos/editar/' . $modulo . '.php';
                        break;
                    case strpos($modulo, 'agregar') !== false:
                        $ruta_modulo = './modulos/agregar/' . $modulo . '.php';
                        break;
                    case strpos($modulo, 'cargar') !== false:
                        $ruta_modulo = './modulos/cargar/' . $modulo . '.php';
                        break;
                    default:
                        $ruta_modulo = './modulos/' . $modulo . '.php';
                        break;
                }

                if (file_exists($ruta_modulo)) {
                    include($ruta_modulo);
                } else {
                    echo "El módulo solicitado no existe.";
                }
            } else {
            ?>
                <!-- Primer diseño para pantallas grandes -->
                <div class="md:container md:mx-auto md:px-4 md:py-8 md:text-center hidden md:block" style="background-image: url('Imagenes/fondo-texto-1.jpg'); background-size: cover; background-position: center; box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);">
                    <h1 class="md:text-4xl md:font-bold md:text-white md:mb-4">¡Recibe las últimas actualizaciones del torneo!</h1>
                    <p class="md:text-white md:mb-5">Regístrate para estar al tanto de todas las noticias y novedades del torneo.</p>
                    <?php
                    if (empty($_SESSION['nombre_usuario'])) {
                    ?>
                        <a href="index.php?modulo=registro" class="mt-2  md:inline-block md:bg-blue-600 md:hover:bg-blue-200 md:text-white md:font-bold md:py-3 md:px-8 md:rounded-lg md:transition-all md:duration-300 md:shadow-lg">
                            Registrarse
                        </a>
                    <?php
                    }
                    ?>
                </div>


                <!-- Segundo diseño para pantallas pequeñas -->
                <div class="container mx-auto w-11/12 text-center relative md:hidden">
                    <div class="absolute inset-0 flex justify-center items-center" style="background-color: rgba(0, 0, 0, 0.5); box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-4">¡Recibe las últimas actualizaciones del torneo!</h1>
                            <?php
                            if (empty($_SESSION['nombre_usuario'])) {
                            ?>
                                <a href="index.php?modulo=registro" class="inline-block bg-blue-600 hover:bg-blue-200 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 shadow-lg">
                                    Registrarse
                                </a>
                            <?php
                            }
                            ?>
                            <p class="text-white text-center mt-24">Regístrate para estar al tanto de todas las noticias y novedades del torneo.</p>

                        </div>
                    </div>
                    <img src="Imagenes/fondo-texto-1.jpg" alt="Imagen de fondo" class="w-full h-1/5">
                </div>

                <div class="container mx-auto px-4 py-8 text-start">
                    <?php if (isset($_GET['idEdicion'])) : ?>
                        <?php
                        $idEdicion = $_GET['idEdicion'];
                        $botones = [
                            ['url' => 'index.php?modulo=campeones&idEdicion=' . $idEdicion, 'texto' => 'Campeones 2024'],
                            ['url' => 'index.php?modulo=subcampeones&idEdicion=' . $idEdicion, 'texto' => 'Subcampeones 2024'],
                            ['url' => 'index.php?modulo=valla-menos-vencida&idEdicion=' . $idEdicion, 'texto' => 'Valla menos vencida'],
                            ['url' => 'index.php?modulo=goleadores&idEdicion=' . $idEdicion,  'texto' => 'Goleadores'],
                        ];
                        ?>
                        <div class="flex justify-start flex-row flex-wrap space-x-2 md:justify-center md:flex-row md:space-y-0 md:flex-wrap md:space-x-4">
                            <?php foreach ($botones as $boton) : ?>
                                <a href="<?php echo $boton['url']; ?>">
                                    <button class="bg-gray-800 hover:bg-gray-900 mt-2 mb-2 text-white py-2 px-4 rounded-full transition-all duration-300 md:py-3 md:px-6 md:rounded-lg">
                                        <?php echo $boton['texto']; ?>
                                    </button>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="mt-8">
                        <div id="mi_mapa" class="block w-full rounded-lg"></div>
                        <a id="googleMapsLink" href="" target="_blank" rel="noopener noreferrer" class="mt-2 flex justify-center">
                            <button class=" bg-gray-800 hover:bg-gray-900  text-white py-2 px-4 rounded transition-all duration-300 mt-5">
                                Abrir Ubicacion
                            </button>
                        </a>
                    </div>
                </div>

                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const latitud = -27.400747; // Reemplaza con la latitud del complejo deportivo Mbaréte
                        const longitud = -55.941036; // Reemplaza con la longitud del complejo deportivo Mbaréte
                        const nombreUbicacion = "Complejo Deportivo Mbarete";

                        let map = L.map('mi_mapa', {
                            dragging: false, // Desactivar el arrastre del mapa
                            zoomControl: false,
                            scrollWheelZoom: false
                        }).setView([latitud, longitud], 15);

                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);

                        L.marker([latitud, longitud]).addTo(map).bindPopup(nombreUbicacion).openPopup();

                        let googleMapsLink = document.getElementById('googleMapsLink');
                        googleMapsLink.href = `https://www.google.com/maps/dir/?api=1&destination=${latitud},${longitud}`;
                    });
                </script>
            <?php
            }
            ?>
        </main>
        </body>

</html>