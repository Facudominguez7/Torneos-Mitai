<?php
// Obtén el idEdicion desde el parámetro GET
$idEdicion = isset($_GET['idEdicion']) ? (int) $_GET['idEdicion'] : 1;

// Consulta para obtener campeonatos de oro con detalles del equipo (incluyendo la foto)
$sqlOro = "SELECT cat.nombreCategoria AS categoria_nombre, copa.nombre AS nombre_copa, c.idCategoria AS categoria_id, eq.nombre AS nombre_equipo, eq.foto AS foto_equipo
           FROM campeones_oro c 
           INNER JOIN categorias cat ON c.idCategoria = cat.id
           INNER JOIN copas copa ON c.idCopa = copa.id
           INNER JOIN ediciones e ON c.idEdicion = e.id
           INNER JOIN equipos eq ON c.idEquipo = eq.id
           WHERE c.idEdicion = ?
           ORDER BY  cat.nombreCategoria DESC"; // Ordenar por orden y luego por categoría

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

// Consulta para obtener campeonatos de plata con detalles del equipo (incluyendo la foto)
$sqlPlata = "SELECT cat.nombreCategoria AS categoria_nombre, copa.nombre AS nombre_copa, c.idCategoria AS categoria_id, eq.nombre AS nombre_equipo, eq.foto AS foto_equipo
             FROM campeones_plata c 
             INNER JOIN categorias cat ON c.idCategoria = cat.id
             INNER JOIN copas copa ON c.idCopa = copa.id
             INNER JOIN ediciones e ON c.idEdicion = e.id
             INNER JOIN equipos eq ON c.idEquipo = eq.id
             WHERE c.idEdicion = ?
             ORDER BY  cat.nombreCategoria DESC"; // Ordenar por orden y luego por categoría

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
    <?php
    $indexOro = 0;
    $indexPlata = 0;

    // Mientras haya campeones de oro o plata por mostrar
    while ($indexOro < count($campeonesOro) || $indexPlata < count($campeonesPlata)) {
        // Mostrar campeón de oro si hay disponible
        if ($indexOro < count($campeonesOro)) {
            $campeonOro = $campeonesOro[$indexOro];
            ?>
            <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden mb-8">
                <div class="px-4 py-6">
                    <h2 class="text-center text-2xl font-bold text-yellow-400 mb-4">
                        Campeón copa de oro <?php echo $campeonOro['categoria_nombre'] ?>
                    </h2>
                    <div class="mt-4 flex items-center justify-center">
                        <img class="h-24 w-24 rounded-full object-cover mr-4" src="Imagenes/<?php echo $campeonOro['foto_equipo'] ?>" alt="<?php echo $campeonOro['nombre_equipo']; ?>">
                        <h3 class="text-lg font-medium text-gray-900">
                            <?php echo $campeonOro['nombre_equipo']; ?>
                        </h3>
                    </div>
                </div>
            </div>
            <?php
            $indexOro++;
        }

        // Mostrar campeón de plata si hay disponible
        if ($indexPlata < count($campeonesPlata)) {
            $campeonPlata = $campeonesPlata[$indexPlata];
            ?>
            <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden mb-8">
                <div class="px-4 py-6">
                    <h2 class="text-center text-2xl font-bold text-gray-400 mb-4">
                        Campeón copa de plata <?php echo $campeonPlata['categoria_nombre'] ?>
                    </h2>
                    <div class="mt-4 flex items-center justify-center">
                        <img class="h-24 w-24 rounded-full object-cover mr-4" src="Imagenes/<?php echo $campeonPlata['foto_equipo'] ?>" alt="<?php echo $campeonPlata['nombre_equipo']; ?>">
                        <h3 class="text-lg font-medium text-gray-900">
                            <?php echo $campeonPlata['nombre_equipo']; ?>
                        </h3>
                    </div>
                </div>
            </div>
            <?php
            $indexPlata++;
        }
    }
    ?>
</div>
