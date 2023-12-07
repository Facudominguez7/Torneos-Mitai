const grande = document.querySelector(".grande");
            const punto = document.querySelectorAll(".punto");

            // Declara una variable "intervalo" que se utilizará para controlar el intervalo de cambio automático de imágenes.
            let intervalo;

            // Itera a través de cada elemento HTML con la clase "punto".
            punto.forEach((cadaPunto, i) => {
              // Agrega un evento de clic a cada punto.
              cadaPunto.addEventListener("click", () => {
                // Obtiene la posición del punto en el conjunto de puntos.
                let posicion = i;

                // Calcula el valor de transformación para mover la imagen en el carrusel.
                let operacion = posicion * -33.3;

                // Aplica la transformación al elemento "grande" para cambiar la imagen.
                grande.style.transform = `translateX(${operacion}%)`;

                // Remueve la clase "activo" de todos los puntos.
                punto.forEach((cadaPunto, i) => {
                  cadaPunto.classList.remove("activo");
                });

                // Agrega la clase "activo" al punto que se hizo clic.
                cadaPunto.classList.add("activo");

                // Limpia el intervalo actual para detener el cambio automático de imágenes.
                clearInterval(intervalo);

                // Incrementa la posición para avanzar a la siguiente imagen.
                posicion++;

                // Verifica si se alcanzó la última imagen y vuelve al principio si es necesario.
                if (posicion > punto.length - 1) {
                  posicion = 0;
                }

                // Actualiza el índice de imagen actual.
                indice = posicion;

                // Inicia un nuevo intervalo de cambio automático de imágenes después de 2 segundos.
                intervalo = setInterval(moverGrande, 4000);
              });
            });

            let indice = 0;
            // Función que se encarga de cambiar automáticamente la imagen en el carrusel.
            function moverGrande() {
              // Calcula el valor de transformación para mover la imagen en el carrusel.
              let operacion = indice * -33.3;

              // Aplica la transformación al elemento "grande" para cambiar la imagen.
              grande.style.transform = `translateX(${operacion}%)`;

              // Remueve la clase "activo" de todos los puntos.
              punto.forEach((cadaPunto, i) => {
                cadaPunto.classList.remove("activo");
              });

              // Agrega la clase "activo" al punto correspondiente a la imagen actual.
              punto[indice].classList.add("activo");

              // Incrementa el índice para avanzar a la siguiente imagen.
              indice++;

              // Verifica si se alcanzó la última imagen y vuelve al principio si es necesario.
              if (indice > punto.length - 1) {
                indice = 0;
              }
            }

            // Inicia el intervalo de cambio automático de imágenes cada 2 segundos.
            intervalo = setInterval(moverGrande, 4000);