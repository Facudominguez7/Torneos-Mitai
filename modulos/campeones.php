<head>
    <!-- Fuente de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<?php
// Define un array con la información de los campeones
$campeonatos = [
    [
        "categoria" => "Oro",
        "anio" => 2018,
        "categoria_id" => 9
    ],
    [
        "categoria" => "Plata",
        "anio" => 2018,
        "categoria_id" => 9
    ],
    [
        "categoria" => "Oro",
        "anio" => 2017,
        "categoria_id" => 8
    ],
    [
        "categoria" => "Plata",
        "anio" => 2017,
        "categoria_id" => 8
    ],
    [
        "categoria" => "Oro",
        "anio" => 2016,
        "categoria_id" => 7
    ],
    [
        "categoria" => "Plata",
        "anio" => 2016,
        "categoria_id" => 7
    ],
    [
        "categoria" => "Oro",
        "anio" => 2015,
        "categoria_id" => 6
    ],
    [
        "categoria" => "Plata",
        "anio" => 2015,
        "categoria_id" => 6
    ],
    [
        "categoria" => "Oro",
        "anio" => 2014,
        "categoria_id" => 5
    ],
    [
        "categoria" => "Plata",
        "anio" => 2014,
        "categoria_id" => 5
    ],
    [
        "categoria" => "Oro",
        "anio" => 2013,
        "categoria_id" => 4
    ],
    [
        "categoria" => "Plata",
        "anio" => 2013,
        "categoria_id" => 4
    ],
    [
        "categoria" => "Oro",
        "anio" => 2012,
        "categoria_id" => 3
    ],
    [
        "categoria" => "Plata",
        "anio" => 2012,
        "categoria_id" => 3
    ],
    [
        "categoria" => "Oro",
        "anio" => 2011,
        "categoria_id" => 2
    ],
    [
        "categoria" => "Plata",
        "anio" => 2011,
        "categoria_id" => 2
    ],
];

// Función para mostrar los campeones
function mostrarCampeones($categoria, $anio, $categoria_id, $con)
{
    $tituloCategoria = ($categoria == "Oro") ? "Copa de Oro" : "Copa de Plata";
    if ($categoria == "Oro") {
        $tituloCategoria = "Copa de Oro";
        $colorTexto = '#ffbf00';
    } else {
        $tituloCategoria = "Copa de Plata";
        $colorTexto = '#C0C0C0';
    }
?>


<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-4 py-6">
            <h2 class="text-center text-2xl font-bold text-gray-800 mb-4">
                Campeón <?php echo $tituloCategoria . " " . $anio; ?>
            </h2>
            <div class="mt-4">
                <?php
                $idEdicion = $_GET['idEdicion'];
                $sqlMostrarCampeon = "SELECT cat.nombreCategoria AS nombreCat, e.nombre AS nombreEquipo, e.foto AS fotoEquipo
                FROM campeones_" . strtolower($categoria) . " AS campeon
                INNER JOIN categorias cat ON campeon.idCategoria = cat.id
                INNER JOIN equipos e ON campeon.idEquipo = e.id 
                WHERE campeon.idCategoria = $categoria_id AND campeon.idEdicion = $idEdicion";
                $stmtCampeon = mysqli_prepare($con, $sqlMostrarCampeon);
                if (!$stmtCampeon) {
                    die('Error en la consulta: ' . mysqli_error($con));
                } else {
                    mysqli_stmt_execute($stmtCampeon);
                    $resultCampeon = mysqli_stmt_get_result($stmtCampeon);

                    if ($resultCampeon->num_rows > 0) {
                        while ($filaCampeon = mysqli_fetch_array($resultCampeon)) {
                ?>
                            <div class="flex flex-col items-center justify-center mt-4">
                                <img class="h-24 w-24 rounded-full object-cover" src="Imagenes/<?php echo $filaCampeon['fotoEquipo'] ?>" alt="<?php echo $filaCampeon['nombreEquipo']; ?>">
                                <h3 class="mt-2 text-lg font-medium text-gray-900">
                                    <?php echo $filaCampeon['nombreEquipo']; ?>
                                </h3>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <p class="text-lg font-medium text-gray-900 text-center">En disputa...</p>
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
foreach ($campeonatos as $campeonato) {
    mostrarCampeones($campeonato["categoria"], $campeonato["anio"], $campeonato["categoria_id"], $con);
}
?>