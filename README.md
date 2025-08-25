# Proyecto Laravel-React

Este proyecto está preparado para trabajar con Laravel usando Composer dentro de un contenedor Docker o directamente en tu entorno local.
Este proyecto utiliza tambien React.js con npm.  

---

## 🚀 Requisitos

- [Docker Desktop](https://www.docker.com/products/docker-desktop) (Windows. Si quieres usar contenedor en lugar de instalar PHP localmente)
- [Composer](https://getcomposer.org/) (Necesario)
- PHP >= 8.1 (si trabajas sin Docker)
- MySQL/MariaDB (si trabajs sin Docker)

- Node.js >= 18.x
- npm >= 9.x

---

- ## ⚙️ Configuración inicial

### 1. Clonar el repositorio: git clone 

### 2. Si se quiere utilizar docker compose en backend

Construir la imagen en la carpeta backend(Se encuentra el docker-compose.yml): docker compose build

Crear e iniciar los contenedores: docker compose up -d

Detener y eliminar los contenedores: docker compose down

Ejecutar migraciones y seeders: docker compose exec laravel-app php artisan migrate --seed

Entar al contenedor: docker compose exec laravel-app bash

Instalar dependencias: composer install

.env configuracion: 
        DB_CONNECTION=mysql
        DB_HOST=mysql           # nombre del servicio definido en docker-compose
        DB_PORT=3306
        DB_DATABASE=laravel
        DB_USERNAME=sail
        DB_PASSWORD=password

### 3. Sin docker compose

- Instalar dependencias: composer install

- Configurar .env para la conexion a MySQL
  
- Levantar servidor local: php artisan serve

- Ejecutar migraciones mas seeders: php artisan migrate --seed

- Ejecutar test: php artisan test

### 4. Proyecto React.js

- Instalación de dependencias desde la raíz del proyecto, ejecuta: npm install

- .env :
  Con Docker compose: VITE_API_LOCAL=http://localhost:9000
  Sin Docker compose: VITE_API_LOCAL=http://localhost:8000

- Ejecutar proyecto en modo desarrollo: npm run dev
