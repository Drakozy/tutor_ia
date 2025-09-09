# 🧠 PHP Tutor con IA (Cohere)

Este es un proyecto web desarrollado en PHP que permite a los usuarios realizar consultas tipo chat a un tutor impulsado por inteligencia artificial mediante la API de Cohere. Las respuestas son procesadas en tiempo real y almacenadas junto con la consulta del usuario.

## 🚀 Funcionalidades

- Registro e inicio de sesión de usuarios
- Control de acceso por roles (`usuario`, `analista`, `admin`)
- Envío de preguntas a un tutor con IA (usando la API de Cohere)
- Almacenamiento de las preguntas y respuestas en la base de datos
- Visualización de historial de consultas
- Paneles diferenciados según el rol

## ⚙️ Requisitos

- PHP 7.4 o superior
- Servidor web (Apache, Nginx, etc.)
- MariaDB / MySQL

## 🔧 Instalación

1. Clona o descarga este repositorio.

2. Crea la base de datos:

   Puedes elegir una de las siguientes opciones para crear la base de datos y las tablas necesarias:

   **Opción 1: Ejecutar el archivo `init.sql` para crear una nueva base de datos desde cero:**

   - Abre tu terminal o símbolo del sistema.
   - Ejecuta el siguiente comando, reemplazando `usuario` por tu nombre de usuario de MySQL, y asegúrate de que el archivo `init.sql` se encuentra en el directorio `database`:

     ```bash
     mysql -u usuario -p < database/init.sql
     ```

   Este comando creará la base de datos y las tablas necesarias para comenzar a trabajar.

   **Opción 2: Crear manualmente la base de datos `php_tutor` e importar el archivo `php_tutor.sql`:**

   - Crea la base de datos `php_tutor` desde MySQL:
     ```sql
     CREATE DATABASE php_tutor;
     ```
   - Luego, importa el archivo `php_tutor.sql` utilizando el siguiente comando en la terminal (cambiando la ruta según sea necesario):

     ```bash
     mysql -u usuario -p php_tutor < database/php_tutor.sql
     ```

   **Nota:** Asegúrate de tener la base de datos `php_tutor` creada si eliges la opción 2, o ejecuta `init.sql` para crearla desde cero.

3. Configura el archivo `config/cohere.php` con tu clave de API de Cohere.

   Abre el archivo `config/cohere.php` y reemplaza `'tu-clave-api'` con tu clave de API de Cohere:
   ```php
   return [
       'api_key' => 'tu-clave-api'
   ];

4. Inicia tu servidor web y navega hacia la carpeta `public/` para comenzar a utilizar la aplicación.

5. Si has decidido importar los usuarios de prueba, estos se encuentran en el archivo `database/contraseñas.sql`. Este archivo contiene los usuarios, contraseñas y roles predeterminados que puedes usar en la base de datos para pruebas. 


## 📁 Estructura del Proyecto

Este es el esquema de carpetas de la aplicación:

```plaintext
📁 php_tutor/
├── 📁 config/
│   ├── 🛠️ cohere.php
│   └── 🛠️ db.php
│
├── 📁 database/
│   ├── 🗄️ contraseñas.sql
│   ├── 🗄️ init.sql
│   └── 🗄️ php_tutor.sql
│
├── 📁 public/
│   ├── ⚙️ .htaccess
│   ├── 📄 404.php
│   ├── 📄 acceso_denegado.php
│   ├── 📄 dashboard.php
│   ├── 📄 index.php
│   ├── 📄 logout.php
│   ├── 📄 register.php
│   ├── 📄 router.php
│   ├── 📄 test.php
│
│   ├── 📁 admin/
│   │   ├── 📄 analistas.php
│   │   ├── 📄 crear_analista.php
│   │   ├── 📄 eliminar_analista.php
│   │   ├── 📄 solicitudes.php
│   │   └── 📄 ver_detalles.php
│
│   ├── 📁 analista/
│   │   └── 📄 historial_usuarios.php
│
│   └── 📁 usuario/
│       ├── 📄 consultas.php
│       ├── 📄 historial.php
│       └── 📄 procesar_consulta.php
│
└── 📘 README.md
```

## 🔐 Seguridad

El proyecto utiliza sesiones para la autenticación de los usuarios. Asegúrate de configurar correctamente las opciones de sesión en tu servidor.

La clave de la API de Cohere se debe almacenar de manera segura en `config/cohere.php` y **no debe compartirse públicamente**.

**Nota:** En este caso, el repositorio incluye la clave de la API con fines educativos. En un entorno de producción, asegúrate de seguir las mejores prácticas para almacenar las claves de API de forma segura y no exponerlas en el código.
