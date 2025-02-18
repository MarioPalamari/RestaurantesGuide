# Guía de Restaurantes

## Información del Proyecto
Este proyecto consiste en la creación de una guía de restaurantes de saborea Madrid utilizando el framework Laravel. El objetivo es permitir a los usuarios buscar restaurantes según diferentes criterios y gestionarlos con un sistema de roles.

## Funcionamiento
- **Usuarios Estándar**: Pueden buscar restaurantes por precio medio, valoración y tipo de cocina. También pueden registrarse, iniciar sesión y dejar valoraciones.
- **Administradores**: Pueden gestionar los restaurantes (agregar, modificar y eliminar) y recibir notificaciones por correo cuando se realizan cambios.
- **Sistema de Valoración**: Los usuarios registrados pueden puntuar los restaurantes y dejar comentarios.
- **Autenticación**: Solo los usuarios registrados pueden interactuar con la plataforma.

## Ubicación de la Base de Datos
- La base de datos se configura mediante **Laravel Migrations**.
- Archivo de configuración: `.env` y `database.php` (definir las credenciales de la base de datos aquí).
- Para ejecutar las migraciones: `php artisan migrate --seed` (con datos de prueba incluidos).

## Instalación y Ejecución
1. Clonar el repositorio:  
   ```bash
   git clone https://github.com/usuario/repository.git
   cd repository
   ```
2. Instalar las dependencias:  
   ```bash
   composer install
   npm install
   ```
3. Configurar el entorno:
   - Copiar el archivo de ejemplo `.env.example` y renombrarlo a `.env`.
   - Configurar las credenciales de la base de datos.
   - Generar la clave de la aplicación:  
     ```bash
     php artisan key:generate
     ```
4. Ejecutar las migraciones y poblar la base de datos:
   ```bash
   php artisan migrate --seed
   ```
5. Iniciar el servidor:
   ```bash
   php artisan serve
   ```
## Instalación y Ejecución
     - Admin:
         Usuario: admin@example.com
         Contraseña: qweQWE123
     - Usuario estandar:
         Usuario: usuario1@example.com
         Contraseña: qweQWE123
## Miembros del Grupo
- **Roberto Noble**
- **Mario Palamari**
- **Julio Carrillo**
