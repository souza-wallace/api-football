# Projeto Full Stack com Vue.js e Flight PHP

Este projeto é dividido em duas partes: Frontend e Backend, utilizando Vue.js e Flight PHP, respectivamente. O ambiente de desenvolvimento é gerenciado com Docker.

# 📌 Tecnologias Utilizadas

Flight PHP: Framework minimalista para o backend.

Vue.js: Framework JavaScript progressivo para a interface do usuário.

Docker: Ferramenta para conteinerização de aplicações.

# 🚀 Baixe o projeto
```
git clone https://github.com/souza-wallace/api-football.git
````
```
cd api-football
```

# 🚀 Executando o projeto com Docker

É nescessário ter o docker desktop instalado e estar com ele aberto para que os comandos abaixo funcionem corretamente, caso nao tenha acesse em [Docker Documentation](https://www.docker.com/products/docker-desktop/)


2️⃣ Rodar o Backend

```
cd backend
````
```
docker compose up -d --build
```

3️⃣ Rodar o Frontend

```
cd ..
cd frontend
```
```
docker compose up -d --build
```


# 🚀 Executando o projeto local 

Caso não consiga executar utilizando docker, pode executar localmente

# Depêndencias

* [PHP > 7.4](https://www.php.net/downloads.php)
* [composer](https://getcomposer.org/download/)
* [node > 18](https://nodejs.org/en/download)


2️⃣ Rodar o Backend

```
cd backend
````
```
composer install
```

```
php -S localhost:8000
```
Acesse:
```
http://localhost:8000/
```
3️⃣ Rodar o Frontend

```
cd ..
cd frontend
```
```
npm install
```

```
npm run dev
```
Acesse:
```
http://localhost:5173/
```
# 📜 Referências

[Documentação Vue.js](https://vuejs.org/)

[Documentação Flight PHP](https://docs.flightphp.com/)

[Docker Documentation](https://www.docker.com/)