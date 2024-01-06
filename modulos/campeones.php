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
    <div class="flex justify-center mt-10">
        <div class="bg-white py-6 w-full lg:w-2/4 rounded-lg">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
                <h1 class="text-2xl lg:text-5xl font-bold tracking-tight flex justify-center text-[<?php echo $colorTexto;?>]">
                    Campeón <?php echo $tituloCategoria . " " . $anio; ?>
                </h1>
                <br />
                <?php
                $sqlMostrarCampeon = "SELECT cat.nombreCategoria AS nombreCat, e.nombre AS nombreEquipo, e.foto AS fotoEquipo
                    FROM campeones_" . strtolower($categoria) . " AS campeon
                    INNER JOIN categorias cat ON campeon.idCategoria = cat.id
                    INNER JOIN equipos e ON campeon.idEquipo = e.id 
                    WHERE campeon.idCategoria = $categoria_id";
                $stmtCampeon = mysqli_prepare($con, $sqlMostrarCampeon);
                if (!$stmtCampeon) {
                    die('Error en la consulta: ' . mysqli_error($con));
                } else {
                    mysqli_stmt_execute($stmtCampeon);
                    $resultCampeon = mysqli_stmt_get_result($stmtCampeon);

                    if ($resultCampeon->num_rows > 0) {
                        while ($filaCampeon = mysqli_fetch_array($resultCampeon)) {
                ?>
                            <div class="flex flex-row flex-nowrap items-center justify-center mt-4">
                                <img class="h-32 w-32 lg:h-40 lg:w-40 text-xs ml-2 mr-10" src="Imagenes/<?php echo $filaCampeon['fotoEquipo'] ?>">
                                <p class="text-3xl lg:text-4xl font-bold text-black flex items-center">
                                    <?php echo $filaCampeon['nombreEquipo']; ?>
                                </p>
                            </div>
                <?php
                        }
                    }
                }
                ?>
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