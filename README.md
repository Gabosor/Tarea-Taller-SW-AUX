#install


# Instalaciones
    Instalar dependencias del proyecto
    composer install
    Renombrar el archivo .env.example a .env (Corregir variables de entorno si es necesario).

# Crear contenedor de Docker con la base de datos

    docker compose up -d
# Correr migraciones
    php artisan migrate
 # Ejecutar el proyecto
    php artisan serve

