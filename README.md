# API REST liviana con SLIM y Mysql

Basados en la documentacion oficial de slim hemos creado un projecto.
Pero desafortunadamente, no tenia implementada la base de datos.
Por tal razon hemos modificado los archivos relacionados con docker, para
cargar una base de datos.
Y hemos generado un Modulo que implementa la conexion y manejo de la DB Mysql.


## Paso 1 ##

Ejecutar el siguiente comando para descargar el frmework
```
sudo docker run --rm --interactive --tty  --volume $PWD:/app  composer:1.1  create-project slim/slim-skeleton:4.1 project1
```
Utilizamos composer 1.1 por que la version 2 es incompatibe.


## Paso 2 ##
Luego cargar las dependencias de otras librerias.
```
sudo docker run --rm --interactive --tty  --volume $PWD:/app  composer:1.1 install
```

## Paso 3 ##

Ejecutar el siguiente comando para descargar este projecto en una carpeta temporal.

```
git clone https://github.com/garrongarron/rest-api-php-slim-docker-mysql.git project2-tmp
```

## Paso 4 ##
Ahora copiamos la carpeta oculta .git y la insertamos en el projecto que contiene el framework.
```
mv project2-tmp/.git project1/.git
```

## Paso 5 ##
Ahora eliminamos el proyecto temporal
```
rm -rf project2-tmp
```

## Paso 6 ##
Vamos al projecto principal
```
cd project1
```

y cargamos la ultima version (el ultimo commit)

```
git checkout main --force
```

## Paso 7 ##

Para iniciar el projecto ejecutar lo siguiente

```
sudo docker-compose up
```

## Paso 8 ##
ya puedes ir al browser a 

```
http://0.0.0.0:8080/
```


Esperamos que este mini projecto les saque de algun apuro. Gracias


Documentacion official en 

```
https://www.slimframework.com/docs/v4/start/installation.html
```

-----------------------------------------------------------------------------

# Slim Framework 4 Skeleton Application

[![Coverage Status](https://coveralls.io/repos/github/slimphp/Slim-Skeleton/badge.svg?branch=master)](https://coveralls.io/github/slimphp/Slim-Skeleton?branch=master)

Use this skeleton application to quickly setup and start working on a new Slim Framework 4 application. This application uses the latest Slim 4 with Slim PSR-7 implementation and PHP-DI container implementation. It also uses the Monolog logger.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

```bash
composer create-project slim/slim-skeleton [my-app-name]
```

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writable.

To run the application in development, you can run these commands 

```bash
cd [my-app-name]
composer start
```

Or you can use `docker-compose` to run the app with `docker`, so you can run these commands:
```bash
cd [my-app-name]
docker-compose up -d
```
After that, open `http://localhost:8080` in your browser.

Run this command in the application directory to run the test suite

```bash
composer test
```

That's it! Now go build something cool.
