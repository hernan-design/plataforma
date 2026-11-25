# Plataforma TuProyecto

Portal web y plataforma principal para la gestión de proyectos, emprendedores, mentores, eventos, foros de discusión y marketplace.

---

## 🚀 Stack Tecnológico Actualizado

### Backend
* **Lenguaje:** [PHP 8.4](https://www.php.net/)
* **Framework:** [Laravel 13.x](https://laravel.com/)
* **Manejador de Paquetes:** [Composer 2.x](https://getcomposer.org/)
* **Bases de Datos:**
  * **PostgreSQL:** Base de datos relacional principal (usuarios, proyectos, transacciones).
  * **MongoDB:** Base de datos documental NoSQL (`mongodb/laravel-mongodb ^5.11`, extensión PECL `mongodb`).
* **Autenticación y Seguridad:**
  * `tymon/jwt-auth` (^2.3)
  * `laravel/socialite` (^5.31)
* **Librerías y Servicios Clave:**
  * `aws/aws-sdk-php-laravel` (^3.11)
  * `intervention/image` (^4.3)
  * `barryvdh/laravel-dompdf` (^3.1)
  * `google/apiclient` (^2.20)
  * `spatie/laravel-activitylog` (^5.1)
* **Testing:** PHPUnit 13.x / Mockery 1.6

### Frontend
* **Empaquetador / Bundler:** [Vite 5.x](https://vitejs.dev/) con `laravel-vite-plugin` y `@vitejs/plugin-react` *(modernizado desde Gulp / Bower / Elixir)*
* **Librería UI:** [React 18.2](https://react.dev/) + React DOM
* **Gestor de Estado:** Redux + React-Redux
* **Estilos:** Sass (Dart Sass `^1.72`) + Bootstrap Sass 3.4
* **Editor WYSIWYG:** Summernote `^0.9.1` con `react-summernote` y plugin `summernote-cleaner`
* **Entorno JS:** Node.js 18.x / 20.x LTS

---

## 📋 Requisitos del Entorno

1. **PHP >= 8.4** con extensiones:
   * `pdo_pgsql`, `pgsql`
   * `mongodb` (extensión PECL habilitada)
   * `gd` (con soporte Freetype y JPEG)
   * `zip`, `soap`, `bcmath`, `exif`, `calendar`
2. **Composer >= 2.2**
3. **Node.js >= 18.x o 20.x** y **npm >= 9.x**
4. **PostgreSQL >= 14**
5. **MongoDB >= 5.0 / 6.0 / 7.0**
6. **Redis Server** (para colas y componentes en tiempo real)

---

## ⚙️ Instalación y Puesta en Marcha

### 1. Clonar el Repositorio
```bash
# Vía HTTPS
git clone https://github.com/hernan-design/plataforma.git
cd plataforma

# O vía SSH
git clone git@github.com:hernan-design/plataforma.git
cd plataforma
```

### 2. Configurar Variables de Entorno
Copiar el archivo de ejemplo y configurar las credenciales:
```bash
cp .env.example .env
```

Configurar los parámetros esenciales en `.env`:
```env
APP_NAME=TuProyecto
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8001

# Conexión PostgreSQL
# Si se ejecuta fuera de Docker (en el host): DB_HOST=127.0.0.1 y DB_PORT=5433
# Si se ejecuta dentro del contenedor Docker: DB_HOST=postgres y DB_PORT=5432
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=tu_proyecto_db
DB_USERNAME=postgres
DB_PASSWORD=postgres

# Conexión MongoDB
# Si se ejecuta fuera de Docker (en el host): MDB_HOST=127.0.0.1 y MDB_PORT=27018
# Si se ejecuta dentro del contenedor Docker: MDB_HOST=mongodb y MDB_PORT=27017
MDB_HOST=mongodb
MDB_PORT=27017
MDB_DATABASE=tuproyecto
MDB_USERNAME=
MDB_PASSWORD=

# Conexión Redis
REDIS_CLIENT=predis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 3. Instalación de Dependencias Backend
```bash
composer install
```

### 4. Generación de Claves
```bash
php artisan key:generate
php artisan jwt:secret
```

### 5. Migraciones y Seeders
```bash
php artisan migrate
# (Opcional si se requiere poblar datos iniciales)
php artisan db:seed
```

### 6. Instalación de Dependencias Frontend
```bash
npm install
```

---

## 💻 Desarrollo y Compilación Frontend (Vite)

El entorno frontend se compila y ejecuta con **Vite**:

* **Modo Desarrollo (HMR / Recarga en Caliente):**
  ```bash
  npm run dev
  ```
  Inicia el servidor de desarrollo Vite (por defecto en `http://127.0.0.1:5173`) con recarga en vivo de componentes React y estilos Sass.

* **Modo Producción (Compilación):**
  ```bash
  npm run build
  ```
  Genera los paquetes optimizados y minificados en `public/build/` junto con su `manifest.json`.

---

## 🔔 Microservicio de Tiempo Real (Notificaciones y WebSockets)

El módulo de notificaciones y eventos en tiempo real se ejecuta como un microservicio independiente en **Node.js** con **Express** y **Socket.IO**, integrándose con **Redis (Pub/Sub)** y **MongoDB**:

### 1. Prerrequisitos de Infraestructura
Asegurarse de que los servicios de persistencia estén levantados (vía Docker o locales):
* **Redis:** En el puerto `6380` del host (o `6379` en red Docker).
* **MongoDB:** En el puerto `27018` del host (o `27017` en red Docker).

### 2. Iniciar el Microservicio
Desde la carpeta `plataforma/`:
```bash
# Opción 1 (Directa con Node):
node server-realtime.js

# Opción 2 (Vía npm script):
npm run realtime
```

### 3. Puertos y Endpoints Clave
* **Puerto:** `8443` (por defecto `http://localhost:8443` o configurado vía `REACT_PORT`).
* **Namespace Socket.IO:** `/nsp-notify`
* **Health Check (Estado de salud):**
  ```bash
  curl http://localhost:8443/health
  ```
  Respuesta esperada:
  ```json
  {"status":"ok","service":"tuproyecto-realtime","mongo":"connected","activeSockets":0}
  ```

### 4. Diagnóstico y Solución de Errores Comunes
* **`net::ERR_CONNECTION_REFUSED` en el navegador (`realtime.app.js`):**
  * **Causa:** El microservicio no está encendido o fue detenido.
  * **Solución:** Ejecutar `node server-realtime.js` en una terminal.
* **`Error: listen EADDRINUSE: address already in use 0.0.0.0:8443`:**
  * **Causa:** Ya existe un proceso escuchando en el puerto 8443.
  * **Solución:** Cerrar la instancia previa o matar el proceso en el puerto 8443 antes de volver a iniciarlo.

---

## 🧹 Mantenimiento de Caché y Permisos

Para actualizar cambios de configuración o resolver problemas de permisos en entornos de desarrollo y despliegues:

```bash
# Limpieza de caché
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Regenerar autoload
composer dump-autoload

# Permisos de carpetas de escritura (Linux / macOS)
chmod -R 775 storage bootstrap/cache
```

---

## 🐳 Ejecución con Docker

El proyecto incluye un `Dockerfile` optimizado sobre `php:8.4-apache` con extensiones compiladas y Apache configurado:

```bash
# Construir la imagen
docker build -t tuproyecto-plataforma:latest .

# Ejecutar el contenedor
docker run -d -p 8080:80 --name tuproyecto_plataforma_app tuproyecto-plataforma:latest
```

---

## 🌿 Flujo de Trabajo Git y Buenas Prácticas

Guía rápida de referencia para el equipo de desarrollo:

* **Listar ramas locales:**
  ```bash
  git branch
  ```
* **Crear una nueva rama de funcionalidad y cambiarse a ella:**
  ```bash
  git checkout -b feature/nombre-tarea
  ```
* **Configurar alias para ver historial de commits de forma visual:**
  ```bash
  git config --global alias.lodag "log --oneline --decorate --all --graph"
  git lodag
  ```
* **Guardar cambios y realizar commit:**
  ```bash
  git add .
  git commit -m "feat: descripción del cambio"
  ```
* **Subir rama al repositorio remoto:**
  ```bash
  git push -u origin feature/nombre-tarea
  ```
* **Fusionar rama a master:**
  ```bash
  git checkout master
  git pull origin master
  git merge feature/nombre-tarea
  ```
* **Eliminar rama local una vez integrada:**
  ```bash
  git branch -d feature/nombre-tarea
  ```

---

## 📁 Estructura del Proyecto

* `app/`: Modelos Eloquent y MongoDB, controladores, observers y lógica central.
* `resources/assets/js/`: Código fuente React, vistas SPA, componentes de UI y editores Summernote.
* `resources/assets/sass/`: Estilos Sass (`application.scss`, `landing.scss`, variables y módulos).
* `resources/views/`: Vistas y plantillas Blade de Laravel.
* `routes/`: Definición de rutas web, API y canales.
* `public/build/`: Salida generada por Vite para producción.
* `vite.config.js`: Configuración de Vite adaptada a Laravel y React.
