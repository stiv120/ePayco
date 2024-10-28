<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Logo Laravel">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Estado de construcción">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Descargas totales">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Última versión estable">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="Licencia">
  </a>
</p>

## Acerca de Laravel

Laravel es un framework de aplicaciones web con una sintaxis expresiva y elegante. Creemos que el desarrollo debe ser una experiencia agradable y creativa para ser realmente satisfactorio. Laravel elimina el dolor del desarrollo facilitando tareas comunes utilizadas en muchos proyectos web, tales como:

-   [Motor de enrutamiento simple y rápido](https://laravel.com/docs/routing).
-   [Potente contenedor de inyección de dependencias](https://laravel.com/docs/container).
-   Múltiples back-ends para almacenamiento de [sesión](https://laravel.com/docs/session) y [caché](https://laravel.com/docs/cache).
-   Expresivo e intuitivo [ORM de base de datos](https://laravel.com/docs/eloquent).
-   Base de datos agnóstica [migraciones de esquema](https://laravel.com/docs/migrations).
-   [Procesamiento robusto de tareas en segundo plano](https://laravel.com/docs/queues).
-   [Transmisión de eventos en tiempo real](https://laravel.com/docs/broadcasting).

Laravel es accesible, potente y proporciona las herramientas necesarias para aplicaciones grandes y robustas.

## Acerca de este proyecto

El siguiente proyecto es un sistema ePayco El sistema debe poder registrar un cliente, cargar dinero a la billetera, hacer una compra con un código de confirmación y consultar el saldo de la billetera, consta de dos componentes principales:

## 1. Sistema ePayco

-   Incluye los modelos de clientes, billeteras y transacciones de billeteras.
-   Utiliza el sistema de validación de Laravel a través de los form requests.
-   Gestiona errores devolviendo respuestas JSON apropiadas.
-   Sigue las mejores prácticas de desarrollo utilizando una arquitectura limpia cómo lo es la arquitectura hexagonal y DDD(Domain Driven Design), separando la lógica de negocio de la lógica de presentación, en la cual agregué una carpeta SRC la cual contiene el servicio soap, en cada módulo, cada una contiene las 3 capas de la arquitectura las cuales son aplicación, dominio e infraestructura y se cargan en el composer.json en el autoload/psr-4 y rest-service con node.

## 2. Pruebas

-   Incluye pruebas unitarias.

## Instalación

1. Clonamos el repositorio:
    ```sh
    git clone https://github.com/stiv120/ePayco.git
    ```
2. Accedemos al directorio en la ruta donde lo descargamos:

    ```sh
    cd ePayco
    ```

## Mediante docker

Dado que nuestra aplicación se ha integrado con Docker, si queremos usarlo, debemos tener instalado Docker Desktop en nuestra máquina, si no lo tienes, aquí tienes el enlace de descarga: https://www.docker.com/products/docker-desktop/ para que nuestra aplicación y los comandos que se dan a continuación funcionen.

## Iniciamos la aplicación

1. Ejecutamos el siguiente comando:

    ```sh
    docker compose up -d
    ```

    Esto levantará el contenedor, con todos los servicios que necesitamos para ejecutar nuestra aplicación, incluido el servidor a través del cual accederemos a ella a través de este enlace: http://localhost:8081 para ver la aplicación.

2. Accedemos a nuestro contenedor usando el siguiente comando:

    ```sh
    docker exec -it app bash
    ```

3. Luego usando el siguiente comando instalamos las dependencias de Laravel

    ```sh
    composer install
    ```

4. Copiamos el archivo .env.example a .env

    ```sh
    cp .env.example .env
    ```

5. Generamos la clave de la aplicación.

    ```sh
    php artisan key:generate
    ```

6. Generamos la clave de pruebas.

    ```sh
    php artisan key:generate --env=testing
    ```

7. Ejecutamos las migraciones de nuestra bd del sistema utilizando el siguiente comando:

    ```sh
    php artisan migrate
    ```

## Pruebas

1. Para ejecutar las pruebas, accedemos a nuestro contenedor mediante el siguiente comando:

    ```sh
    docker exec -it app bash
    ```

2. Una vez dentro de nuestro contenedor, ejecutamos el siguiente comando:

    ```sh
    php artisan test
    ```

    Esto ejecuta el observador de pruebas en modo interactivo.

3. Nota: Si los test nos fallan y sale mensaje de que no se puede conectar test_db, ejecutamos el siguiente comando:

    ```sh
    php artisan migrate --env=testing
    ```

Nos va a preguntar que si querems crearla colocmos la letra y, le damos enter y después Y volvemos a ejecutar el comando anterior para correr las pruebas y podemos comprobar que funcionan.

## Acceder a phpMyAdmin

Accedemos a través del siguiente enlace: http://localhost:8080, podemos ver que nuestras base de datos de pruebas y de producción se han creado correctamente.

## Acceso del sistema

Para probar las rutas de nuestro sistema lo he divido en dos partes, una es mediante APIs.

## Mediante API

Nota: En mi caso, he utilizado Postman para probar las APIs. Si no lo tienes instalado, aquí tienes el enlace:
https://www.postman.com/downloads/

Introducimos los datos requeridos en el cuerpo de la petición.

## Registrar clientes

Ruta de acceso: http://localhost:3000/clientes/registrar método POST

## Recargar billetera

Ruta de acceso: http://localhost:3000/billeteras/recargar método POST

## Realizar pago

Ruta de acceso: http://localhost:3000/transacciones-billeteras/realizar-pago método POST

## Confirmar pago

Ruta de acceso: http://localhost:3000/transacciones-billeteras/confirmar-pago/{idBilletera} método POST

## Consultar saldo

Ruta de acceso: http://localhost:3000/billeteras/consultar-saldo método POST
