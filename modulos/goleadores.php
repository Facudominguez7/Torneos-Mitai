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
    <div class="flex justify-center mt-10">
        <div class="bg-white py-6 w-full lg:w-2/4 rounded-lg">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
                <?php
                $idEdicion = $_GET['idEdicion'];
                $sqlMostrarGoleadores = "SELECT e.nombre AS nombreEquipo, e.foto AS fotoEquipo, cat.nombreCategoria AS nombreCategoria, goleadores.nombre AS nombreJugador
                 FROM goleadores AS goleadores
                 INNER JOIN equipos e ON goleadores.idEquipo = e.id
                 INNER JOIN categorias cat ON goleadores.idCategoria = cat.id 
                 WHERE goleadores.idCategoria = $categoria_id AND goleadores.idEdicion = $idEdicion";
                $stmtGoleador = mysqli_prepare($con, $sqlMostrarGoleadores);
                if (!$stmtGoleador) {
                    die('Error en la consulta: ' . mysqli_error($con));
                } else {
                    mysqli_stmt_execute($stmtGoleador);
                    $resultGoleador = mysqli_stmt_get_result($stmtGoleador);

                    if ($resultGoleador->num_rows > 0) {
                        while ($filaGoleador = mysqli_fetch_array($resultGoleador)) {
                ?>
                            <h1 class="text-3xl lg:text-5xl font-bold tracking-tight flex justify-center text-black ">
                                <?php echo $filaGoleador['nombreCategoria']?>
                            </h1>
                            <br />
                            <h1 class="text-4xl lg:text-5xl font-bold tracking-tight flex justify-center text-[#ffbf00] mt-4 ">
                                <?php echo $filaGoleador['nombreJugador']?>
                            </h1>
                            <br />
                            <div class="flex flex-row flex-nowrap items-center justify-center mt-4">
                                <img class="h-32 w-32 lg:h-40 lg:w-40 text-xs ml-2 mr-10" src="Imagenes/<?php echo $filaGoleador['fotoEquipo'] ?>">
                                <p class="text-3xl lg:text-4xl font-bold text-black flex items-center">
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