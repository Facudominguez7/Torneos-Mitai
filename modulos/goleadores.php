<head>
    <!-- Fuente de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<?php
// Define un array con la información de los campeones
$equiposcatgoleadores = [
    [
        "categoria_id" => 9
    ],
    [
        "categoria_id" => 8
    ],
    [
        "categoria_id" => 7
    ],
    [
        "categoria_id" => 6
    ],
    [
        "categoria_id" => 5
    ],
    [
        "categoria_id" => 4
    ],
    [
        "categoria_id" => 3
    ],
    [
        "categoria_id" => 2
    ],

];
?>
<h1 class="text-2xl lg:text-5xl font-bold tracking-tight flex justify-center text-white mt-5 ">
    Goleadores
</h1>
<br />
<?php
// Función para mostrar los campeones
function mostrarGoleadores($categoria_id, $con)
{

?>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-4 py-6">
                <?php
                $idEdicion = $_GET['idEdicion'];
                $sqlMostrarGoleadores = "SELECT e.nombre AS nombreEquipo, e.foto AS fotoEquipo, cat.nombreCategoria AS nombreCategoria, goleadores.nombre AS nombreJugador
                FROM goleadores AS goleadores
                INNER JOIN equipos e ON goleadores.idEquipo = e.id
                INNER JOIN categorias cat ON goleadores.idCategoria = cat.id 
                WHERE goleadores.idCategoria = $categoria_id AND goleadores.idEdicion = $idEdicion";
                $stmtGoleador = mysqli_prepare($con, $sqlMostrarGoleadores);
                if (!$stmtGoleador) {
                    die('Error in the query: ' . mysqli_error($con));
                } else {
                    mysqli_stmt_execute($stmtGoleador);
                    $resultGoleador = mysqli_stmt_get_result($stmtGoleador);

                    if ($resultGoleador->num_rows > 0) {
                        while ($filaGoleador = mysqli_fetch_array($resultGoleador)) {
                ?>
                            <div class="text-center mb-4">
                                <h1 class="text-2xl font-bold text-gray-800">
                                    <?php echo $filaGoleador['nombreCategoria'] ?>
                                </h1>
                                <h2 class="text-xl font-bold text-[#ffbf00] mt-2">
                                    <?php echo $filaGoleador['nombreJugador'] ?>
                                </h2>
                            </div>
                            <div class="flex items-center justify-center mt-4">
                                <img class="h-24 w-24 rounded-full object-cover" src="Imagenes/<?php echo $filaGoleador['fotoEquipo'] ?>" alt="<?php echo $filaGoleador['nombreEquipo']; ?>">
                                <p class="ml-6 text-lg font-medium text-gray-900">
                                    <?php echo $filaGoleador['nombreEquipo']; ?>
                                </p>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <p class="text-3xl lg:text-4xl font-bold text-black flex items-center">Sin Registros</p>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>


<?php
}

// Itera sobre cada campeonato para mostrar la sección correspondiente
foreach ($equiposcatgoleadores as $equipocatgoleador) {
    mostrarGoleadores($equipocatgoleador["categoria_id"], $con);
}
?>