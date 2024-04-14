<head>
    <!-- Fuente de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<?php
// Define un array con la información de los campeones
$equipos = [
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
    Equipos con la valla menos vencida
</h1>
<br />
<?php
// Función para mostrar los campeones
function mostrarVallaMenosVencida($categoria_id, $con)
{

?>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-4 py-6">
                <div class="mt-4">
                    <?php
                    $idEdicion = $_GET['idEdicion'];
                    $sqlMostrarValla = "SELECT e.nombre AS nombreEquipo, e.foto AS fotoEquipo, cat.nombreCategoria AS nombreCategoria
                 FROM vallas_menos_vencidas AS valla
                 INNER JOIN equipos e ON valla.idEquipo = e.id
                 INNER JOIN categorias cat ON valla.idCategoria = cat.id 
                 WHERE valla.idCategoria = $categoria_id AND valla.idEdicion = $idEdicion";
                    $stmtValla = mysqli_prepare($con, $sqlMostrarValla);
                    if (!$stmtValla) {
                        die('Error en la consulta: ' . mysqli_error($con));
                    } else {
                        mysqli_stmt_execute($stmtValla);
                        $resultValla = mysqli_stmt_get_result($stmtValla);

                        if ($resultValla->num_rows > 0) {
                            while ($filaValla = mysqli_fetch_array($resultValla)) {
                    ?>
                                <h1 class="text-center text-2xl font-bold text-gray-800 mb-4">
                                    <?php echo $filaValla['nombreCategoria'] ?>
                                </h1>
                                <br />
                                <div class="flex flex-col items-center justify-center">
                                    <img class="h-24 w-24 rounded-full object-cover" src="Imagenes/<?php echo $filaValla['fotoEquipo'] ?>">
                                    <p class="mt-2 text-lg font-medium text-gray-900">
                                        <?php echo $filaValla['nombreEquipo']; ?>
                                    </p>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <p class="text-lg font-medium text-gray-900 text-center">Sin Registros</p>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
}

// Itera sobre cada campeonato para mostrar la sección correspondiente
foreach ($equipos as $equipo) {
    mostrarVallaMenosVencida($equipo["categoria_id"], $con);
}
?>