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
            <form action="index.php?modulo=agregar-equipo&accion=agregar-equipo" method="POST" enctype="multipart/form-data">
                <div class="mb-5">
                    <label for="nombre" class="mb-3 block text-base font-medium text-white">
                        Nombre del Equipo
                    </label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre del equipo" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required/>
                </div>
                <div class="mb-5">
                    <label for="category" class="mb-3 block text-base font-medium text-white">
                        Categoría del Equipo
                    </label>
                    <select name="categoria" id="categoria" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                        <option value="1">Categoría 2010</option>
                        <option value="2">Categoría 2011</option>
                        <option value="3">Categoría 2012</option>
                        <option value="4">Categoría 2013</option>
                        <option value="5">Categoría 2014</option>
                        <option value="6">Categoría 2015</option>
                        <option value="7">Categoría 2016</option>
                        <option value="8">Categoría 2017</option>
                        <option value="9">Categoría 2018</option>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="foto" class="mb-3 block text-base font-medium text-white">
                        Agregar Logo
                    </label>
                    <input type="file" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" id="foto" name="foto" required>
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

<?php
if (!empty([$_GET['accion']])) {
    if ($_GET['accion'] == 'agregar-equipo') {   
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        

        //Verifico que no exista ese equipo
        $sql = "SELECT * FROM equipos where nombre = '$nombre' AND idCategoria = $categoria";
        $sql = mysqli_query($con, $sql);
        if(mysqli_num_rows($sql) != 0){
            echo "<script> alert('EL EQUIPO YA EXISTE EN LA BD');</script>";
        } else {

            //procesar foto
            if (is_uploaded_file($_FILES['foto']['tmp_name'])){
                //Copiar en el directorio
                $nombreFoto = explode('.', $_FILES['foto']['name']);
                $foto = time() . '.' . end($nombreFoto);
                copy($_FILES['foto']['tmp_name'], 'Imagenes/' . $foto);
            }
            //fin procesar foto

            //insertar equipo
            $sqlAgregarEquipo = "INSERT INTO equipos (nombre,idCategoria,foto) values ('$nombre', $categoria, '{$foto}')";
            $resultadoAgregarEquipo = mysqli_query($con, $sqlAgregarEquipo);
            if (mysqli_error($con)) {
                echo "<script>alert('Error no se pudo insertar el registro');</script>";
            } else {
                echo "<script>alert('Equipo Agregado con Exito');</script>";
            }
        }
        echo "<script>window.location='index.php?modulo=listado-equipos';</script>";
    }
   
}

?>

</html>