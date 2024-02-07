<section>
    <div class="flex justify-center items-center mt-5">
        <?php
        if (!isset($_GET['idEdicion'])) {
        ?>
            <button class="hidden mb-1 middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                <a href="index.php?modulo=listado-equipos">
                    Tabla de Equipos
                </a>
            </button>
        <?php
        } else {
            $idEdicion = $_GET['idEdicion'];
        ?>
            <button class="mb-1 middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
                <a href="index.php?modulo=listado-equipos&idEdicion=<?php echo $idEdicion?>">
                    Tabla de Equipos
                </a>
            </button>
        <?php
        }
        ?>

    </div>
    <div class="flex justify-center items-center mt-5">
        <button class=" mb-1 middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-light="true">
            <a href="index.php?modulo=usuarios">
                Usuarios
            </a>
        </button>
    </div>
</section>