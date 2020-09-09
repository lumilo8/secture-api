# Instalación

## Docker

Entrar en la carpeta docker/local
```
cd docker/local
```
Copiar `dist.env` a `.env` y modificar los valores necesarios.
```
cp dist.env .env
```
Levantar los contenedores
```
docker-compose up -d
```

Agregar entrada al /etc/hosts
```
127.0.0.1 secture.loc
```

Instalar vendors
```
docker exec -it secture-php composer install
```

Crear base de datos
```
docker exec -it secture-php bin/console doctrine:database:create
```

Crear schema de datos
```
docker exec -it secture-php bin/console doctrine:schema:create
```