<head>
    <!-- Fuente de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<?php
// Obtén el idEdicion desde el parámetro GET
$idEdicion = isset($_GET['idEdicion']) ? (int)$_GET['idEdicion'] : 1;

// Consulta para obtener los goleadores con detalles del equipo (incluyendo la foto)
$sqlGoleadores = "SELECT cat.nombreCategoria AS categoria_nombre, goleadores.nombre AS nombre_jugador, eq.nombre AS nombre_equipo, eq.foto AS foto_equipo
                  FROM goleadores
                  INNER JOIN categorias cat ON goleadores.idCategoria = cat.id
                  INNER JOIN equipos eq ON goleadores.idEquipo = eq.id
                  WHERE goleadores.idEdicion = ?
                  ORDER BY cat.nombreCategoria DESC"; // Ordenar por categoría

$stmtGoleadores = mysqli_prepare($con, $sqlGoleadores);
if ($stmtGoleadores) {
    mysqli_stmt_bind_param($stmtGoleadores, "i", $idEdicion);
    mysqli_stmt_execute($stmtGoleadores);
    $resultGoleadores = mysqli_stmt_get_result($stmtGoleadores);

    $goleadores = mysqli_fetch_all($resultGoleadores, MYSQLI_ASSOC);

    mysqli_stmt_close($stmtGoleadores);
} else {
    die('Error en la consulta de goleadores: ' . mysqli_error($con));
}
?>

<div class="container mx-auto px-4 py-8">
    <?php if (count($goleadores) > 0) : ?>
        <?php foreach ($goleadores as $goleador) : ?>
            <?php
            // Obtener la categoría y otras informaciones relevantes
            $categoria_nombre = $goleador['categoria_nombre'];
            $nombre_jugador = $goleador['nombre_jugador'];
            $nombre_equipo = $goleador['nombre_equipo'];
            $foto_equipo = $goleador['foto_equipo'];
            ?>

            <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden mb-8">
                <div class="px-4 py-6">
                    <h2 class="text-center text-2xl font-bold text-gray-800 mb-4">
                        Goleador de la categoría <?php echo $categoria_nombre ?>
                    </h2>
                    <div class="mt-4 flex items-center justify-center">
                        <img class="h-24 w-24 rounded-full object-cover mr-4" src="Imagenes/<?php echo $foto_equipo ?>" alt="<?php echo $nombre_equipo; ?>">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                <?php echo $nombre_jugador; ?>
                            </h3>
                            <p class="text-lg font-medium text-gray-900">
                                <?php echo $nombre_equipo; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p class="text-3xl lg:text-4xl font-bold text-white text-center justify-center">Sin Registros</p>
    <?php endif; ?>
</div>
