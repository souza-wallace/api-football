Projeto Full Stack com Vue.js e Flight PHP

Este projeto é dividido em duas partes: Frontend e Backend, utilizando Vue.js e Flight PHP, respectivamente. O ambiente de desenvolvimento é gerenciado com Docker.

📌 Tecnologias Utilizadas

Flight PHP: Framework minimalista para o backend.

Vue.js: Framework JavaScript progressivo para a interface do usuário.

Docker: Ferramenta para conteinerização de aplicações.

Vite: Ferramenta de build para o frontend Vue.js.

🚀 Como Rodar o Projeto

1️⃣ Clonar o Repositório

git clone <URL_DO_REPOSITORIO>
cd project

2️⃣ Rodar o Backend

cd backend
docker compose up -d --build

3️⃣ Rodar o Frontend

cd ..
cd frontend
docker compose up -d --build

📦 Configuração do Frontend

O frontend utiliza Vue.js com Vite.

Instalar Dependências

npm install

Rodar em Modo de Desenvolvimento

npm run dev

Compilar para Produção

npm run build

📦 Configuração do Backend

O backend utiliza Flight PHP e roda dentro de um container Docker.

Subir o Container Docker

docker compose up -d --build

Caso precise parar o container:

docker compose down

🛠 Recomendações de IDE

Para melhor experiência de desenvolvimento, recomendamos:

VSCode: Baixar aqui

Extensão Volar: Instalar aqui (Desativar Vetur)

📜 Referências

Documentação Vue.js

Documentação Flight PHP

Configuração do Vite

Docker Documentation