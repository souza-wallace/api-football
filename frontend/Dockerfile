# Usa a imagem oficial do Node.js baseada em Alpine (leve e eficiente)
FROM node:alpine

# Define o diretório de trabalho dentro do container
WORKDIR /usr/src/app

# Copia os arquivos package.json e package-lock.json para instalar dependências
COPY package*.json ./

# Instala as dependências do projeto
RUN npm install

# Copia o restante dos arquivos do projeto para o container
COPY . .

# Expõe a porta padrão usada pelo Vite (Vue 3) ou Webpack (Vue 2)
EXPOSE 5173

# Comando para iniciar o servidor de desenvolvimento do Vue.js
CMD ["npm", "run", "dev", "--", "--host"]
