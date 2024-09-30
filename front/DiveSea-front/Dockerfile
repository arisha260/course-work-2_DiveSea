FROM node:alpine as build

LABEL authors="PC"

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .

CMD ["npm", "run", "dev"]
