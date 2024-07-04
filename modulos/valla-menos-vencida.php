<head>
    <!-- Fuente de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<h1 class="text-2xl lg:text-5xl font-bold tracking-tight text-center text-white mt-5">
    Equipos con la valla menos vencida
</h1>

<?php
// Obtén el idEdicion desde el parámetro GET
$idEdicion = isset($_GET['idEdicion']) ? (int) $_GET['idEdicion'] : 1;

// Consulta para obtener los equipos con la valla menos vencida
$sqlVallasMenosVencida = "SELECT e.nombre AS nombreEquipo, e.foto AS fotoEquipo, cat.nombreCategoria AS nombreCategoria
                          FROM vallas_menos_vencidas AS valla
                          INNER JOIN equipos e ON valla.idEquipo = e.id
                          INNER JOIN categorias cat ON valla.idCategoria = cat.id 
                          WHERE valla.idEdicion = ?
                          ORDER BY cat.nombreCategoria DESC"; // Ordenar por categoría descendente

$stmtVallasMenosVencida = mysqli_prepare($con, $sqlVallasMenosVencida);
if (!$stmtVallasMenosVencida) {
    die('Error en la consulta: ' . mysqli_error($con));
}

mysqli_stmt_bind_param($stmtVallasMenosVencida, "i", $idEdicion);
mysqli_stmt_execute($stmtVallasMenosVencida);
$resultVallasMenosVencida = mysqli_stmt_get_result($stmtVallasMenosVencida);

if ($resultVallasMenosVencida->num_rows > 0) {
    while ($filaVallas = mysqli_fetch_array($resultVallasMenosVencida)) {
        $nombreEquipo = $filaVallas['nombreEquipo'];
        $fotoEquipo = $filaVallas['fotoEquipo'];
        $nombreCategoria = $filaVallas['nombreCategoria'];
?>
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-4 py-6">
                    <div class="mt-4">
                        <h1 class="text-center text-2xl font-bold text-gray-800 mb-4">
                            <?php echo $nombreCategoria; ?>
                        </h1>
                        <br />
                        <div class="flex flex-col items-center justify-center">
                            <img class="h-24 w-24 rounded-full object-cover" src="Imagenes/<?php echo $fotoEquipo; ?>">
                            <p class="mt-2 text-lg font-medium text-gray-900">
                                <?php echo $nombreEquipo; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
} else {
    ?>
    <div class="container mx-auto px-4 py-8">
        <p class="text-3xl lg:text-4xl font-bold text-white text-center justify-center">Sin Registros</p>
    </div>
<?php
}

mysqli_stmt_close($stmtVallasMenosVencida);
?>