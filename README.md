# ConsultApp

**ConsultApp** es un sistema gestor de pacientes y turnos desarrollado para facilitar la administración en centros médicos, clínicas y consultorios. Esta herramienta ayuda a gestionar de manera eficiente los datos de los pacientes, sus citas y turnos, optimizando el flujo de trabajo.

## Descripción

Este proyecto se centra en proporcionar una solución moderna y eficiente para los pequeños y medianos servicios de salud que necesitan mejorar la organización de sus actividades diarias. Se basa en tecnologías web para garantizar accesibilidad y facilidad de uso.

El sistema incluye funciones como:

- Gestión de pacientes (registro, consulta y edición de datos).
- Administración de turnos y citas.
- Interfaz intuitiva y fácil de usar.

## Tecnologías Utilizadas

El proyecto está desarrollado principalmente con las siguientes tecnologías:

- **JavaScript (86.8%)**: Utilizado para la interactividad y funcionalidad en el cliente.
- **PHP (8.1%)**: Backend del sistema para gestionar la lógica del servidor.
- **Blade (5.1%)**: Motor de plantillas usado para las vistas, como parte del framework Laravel.

## Requisitos del Proyecto

Antes de iniciar, asegúrate de tener instaladas las siguientes herramientas:

- [PHP](https://www.php.net/downloads) (versión 8.0 o superior).
- [Composer](https://getcomposer.org).
- [Node.js y npm](https://nodejs.org).
- Un servidor web como [Apache](https://httpd.apache.org) o [Nginx](https://nginx.org).

## Instalación

Sigue los pasos para configurar el proyecto localmente:

1. Clona el repositorio:
   ```bash
   git clone https://github.com/n0guera/consultapp.git
   cd consultapp
   ```

2. Instala las dependencias de PHP con Composer:
   ```bash
   composer install
   ```

3. Instala las dependencias de JavaScript con npm:
   ```bash
   npm install
   ```

4. Configura el archivo de entorno `.env`:
   ```bash
   cp .env.example .env
   ```
   Ajusta las configuraciones (base de datos, claves, etc.) según tu entorno.

5. Genera la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

6. Ejecuta las migraciones y seeders para configurar la base de datos:
   ```bash
   php artisan migrate --seed
   ```

7. Inicia el servidor de desarrollo:
   ```bash
   php artisan serve
   ```

Accede a la aplicación en **[http://localhost:8000](http://localhost:8000)**.

## Características

- Gestión eficiente y centralizada de turnos.
- Registro detallado de pacientes.
- Integración de vistas dinámicas con Blade.
- Desempeño optimizado con Laravel.

## Contribuciones

Todos son bienvenidos para contribuir al desarrollo de este proyecto. Si deseas colaborar, sigue estos pasos:

1. Haz un fork del repositorio.
2. Crea una rama para tu contribución:
   ```bash
   git checkout -b feature/mi-contribucion
   ```
3. Realiza tus cambios y actualiza el `README.md` si es necesario.
4. Envía un pull request.

## Licencia

Este proyecto está licenciado bajo la [MIT License](LICENSE).

## Contacto

Para preguntas o sugerencias sobre el proyecto, contáctame en [n0guera](https://github.com/n0guera).

¡Gracias por usar **ConsultApp**!