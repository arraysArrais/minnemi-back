<p align="center">
  <a href="https://github.com/Minnemi/minnemi-back" target="_blank">
    <img src="https://img.shields.io/badge/PhP-blue" alt="PhP version" />
  </a>
  <a href="https://github.com/Minnemi/minnemi-back" target="_blank">
    <img src="https://img.shields.io/github/license/Minnemi/minnemi-back" alt="License" />
  </a>
</p>

# Sobre o repositório
Esta API desenvolvida em PHP permite autenticar usuários, registrar cartas e controlar as permissões dos mesmos. Essa API é projetada para a aplicação [frontend](https://github.com/Minnemi/minnemi-front) que necessita de um sistema de autenticação seguro e deseja oferecer aos usuários a funcionalidade de criar e armazenar cartas para serem enviadas em momentos posteriores.

## **Clonando e executando aplicação**

### ⚠ Regras:
* Toda pull-request deve conter uma issue!

### 📝 Requisitos:
<!-- Listar requisitos com link para tutoriais -->
* [Docker - veja como instalar](https://www.docker.com/)
* Conhecimento em PhP
* Conhecimento em MySQL

### **Siga essas etapas**
<!-- Alterar link para o repositório relativo -->
1. Faça o `fork` do repositório [minnemi-back](https://github.com/Minnemi/minnemi-back.git)
2. Agora você pode clonar o projeto no seu ambiente de desenvolvimento com o comando:
```Bash
# Substitua [username] pelo seu nome de usuário no GitHub
$ git clone https://github.com/[username]/minnemi-back.git
```
3. Acesse a pasta gerada:
```Bash
$ cd ./minnemi-back
```
4. Crie um arquivo `.env` com base no `.env.example` disponível na raiz do projeto. Você pode usar o seguinte comando para criar uma cópia:
```Bash
$ cp .env.example .env
```
5. Agora verifique se o Docker já está rodando na sua máquina
6. Vamos iniciar o Docker da aplicação, isso realizará todas as instalações necessárias:
```Bash
$ docker build -t minnemi .
$ docker run minnemi
```
7. Verifique no navegador se a aplicação está rodando na porta local `80`, use o link:
```Bash
$ http://localhost:80/
```

### **🎊 Congratulations!**
**Agora é só encontrar ou abrir novas [ISSUES](https://github.com/Minnemi/minnemi-back/issues) para resolver.**

---
Conheça nosso FLOW completo [🌻 FLOW Minnemi](https://github.com/Minnemi/.github#readme);
