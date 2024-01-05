<section>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
            Campeón Copa de Oro 2018
        </h1>
        <br />
        <?php
        $sqlMostrarCampeonOro2018 = "SELECT cat.nombreCategoria AS nombreCat, e.nombre AS nombreEquipo
        FROM campeones_oro AS campeonOro2018
        INNER JOIN categorias cat ON campeonOro2018.idCategoria = cat.id
        INNER JOIN equipos e ON campeonOro2018.idEquipo = e.id 
        where campeonOro2018.idCategoria = 9";
        $stmtCampeonOro2018 = mysqli_prepare($con, $sqlMostrarCampeonOro2018);
        mysqli_stmt_execute($stmtCampeonOro2018);
        $resultCampeonOro2018 = mysqli_stmt_get_result($stmtCampeonOro2018);

        if ($resultCampeonOro2018->num_rows > 0) {
            while ($filaCampeonOro2018 = mysqli_fetch_array($resultCampeonOro2018)) {
        ?>
                <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
                    <?php echo $filaCampeonOro2018['nombreEquipo']?>
                </h1>
        <?php
            }
        }

        ?>
    </div>
</section>