<?php
if (!empty($_GET['accion'])) {
    $idCategoria = $_GET['idCategoria'];
    if ($_GET['accion'] == 'agregarFinal') {
        // Obtener valores del formulario
        $equipoLocal = $_POST['equipoLocal'];
        $equipoVisitante = $_POST['equipoVisitante'];
        $horario = $_POST['horario'];
        $cancha = $_POST['cancha'];
        $dia = $_POST['dia'];
        $copa = $_POST['copa'];

        if ($equipoLocal == $equipoVisitante) {
            echo "<script>alert('No se puede seleccionar el mismo equipo como local y visitante.');</script>";
        } else {
            // Verificar si el partido ya existe para esos equipos y esa categoría
            $sqlVerificarPartido = "SELECT COUNT(*) AS count FROM finales 
            WHERE idCategoria = ? AND ((idEquipoLocal = ? AND idEquipoVisitante = ?) OR (idEquipoLocal = ? AND idEquipoVisitante = ?))";
            $stmtVerificarPartido = mysqli_prepare($con, $sqlVerificarPartido);
            mysqli_stmt_bind_param($stmtVerificarPartido, "iiiii", $idCategoria, $equipoLocal, $equipoVisitante, $equipoVisitante, $equipoLocal);
            mysqli_stmt_execute($stmtVerificarPartido);
            $resultVerificarPartido = mysqli_stmt_get_result($stmtVerificarPartido);
            $rowPartido = mysqli_fetch_assoc($resultVerificarPartido);

            if ($rowPartido['count'] > 0) {
                echo "<script>alert('Al menos uno de los equipos ya tiene un partido en esta instancia');</script>";
            } else {
                // Insertar el partido si los equipos están disponibles
                $sqlInsertarPartido = "INSERT INTO finales (idCategoria, idEquipoLocal, idEquipoVisitante, horario, cancha, idDia, idCopa) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmtPartido = mysqli_prepare($con, $sqlInsertarPartido);
                mysqli_stmt_bind_param($stmtPartido, "iiisiii", $idCategoria, $equipoLocal, $equipoVisitante, $horario, $cancha, $dia, $copa);

                if (mysqli_stmt_execute($stmtPartido)) {
                    echo "<script>alert('Partido programado correctamente');</script>";
                } else {
                    echo "<script>alert('Error al programar el partido');</script>";
                }
                echo "<script>window.location='index.php?modulo=final&idCategoria=" . $idCategoria . "';</script>";
            }
        }
    }
}
?>
<header class="bg-[--color-primary] shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
        <?php
        $idCopa = $_GET['idCopa'];
        $sqlMostrarTipoFinal = "SELECT copas.nombre
        FROM copas 
        WHERE copas.id = $idCopa";
        $consultaNombre = mysqli_prepare($con, $sqlMostrarTipoFinal);
        mysqli_stmt_execute($consultaNombre);
        $resultNombreCop = mysqli_stmt_get_result($consultaNombre);

        if ($resultNombreCop->num_rows > 0) {
            while ($filaCop = mysqli_fetch_array($resultNombreCop)) {
        ?>
                <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
                    Final <?php echo $filaCop['nombre'] ?>
                </h1>
                <br />
        <?php
            }
        }
        ?>

    </div>
