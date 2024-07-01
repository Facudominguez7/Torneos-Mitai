<!doctype html>
<html lang="en">

<body>
    <header class="bg-[--color-primary] shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
            <?php
            $idEdicion = $_GET['idEdicion'];
            $idCategoria = $_GET['idCategoria'];
            $sql = "SELECT categorias.nombreCategoria AS categoria, categorias.id FROM categorias 
                       WHERE categorias.idEdicion = $idEdicion AND categorias.id = $idCategoria";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows > 0) {
                while ($r = mysqli_fetch_array($result)) {
            ?>
                    <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
                        Tabla de Goleadores <?php echo $r['categoria'] ?>
                    </h1>
                    <br />
            <?php
                }
            }
            ?>
        </div>
    </header>

    <form action="index.php" method="GET" class="flex items-center justify-center mt-10">
        <?php
        $idEdicion = $_GET['idEdicion'];
        $idCategoria = $_GET['idCategoria'];
        ?>
        <input type="hidden" name="modulo" value="tabla-goleadores">
        <input type="hidden" name="idEdicion" value="<?php echo $idEdicion ?>">
        <input type="hidden" name="idCategoria" value="<?php echo $idCategoria ?>">
        <input type="hidden" name="accion" value="buscar">
        <div class="relative w-full max-w-md">
            <!-- Input de búsqueda -->
            <input type="search" class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:border-blue-500" placeholder="Buscar" x-model="search" name="buscar">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <!-- Botón de búsqueda -->
            <?php if (isset($_GET['buscar'])) { ?>
                <a href="index.php?modulo=tabla-goleadores&idEdicion=<?php echo $idEdicion ?>&idCategoria=<?php echo $idCategoria ?>">
                    <button type="button" class="absolute inset-y-0 right-0 flex items-center px-4 bg-blue-500 text-white rounded-full focus:outline-none">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free-->
                            <path d="M463.5 224H472c13.3 0 24-10.7 24-24V72c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1c-87.5 87.5-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H463.5z" />
                        </svg>
                    </button>
                </a>
            <?php } else { ?>
                <button type="submit" class="absolute inset-y-0 right-0 flex items-center px-4 bg-blue-500 text-white rounded-full focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            <?php } ?>
        </div>
    </form>
    <?php
    if (isset($_SESSION['rol'])) {
        if (!empty($_SESSION['rol'] == 2)) {
    ?>
            <div class="flex justify-center mt-10 mb-0">
                <?php $idEdicion = $_GET['idEdicion'] ?>
                <a href="index.php?modulo=agregar-jugador-tabla-goleadores&accion=agregar&idEdicion=<?php echo $idEdicion ?>&idCategoria=<?php echo $_GET['idCategoria'] ?>">
                    <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                        Agregar Jugador
                    </button>
                </a>
            </div>
    <?php
        }
    }
    ?>
    <section class="mx-auto w-full max-w-2xl flex justify-center items-stretch pb-4 px-4 sm:px-6 lg:px-8">
        <table class="border-collapse w-full mt-5">
            <thead>
                <tr>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Jugador</th>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Equipo</th>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Goles</th>
                    <?php
                    if (isset($_SESSION['rol'])) {
                        if (!empty($_SESSION['rol'] == 2)) {
                    ?>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Accion</th>
                    <?php
                        }
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_GET['buscar'])) {
                    $busqueda = $_GET['buscar'];
                    $sql = $sql = "SELECT t.id, t.idCategoria, t.nombre, t.idEquipo, 
                    equipos.nombre AS nombreEquipo, t.cantidadGoles  
                     FROM tabla_goleadores as t
                     LEFT JOIN equipos ON t.idEquipo = equipos.id
                     WHERE t.idEdicion = $idEdicion AND t.idCategoria = $idCategoria AND t.nombre   LIKE '$busqueda%'
                     ORDER BY t.cantidadGoles DESC";
                    $datosBusqueda = mysqli_query($con, $sql);

                    if ($datosBusqueda->num_rows > 0) {
                        while ($filabus = mysqli_fetch_array($datosBusqueda)) {
                ?>
                            <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Jugador</span>
                                    <?php echo $filabus['nombre']; ?>
                                </td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Equipo</span>
                                    <?php echo $filabus['nombreEquipo']; ?>
                                </td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Goles</span>
                                    <?php echo $filabus['cantidadGoles']; ?>
                                </td>
                                <?php
                                if (isset($_SESSION['rol'])) {
                                    if (!empty($_SESSION['rol'] == 2)) {
                                ?>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Accion</span>
                                            <a href="index.php?modulo=editar-goleador&accion=editar&id=<?php echo $filabus['id']; ?>" class="text-blue-400 hover:text-blue-600 underline">Editar</a>
                                            <a href="index.php?modulo=eliminar&id=<?php echo $filabus['id']; ?>" class="text-blue-400 hidden hover:text-blue-600 underline pl-6">Eliminar</a>
                                        </td>
                                <?php
                                    }
                                }
                                ?>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                            <td colspan="4" class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                No existen registros
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <?php
                    $idEdicion = $_GET['idEdicion'];
                    $idCategoria = $_GET['idCategoria'];
                    $sql = "SELECT t.id, t.idCategoria, t.nombre, t.idEquipo, 
                equipos.nombre AS nombreEquipo, t.cantidadGoles  
                 FROM tabla_goleadores as t
                 LEFT JOIN equipos ON t.idEquipo = equipos.id
                 WHERE t.idEdicion = $idEdicion AND t.idCategoria = $idCategoria
                 ORDER BY t.cantidadGoles DESC";
                    $datos = mysqli_query($con, $sql);
                    if ($datos->num_rows > 0) {
                        while ($fila = mysqli_fetch_array($datos)) {
                    ?>
                            <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Jugador</span>
                                    <?php echo $fila['nombre']; ?>
                                </td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Equipo</span>
                                    <?php echo $fila['nombreEquipo']; ?>
                                </td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Goles</span>
                                    <?php echo $fila['cantidadGoles']; ?>
                                </td>
                                <?php
                                if (isset($_SESSION['rol'])) {
                                    if (!empty($_SESSION['rol'] == 2)) {
                                ?>
                                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Accion</span>
                                            <a href="index.php?modulo=editar-goleador&accion=editar&id=<?php echo $fila['id']; ?>" class="text-blue-400 hover:text-blue-600 underline">Editar</a>
                                            <a href="index.php?modulo=eliminar&id=<?php echo $fila['id']; ?>" class="text-blue-400 hidden hover:text-blue-600 underline pl-6">Eliminar</a>
                                        </td>
                                <?php
                                    }
                                }
                                ?>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                            <td colspan="4" class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                No existen registros
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                <?php
                }
                ?>
            </tbody>
        </table>
    </section>

</body>

</html>