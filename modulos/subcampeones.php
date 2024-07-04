<?php
// Obtén el idEdicion desde el parámetro GET
$idEdicion = isset($_GET['idEdicion']) ? (int) $_GET['idEdicion'] : 1;

// Consulta para obtener subcampeonatos de oro con detalles del equipo (incluyendo la foto)
$sqlOro = "SELECT cat.nombreCategoria AS categoria_nombre, copa.nombre AS nombre_copa, so.idCategoria AS categoria_id, eq.nombre AS nombre_equipo, eq.foto AS foto_equipo
           FROM subcampeones_oro so 
           INNER JOIN categorias cat ON so.idCategoria = cat.id
           INNER JOIN copas copa ON so.idCopa = copa.id
           INNER JOIN ediciones e ON so.idEdicion = e.id
           INNER JOIN equipos eq ON so.idEquipo = eq.id
           WHERE so.idEdicion = ?
           ORDER BY cat.nombreCategoria DESC"; // Ordenar por orden y luego por categoría

$stmtOro = mysqli_prepare($con, $sqlOro);
if ($stmtOro) {
    mysqli_stmt_bind_param($stmtOro, "i", $idEdicion);
    mysqli_stmt_execute($stmtOro);
    $resultOro = mysqli_stmt_get_result($stmtOro);

    $campeonesOro = mysqli_fetch_all($resultOro, MYSQLI_ASSOC);

    mysqli_stmt_close($stmtOro);
} else {
    die('Error en la consulta de oro: ' . mysqli_error($con));
}

// Consulta para obtener subcampeonatos de plata con detalles del equipo (incluyendo la foto)
$sqlPlata = "SELECT cat.nombreCategoria AS categoria_nombre, copa.nombre AS nombre_copa, sp.idCategoria AS categoria_id, eq.nombre AS nombre_equipo, eq.foto AS foto_equipo
             FROM subcampeones_plata sp 
             INNER JOIN categorias cat ON sp.idCategoria = cat.id
             INNER JOIN copas copa ON sp.idCopa = copa.id
             INNER JOIN ediciones e ON sp.idEdicion = e.id
             INNER JOIN equipos eq ON sp.idEquipo = eq.id
             WHERE sp.idEdicion = ?
             ORDER BY cat.nombreCategoria DESC"; // Ordenar por orden y luego por categoría

$stmtPlata = mysqli_prepare($con, $sqlPlata);
if ($stmtPlata) {
    mysqli_stmt_bind_param($stmtPlata, "i", $idEdicion);
    mysqli_stmt_execute($stmtPlata);
    $resultPlata = mysqli_stmt_get_result($stmtPlata);

    $campeonesPlata = mysqli_fetch_all($resultPlata, MYSQLI_ASSOC);

    mysqli_stmt_close($stmtPlata);
} else {
    die('Error en la consulta de plata: ' . mysqli_error($con));
}
?>

<div class="container mx-auto px-4 py-8">
    <?php foreach ($campeonesOro as $campeonOro) : ?>
        <?php
        // Obtener la categoría y otras informaciones relevantes
        $categoria_id = $campeonOro['categoria_id'];
        $categoria_nombre = $campeonOro['categoria_nombre'];
        $nombre_copa = $campeonOro['nombre_copa'];

        // Buscar el subcampeón de plata correspondiente
        $subcampeonPlata = null;
        foreach ($campeonesPlata as $subcampeon) {
            if ($subcampeon['categoria_id'] == $categoria_id) {
                $subcampeonPlata = $subcampeon;
                break;
            }
        }

        // Verificar si hay subcampeón de oro y plata para esta categoría
        $countOro = 0;
        $countPlata = 0;

        // Consulta para verificar si hay subcampeón de oro para esta categoría
        $sqlCheckOro = "SELECT COUNT(*) AS count FROM subcampeones_oro WHERE idEdicion = ? AND idCategoria = ?";
        $stmtCheckOro = mysqli_prepare($con, $sqlCheckOro);
        if ($stmtCheckOro) {
            mysqli_stmt_bind_param($stmtCheckOro, "ii", $idEdicion, $categoria_id);
            mysqli_stmt_execute($stmtCheckOro);
            mysqli_stmt_bind_result($stmtCheckOro, $countOro);
            mysqli_stmt_fetch($stmtCheckOro);
            mysqli_stmt_close($stmtCheckOro);
        } else {
            die('Error en la consulta de verificación de subcampeón de oro: ' . mysqli_error($con));
        }

        // Consulta para verificar si hay subcampeón de plata para esta categoría
        $sqlCheckPlata = "SELECT COUNT(*) AS count FROM subcampeones_plata WHERE idEdicion = ? AND idCategoria = ?";
        $stmtCheckPlata = mysqli_prepare($con, $sqlCheckPlata);
        if ($stmtCheckPlata) {
            mysqli_stmt_bind_param($stmtCheckPlata, "ii", $idEdicion, $categoria_id);
            mysqli_stmt_execute($stmtCheckPlata);
            mysqli_stmt_bind_result($stmtCheckPlata, $countPlata);
            mysqli_stmt_fetch($stmtCheckPlata);
            mysqli_stmt_close($stmtCheckPlata);
        } else {
            die('Error en la consulta de verificación de subcampeón de plata: ' . mysqli_error($con));
        }
        ?>

        <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <div class="px-4 py-6">
                <h2 class="text-center text-2xl font-bold text-yellow-400 mb-4">
                    Subcampeón copa de oro <?php echo $categoria_nombre ?>
                </h2>
                <div class="mt-4 flex items-center justify-center">
                    <?php if ($countOro > 0) : ?>
                        <img class="h-24 w-24 rounded-full object-cover mr-4" src="Imagenes/<?php echo $campeonOro['foto_equipo'] ?>" alt="<?php echo $campeonOro['nombre_equipo']; ?>">
                        <h3 class="text-lg font-medium text-gray-900">
                            <?php echo $campeonOro['nombre_equipo']; ?>
                        </h3>
                    <?php else : ?>
                        <p class="text-lg text-gray-700">No hay subcampeón de oro registrado para esta categoría.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <div class="px-4 py-6">
                <h2 class="text-center text-2xl font-bold text-gray-400 mb-4">
                    Subcampeón copa de plata <?php echo $categoria_nombre ?>
                </h2>
                <div class="mt-4 flex items-center justify-center">
                    <?php if ($countPlata > 0 && $subcampeonPlata) : ?>
                        <img class="h-24 w-24 rounded-full object-cover mr-4" src="Imagenes/<?php echo $subcampeonPlata['foto_equipo'] ?>" alt="<?php echo $subcampeonPlata['nombre_equipo']; ?>">
                        <h3 class="text-lg font-medium text-gray-900">
                            <?php echo $subcampeonPlata['nombre_equipo']; ?>
                        </h3>
                    <?php else : ?>
                        <p class="text-lg text-gray-700">No hay subcampeón de plata registrado para esta categoría.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

