<?php
    if(!empty($_GET['accion'])){
        if($_GET['accion'] == 'agregar-equipoGrupo'){
            $equipo = $_POST['equipo'];
            $grupo = $_POST['grupo'];
            //Verifico que no exista ese equipo en ese grupo
            $sqlVerificacion = "SELECT COUNT(*) AS existe FROM equipos_grupos
            WHERE idEquipo = ? AND idGrupo = ?";
            $consultaPreparada = mysqli_prepare($con, $sqlVerificacion);
            if($consultaPreparada) {
                mysqli_stmt_bind_param($consultaPreparada, "ii", $equipo, $grupo);
                mysqli_stmt_execute($consultaPreparada);
                $resultadoConsulta = mysqli_stmt_get_result($consultaPreparada);
                $fila = mysqli_fetch_assoc($resultadoConsulta);
                $existeEquipoenGrupo = $fila['existe'];

                if($existeEquipoenGrupo > 0) {
                    //El equipo ya esta asignado a ese grupo
                    echo "<script>alert('El equipo ya está asignado a este grupo');</script>";
                } else {
                    //Se agrega el equipo al grupo
                    $sqlInsertarEquipoGrupo = "INSERT INTO equipos_grupos (idEquipo, idGrupo) VALUES (?, ?)";
                    $Insertar = mysqli_prepare($con, $sqlInsertarEquipoGrupo);
                    if($Insertar){
                        mysqli_stmt_bind_param($Insertar, "ii", $equipo, $grupo);
                        if(mysqli_stmt_execute($Insertar)){
                            echo "<script>alert('Equipo agregado al Grupo exitosamente');</script>";
                        } else {
                            echo "<script>alert('Error al agregar el equipo al grupo');</script>";
                        }
                        mysqli_stmt_close($Insertar);
                    } else {
                        echo "<script>alert('Error en la preparación de la consulta de inserción ');</script>";
                    }
                }
                mysqli_stmt_close($consultaPreparada);
            } else {
                echo "<script>alert('Error en la consulta de verificación');</script>";
            }
            echo "<script>window.location='index.php?modulo=categoria-2010&id=1';</script>";
        }
        
    }
?>



<!doctype html>
<html lang="es">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex items-center justify-center p-12">
        <!-- Author: FormBold Team -->
        <!-- Learn More: https://formbold.com -->
        <div class="mx-auto w-full max-w-[550px]">
            <form action="index.php?modulo=agregar-equipo-a-grupo&accion=agregar-equipoGrupo" method="POST" enctype="multipart/form-data">
                <div class="mb-5">
                    <label for="equipo" class="mb-3 block text-base font-medium text-white">
                        Seleccione el Equipo
                    </label>
                    <?php
                    $idCategoria = $_GET['id'];
                    $sqlMostrarEquipos = "SELECT equipos.id , equipos.nombre
                    FROM equipos
                    WHERE idCategoria = $idCategoria";
                    $stmt = mysqli_prepare($con, $sqlMostrarEquipos);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    ?>
                    <select name="equipo" id="equipo" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($fila = mysqli_fetch_array($result)) {
                        ?>
                                <option value="<?php echo $fila['id']?>"><?php echo $fila['nombre']?></option>
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
                        Seleccione el Grupo
                    </label>
                    <?php
                    $sqlMostrarGrupos = "SELECT grupos.id , grupos.nombre
                    FROM grupos
                    WHERE idCategoria = $idCategoria";
                    $stmt = mysqli_prepare($con, $sqlMostrarGrupos);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    ?>
                    <select name="grupo" id="grupo" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($fila = mysqli_fetch_array($result)) {
                        ?>
                                <option value="<?php echo $fila['id']?>"><?php echo $fila['nombre']?></option>
                        <?php
                            }
                        } else {
                            echo "<option value=''>No hay grupos disponibles</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <button type="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Agregar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>