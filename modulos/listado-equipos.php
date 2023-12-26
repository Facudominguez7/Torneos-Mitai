<!doctype html>
<html lang="en">
<body>
    <header class="bg-[--color-primary] shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-3 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white">
                Tabla de Equipos
            </h1>
            <br />
        </div>
    </header>
    <div class="flex justify-center mt-10 mb-0">
        <a href="index.php?modulo=agregar-equipo&accion=agregar">
            <button class="middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                Agregar Equipo
            </button>
        </a>
    </div>

    <section class="mx-auto w-full max-w-2xl flex justify-center items-stretch pb-4 px-4 sm:px-6 lg:px-8">
        <table class="border-collapse w-full mt-5">
            <thead>
                <tr>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Logo</th>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Nombre</th>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Categoria</th>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Accion</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sqlMostrarEquipos = "SELECT equipos.id, equipos.idCategoria, equipos.nombre, equipos.foto, 
                categorias.nombreCategoria  
                 FROM equipos
                 LEFT JOIN categorias ON equipos.idCategoria = categorias.id
                 ORDER BY categorias.nombreCategoria ASC";
                $datos = mysqli_query($con, $sqlMostrarEquipos);
                if ($datos->num_rows > 0) {
                    while ($fila = mysqli_fetch_array($datos)) {
                ?>
                        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                            <td class="w-full lg:w-auto p-3 text-gray-800 flex justify-center border border-b  lg:table-cell relative lg:static">
                                <img class="h-24 w-24" src="Imagenes/<?php echo $fila['foto'];?>" alt="logo <?php echo $fila['nombre'];?>">
                            </td>

                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">nombre</span>
                                <?php echo $fila['nombre'];?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Categoria</span>
                                <?php echo $fila['nombreCategoria'];?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b  block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Accion</span>
                                <a href="index.php?modulo=editar-equipo&accion=editar&id=<?php echo $fila['id'];?>" class="text-blue-400 hover:text-blue-600 underline">Editar</a>
                                <a href="index.php?modulo=eliminar-equipo&id=<?php echo $fila['id'];?>" class="text-blue-400 hover:text-blue-600 underline pl-6">Eliminar</a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                        <td colspan="3" class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            No existen registros
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </section>

</body>

</html>