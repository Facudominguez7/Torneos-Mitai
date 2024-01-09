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
    <div class="flex justify-center mt-10">
        <div class="bg-white py-6 w-full lg:w-2/4 rounded-lg">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
                <?php
                $sqlMostrarValla = "SELECT e.nombre AS nombreEquipo, e.foto AS fotoEquipo, cat.nombreCategoria AS nombreCategoria
                 FROM vallas_menos_vencidas AS valla
                 INNER JOIN equipos e ON valla.idEquipo = e.id
                 INNER JOIN categorias cat ON valla.idCategoria = cat.id 
                 WHERE valla.idCategoria = $categoria_id";
                $stmtValla = mysqli_prepare($con, $sqlMostrarValla);
                if (!$stmtValla) {
                    die('Error en la consulta: ' . mysqli_error($con));
                } else {
                    mysqli_stmt_execute($stmtValla);
                    $resultValla = mysqli_stmt_get_result($stmtValla);

                    if ($resultValla->num_rows > 0) {
                        while ($filaValla = mysqli_fetch_array($resultValla)) {
                ?>
                            <h1 class="text-2xl lg:text-5xl font-bold tracking-tight flex justify-center text-black ">
                                <?php echo $filaValla['nombreCategoria']?>
                            </h1>
                            <br />
                            <div class="flex flex-row flex-nowrap items-center justify-center mt-4">
                                <img class="h-32 w-32 lg:h-40 lg:w-40 text-xs ml-2 mr-10" src="Imagenes/<?php echo $filaValla['fotoEquipo'] ?>">
                                <p class="text-3xl lg:text-4xl font-bold text-black flex items-center">
                                    <?php echo $filaValla['nombreEquipo']; ?>
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
foreach ($equipos as $equipo) {
    mostrarVallaMenosVencida($equipo["categoria_id"], $con);
}
?>