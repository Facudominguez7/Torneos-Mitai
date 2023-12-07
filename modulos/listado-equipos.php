<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#0ed3cf">
    <meta name="msapplication-TileColor" content="#0ed3cf">
    <meta name="theme-color" content="#0ed3cf">

    <meta property="og:image" content="https://tailwindcomponents.com/storage/919/temp66535.png?v=2023-11-29 14:49:00" />
    <meta property="og:image:width" content="1280" />
    <meta property="og:image:height" content="640" />
    <meta property="og:image:type" content="image/png" />

    <meta property="og:url" content="https://tailwindcomponents.com/component/responsive-table/landing" />
    <meta property="og:title" content="Responsive Table by Lirux" />
    <meta property="og:description" content="A Responsive Table for Tailwind CCSS" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@TwComponents" />
    <meta name="twitter:title" content="Responsive Table by Lirux" />
    <meta name="twitter:description" content="A Responsive Table for Tailwind CCSS" />
    <meta name="twitter:image" content="https://tailwindcomponents.com/storage/919/temp66535.png?v=2023-11-29 14:49:00" />

    <link rel="canonical" href="https://tailwindcomponents.com/component/responsive-table" itemprop="URL">

    <title>Responsive Table by Lirux. </title>

    <link href="https://unpkg.com/tailwindcss@1.0.4/dist/tailwind.min.css" rel="stylesheet">
</head>

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
                 LEFT JOIN categorias ON equipos.idCategoria = categorias.id";
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