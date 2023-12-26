<!doctype html>
<html lang="en">

<style>
    input::placeholder {
        color: white;
    }
</style>

<body class="bg-gray-200">
    <div class="flex h-screen w-full items-center justify-center bg-gray-900 bg-cover bg-no-repeat" style="background-image:url('Imagenes/fondo_en_cancha.webp')">
        <div class="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-lg backdrop-blur-md max-sm:px-8">
            <div class="text-white">
                <div class="mb-8 flex flex-col items-center">
                    <img src="Imagenes/Logo_Mitai_SinFondo.png" width="150" alt="Logo_Mitai_SinFondo" srcset="" />
                    <h1 class="mb-2 text-2xl">Torneos Mitai</h1>
                    <a  href="index.php?modulo=registro">
                        <h1 class="text-white hover:bg-blue-600 rounded-lg p-2">No tiene una cuenta? Registrarse</h1>
                    </a>
                </div>
                <form action="#">
                    <div class="mb-4 text-lg">
                        <input class="rounded-3xl border-none bg-blue-500 bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="text" name="name" placeholder="id@email.com" />
                    </div>

                    <div class="mb-4 text-lg">
                        <input class="rounded-3xl border-none bg-blue-500 bg-opacity-50 px-6 py-2 text-center text-inherit placeholder-slate-200 shadow-lg outline-none backdrop-blur-md" type="Password" name="name" placeholder="*********" />
                    </div>
                    <div class="mt-8 flex justify-center text-lg text-black">
                        <button type="submit" class="rounded-3xl bg-yellow-200 bg-opacity-50 px-10 py-2 text-white shadow-xl backdrop-blur-md transition-colors duration-300 hover:bg-yellow-700">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>