</header>
<section>
    <div class="flex items-center justify-center p-12">
        <div class="mx-auto w-full max-w-[550px]">
            <form action="index.php?modulo=agregar-final&accion=agregarFinal&idCategoria=<?php echo $idCategoria ?>" method="POST">
                <?php
                if ($idCategoria == 5 || $idCategoria == 6 || $idCategoria == 7 || $idCategoria == 8 || $idCategoria == 9) {
                    $idCopa = $_GET['idCopa'];
                    //Copa de Oro
                    if ($idCopa == 1) {
                ?>
                        <div class="mb-5">
                            <label for="equipo" class="mb-3 block text-base font-medium text-white">
                                Seleccione el Equipo Local
                            </label>
                            <?php
                            $idCategoria = $_GET['idCategoria'];
                            $sqlMostrarEquipos = "SELECT equipos.id AS idEquipo, equipos.nombre AS nombreEquipo
                            FROM equipos_ganadores_semifinales_unicas AS equiposGanadoresOro
                            INNER JOIN equipos ON equipos.id = equiposGanadoresOro.idEquipo
                            WHERE equiposGanadoresOro.idCategoria = $idCategoria";
                            $stmt = mysqli_prepare($con, $sqlMostrarEquipos);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            ?>
                            <select name="equipoLocal" id="equipoLocal" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($fila = mysqli_fetch_array($result)) {
                                ?>
                                        <option value="<?php echo $fila['idEquipo'] ?>"><?php echo $fila['nombreEquipo'] ?></option>
                                <?php
                                    }
                                } else {
                                    echo "<option value=''>No hay equipos disponibles</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="grupo" class="mb-3 block text-base font-medium text-white">
                                Seleccione el Equipo Visitante
                            </label>
                            <?php
                            $sqlMostrarEquipos = "SELECT equipos.id AS idEquipo, equipos.nombre AS nombreEquipo
                            FROM equipos_ganadores_semifinales_unicas AS equiposGanadoresOro
                            INNER JOIN equipos ON equipos.id = equiposGanadoresOro.idEquipo
                            WHERE equiposGanadoresOro.idCategoria = $idCategoria";
                            $stmt = mysqli_prepare($con, $sqlMostrarEquipos);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            ?>
                            <select name="equipoVisitante" id="equipoVisitante" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($fila = mysqli_fetch_array($result)) {
                                ?>
                                        <option value="<?php echo $fila['idEquipo'] ?>"><?php echo $fila['nombreEquipo'] ?></option>
                                <?php
                                    }
                                } else {
                                    echo "<option value=''>No hay equipos disponibles</option>";
                                }
                                ?>
                            </select>
                        </div>
                    <?php
                    } else if ($idCopa == 2) {
                    ?>
                        <div class="mb-5">
                            <label for="equipo" class="mb-3 block text-base font-medium text-white">
                                Seleccione el Equipo Local
                            </label>
                            <?php
                            $idCategoria = $_GET['idCategoria'];
                            $sqlMostrarEquipos = "SELECT equipos.id AS idEquipo, equipos.nombre AS nombreEquipo
                            FROM equipos_perdedores_semifinales_unicas AS equiposPlata
                            INNER JOIN equipos ON equipos.id = equiposPlata.idEquipo
                            WHERE equiposPlata.idCategoria = $idCategoria";
                            $stmt = mysqli_prepare($con, $sqlMostrarEquipos);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            ?>
                            <select name="equipoLocal" id="equipoLocal" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($fila = mysqli_fetch_array($result)) {
                                ?>
                                        <option value="<?php echo $fila['idEquipo'] ?>"><?php echo $fila['nombreEquipo'] ?></option>
                                <?php
                                    }
                                } else {
                                    echo "<option value=''>No hay equipos disponibles</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="grupo" class="mb-3 block text-base font-medium text-white">
                                Seleccione el Equipo Visitante
                            </label>
                            <?php
                            $sqlMostrarEquipos = "SELECT equipos.id AS idEquipo, equipos.nombre AS nombreEquipo
                            FROM equipos_perdedores_semifinales_unicas AS equiposPlata
                            INNER JOIN equipos ON equipos.id = equiposPlata.idEquipo
                            WHERE equiposPlata.idCategoria = $idCategoria";
                            $stmt = mysqli_prepare($con, $sqlMostrarEquipos);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            ?>
                            <select name="equipoVisitante" id="equipoVisitante" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($fila = mysqli_fetch_array($result)) {
                                ?>
                                        <option value="<?php echo $fila['idEquipo'] ?>"><?php echo $fila['nombreEquipo'] ?></option>
                                <?php
                                    }
                                } else {
                                    echo "<option value=''>No hay equipos disponibles</option>";
                                }
                                ?>
                            </select>
                        </div>

                    <?php
                    }
                    ?>

                    <?php
                } else {
                    $idCopa = $_GET['idCopa'];
                    if ($idCopa == 1) {
                    ?>
                        <div class="mb-5">
                            <label for="equipo" class="mb-3 block text-base font-medium text-white">
                                Seleccione el Equipo Local
                            </label>
                            <?php
                            $idCategoria = $_GET['idCategoria'];
                            $sqlMostrarEquipos = "SELECT equipos.id AS idEquipo, equipos.nombre AS nombreEquipo
                            FROM equipos_ganadores_semifinales_oro AS equiposOro
                            INNER JOIN equipos ON equipos.id = equiposOro.idEquipo
                            WHERE equiposOro.idCategoria = $idCategoria";
                            $stmt = mysqli_prepare($con, $sqlMostrarEquipos);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            ?>
                            <select name="equipoLocal" id="equipoLocal" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($fila = mysqli_fetch_array($result)) {
                                ?>
                                        <option value="<?php echo $fila['idEquipo'] ?>"><?php echo $fila['nombreEquipo'] ?></option>
                                <?php
                                    }
                                } else {
                                    echo "<option value=''>No hay equipos disponibles</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="grupo" class="mb-3 block text-base font-medium text-white">
                                Seleccione el Equipo Visitante
                            </label>
                            <?php
                            $sqlMostrarEquipos = "SELECT equipos.id AS idEquipo, equipos.nombre AS nombreEquipo
                        FROM equipos_ganadores_semifinales_oro AS equiposOro
                        INNER JOIN equipos ON equipos.id = equiposOro.idEquipo
                        WHERE equiposOro.idCategoria = $idCategoria";
                            $stmt = mysqli_prepare($con, $sqlMostrarEquipos);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            ?>
                            <select name="equipoVisitante" id="equipoVisitante" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($fila = mysqli_fetch_array($result)) {
                                ?>
                                        <option value="<?php echo $fila['idEquipo'] ?>"><?php echo $fila['nombreEquipo'] ?></option>
                                <?php
                                    }
                                } else {
                                    echo "<option value=''>No hay equipos disponibles</option>";
                                }
                                ?>
                            </select>
                        </div>
                    <?php
                    } else if ($idCopa == 2) {
                    ?>
                        <div class="mb-5">
                            <label for="equipo" class="mb-3 block text-base font-medium text-white">
                                Seleccione el Equipo Local
                            </label>
                            <?php
                            $idCategoria = $_GET['idCategoria'];
                            $sqlMostrarEquipos = "SELECT equipos.id AS idEquipo, equipos.nombre AS nombreEquipo
                            FROM equipos_ganadores_semifinales_plata AS equiposPlata
                            INNER JOIN equipos ON equipos.id = equiposPlata.idEquipo
                            WHERE equiposPlata.idCategoria = $idCategoria";
                            $stmt = mysqli_prepare($con, $sqlMostrarEquipos);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            ?>
                            <select name="equipoLocal" id="equipoLocal" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($fila = mysqli_fetch_array($result)) {
                                ?>
                                        <option value="<?php echo $fila['idEquipo'] ?>"><?php echo $fila['nombreEquipo'] ?></option>
                                <?php
                                    }
                                } else {
                                    echo "<option value=''>No hay equipos disponibles</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="grupo" class="mb-3 block text-base font-medium text-white">
                                Seleccione el Equipo Visitante
                            </label>
                            <?php
                            $sqlMostrarEquipos = "SELECT equipos.id AS idEquipo, equipos.nombre AS nombreEquipo
                            FROM equipos_ganadores_semifinales_plata AS equiposPlata
                            INNER JOIN equipos ON equipos.id = equiposPlata.idEquipo
                            WHERE equiposPlata.idCategoria = $idCategoria";
                            $stmt = mysqli_prepare($con, $sqlMostrarEquipos);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            ?>
                            <select name="equipoVisitante" id="equipoVisitante" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($fila = mysqli_fetch_array($result)) {
                                ?>
                                        <option value="<?php echo $fila['idEquipo'] ?>"><?php echo $fila['nombreEquipo'] ?></option>
                                <?php
                                    }
                                } else {
                                    echo "<option value=''>No hay equipos disponibles</option>";
                                }
                                ?>
                            </select>
                        </div>
                    <?php
                    }
                    ?>


                <?php
                }
                ?>
                <div class="mb-5">
                    <div class="mb-5">
                        <label for="horario" class="mb-3 block text-base font-medium text-white">
                            Horario del Partido Formato 00:00
                        </label>
                        <input type="text" id="horario" name="horario" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                    </div>
                </div>
                <div class="mb-5">
                    <div class="mb-5">
                        <label for="cancha" class="mb-3 block text-base font-medium text-white">
                            Número de Cancha
                        </label>
                        <input type="number" id="cancha" name="cancha" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                    </div>
                </div>
                <div class="mb-5">
                    <div class="mb-5">
                        <label for="dia" class="mb-3 block text-base font-medium text-white">
                            Seleccione el dia
                        </label>
                        <?php
                        $sqlMostrarDia = "SELECT * FROM dias";
                        $stmt = mysqli_prepare($con, $sqlMostrarDia);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        ?>
                        <select name="dia" id="dia" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($fila = mysqli_fetch_array($result)) {
                            ?>
                                    <option value="<?php echo $fila['id'] ?>"><?php echo $fila['diaPartido'] ?></option>
                            <?php
                                }
                            } else {
                                echo "<option value=''>No hay dias disponibles</option>";
                            }
                            ?>

                        </select>
                    </div>
                </div>

                <div class="mb-5">
                    <div class="mb-5">
                        <label for="dia" class="mb-3 block text-base font-medium text-white">
                            Seleccione la Copa
                        </label>
                        <?php
                        $sqlMostrarCopa = "SELECT * FROM copas";
                        $stmt = mysqli_prepare($con, $sqlMostrarCopa);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        ?>
                        <select name="copa" id="copa" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($fila = mysqli_fetch_array($result)) {
                            ?>
                                    <option value="<?php echo $fila['id'] ?>"><?php echo $fila['nombre'] ?></option>
                            <?php
                                }
                            } else {
                                echo "<option value=''>No hay Copas disponibles</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div>
                    <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Programar Partido
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>