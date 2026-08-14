## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

### Install

    composer install

### Requirements
```sh
PHP >= 5.4.0
```

## Front-end Requirements
```sh
Tener instalado Ruby en su ultima versión junto con su gestor de paquetes gem, installar sass con el comando por consola "gem install sass"; instalar la libreria de compass para sass con los comando "apt-get install ruby-dev", seguido "gem install compass".
```
### Install (front-end)
1. Descargar Node.js junto con su gestor de paquetes(npm).
2. Desde la terminal (consola), posicionarse en la raiz del proyecto **-- /plataforma --** y ejecutar **-- npm install --** (se instalaran todas las dependencias del proyecto en la raiz **-- /plataforma/node_modules**).
3. Installar bower de forma global, con el comando **-- npm isntall -g bower**
4. Ejecutar desde la terminal (consola) en la ruta del proyecto **-- bower install --** (se instala las dependencias para el front-end en la ruta **-- /plataforma/resources/assets/libs**).
5. Ejecutar desde la terminal (consola) **-- npm install -g gulp-cli --** para instalar el administrador de tareas y su CLI
6. Si desea realizar cambios a los archivos del proyecto ejecutar las tareas de gulpfile.js primordialmente desde la terminal haciendo referencia a la ruta del proyecto y con el comando **-- gulp --**. y modificar unicamente los archivos en el directorio **-- /plataforma/resources/assets**... **_Para otras opciones de gulp ejecutar ->_ gulp --application** (Ejecuta solo tareas de la plataforma), **gulp --landing** (Ejecuta solo tareas para el landing), **gulp --realtime** (Ejecuta solo tareas para el realtime), **gulp --copy** (Ejecuta tareas de copiado solamente).

> Nota: Despues de haber instalado las dependencias de front-end con **bower** ir a la carpeta "../libs o ../bower_componets" segun la haya nombrado e ir a la carpeta del plugin **fine-uploader** y realizar lo siguiente:
```sh
- Desde la terminal acceder a la carpeta con el comando "cd fine-uploader"
- Correr desde la ubicación de fine-uploader - "npm install"
- Y luego ejecutar "grunt package"
```

### Preparación del componente para notificaciones - Realtime
Installar la base de datos **Redis** [¿Como optimizar redis?](http://redis.io/topics/quickstart):
```sh
$ wget http://download.redis.io/redis-stable.tar.gz
$ tar xvzf redis-stable.tar.gz
$ cd redis-stable
$ make
```
The binaries that are now compiled are available in the src directory. Run Redis with:
```sh
$ src/redis-server
```
Ir a raiz del proyecto "/plataforma":
```sh
$ cd plataforma
```
Instalar dependencias node para realtime:
```sh
$ npm install
```
Compilar proyecto realtime:
```sh
$ gulp --realtime
```
**_Abra las siguientes ventanas/pestañas en la terminal (consola):_**
* En la primera inicie el servidor node:
```sh
$ npm start
```
* En la segunda inicie el servidor redis:
```sh
$ redis-server (--port 3001)
```
* En la tercera inicie la base de datos **mongodb**
```sh
$ mongod
```
* (opcional) En la cuarta inicia la _SHELL_ para la base de datos **mongodb**
```sh
$ mongo start
```
### Branch
Lista las ramas disponibles
```sh
$ git branch
* master
```
Crea una nueva rama
```sh
$ git branch feature
$ git branch
* master
  feature
```
Cambiar de rama
```sh
$ git checkout feature
Switched to branch 'feature'
```
Crea y cambia inmediatamente a una rama
```sh
$ git checkout -b feature
```
Elimina una rama local
```sh
$ git branch -d feature
```
Elimina una rama remota
```sh
$ git push origin --delete feature
```
La opción -D elimina la rama sin importar el estatus en que se encuentre el merge, así que utilizalo con cuidado.
```sh
$ git branch -D feature
```
Renombrar la rama
```sh
$ git branch -m feature - feature-newregister
```
Lista las funciones
```sh
$ git branch -h
```
Estado actual del repositorio
```sh
$ git log --oneline --decorate --all --graph
```
### Truco git alias
```sh
$ git config  --global alias.lodag 'log --oneline --decorate --all --graph'
$ git lodag
```
### Commits branch
Nos cambiamos ala rama nueva
```sh
$ git checkout feature
$ git add .
$ git commit -m'primer commit branch feature'
$ git lodag
(Head->feature)'primer commit branch feature'  apunta al commit de la nueva rama
```
### Fusionar ramas con merge
```sh
$ git checkout master
$ git merge feature
/*update
fast-forward*/ Este avance rapido ocurre cuando una rama que tiene modificaciones se fusiona con una rama que no las tiene.
Cuando lo hace en ramas que tienes cambios lo hara con la estrategia recursiva
```
### Subir y bajar una rama local a un repositorio git remoto
```sh
Subir la rama local a la remota
$ git checkout master
$ git add --all
$ git commit -m'new branch'
$ git push -u origin feature
Bajar la rama remota a local
$ git fetch origin feature
Bajar cambios
$ git pull origin feature
```
