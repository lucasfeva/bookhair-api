markdown
# 📘 BookHair API

O **BookHair API** é o backend do aplicativo *BookHair*, fornecendo uma API RESTful para gerenciamento de barbearias, serviços, profissionais e agendamentos. Ele permite que clientes e barbearias realizem todo o fluxo de agendamento de horários por meio de uma aplicação Flutter integrada. ✂️💈

---

## 🛠️ Tecnologias Utilizadas

* 🐘 **PHP 8.2**  
* 🌐 **Laravel 12.x**  
* 🗄️ **MariaDB/MySQL**  
* 🔒 **Laravel Sanctum**  
* 🐳 **Docker & Docker Compose**  

---

## 🏗️ Estrutura do Projeto

```

bookhair-api/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Barbearia.php
│   │   ├── Servico.php
│   │   ├── Profissional.php
│   │   ├── Agendamento.php
│   │   └── ProfissionalServico.php
│   └── Http/
│       ├── Controllers/
│       │   └── API/
│       │       ├── AuthController.php
│       │       ├── UserController.php
│       │       ├── BarbeariaController.php
│       │       ├── ServicoController.php
│       │       ├── ProfissionalController.php
│       │       ├── AgendamentoController.php
│       │       └── DashboardController.php
│       └── Requests/
│           ├── RegisterRequest.php
│           ├── LoginRequest.php
│           ├── BarbeariaRequest.php
│           └── (outros Form Requests)
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── routes/
│   └── api.php
├── docker-compose.yml
├── .env.example
└── README.md

````

### 📁 Principais Pastas

* **app/Models**: Modelos Eloquent das entidades (User, Barbearia, Servico, Profissional, Agendamento, Pivot).  
* **app/Http/Controllers/API**: Controladores da API organizados por recurso.  
* **app/Http/Requests**: Validações automáticas de requisição (Form Requests).  
* **database/migrations**: Migrações para criação das tabelas.  
* **database/seeders**: Classes para popular o banco com dados iniciais.  
* **database/factories**: Factories para geração de dados fake.  
* **routes/api.php**: Definição das rotas (prefixo `/api/v1`).  
* **docker-compose.yml**: Configuração do ambiente Docker.  

---

## 🚀 Instalação e Execução

### 1. Clone o Repositório

```bash
git clone https://github.com/lucasfeva/bookhair-api.git
cd bookhair-api
````

### 2. Copie `.env`

```bash
cp .env.example .env
```

### 3. Usando Docker Compose

```bash
docker-compose up -d
docker-compose run --rm laravel composer update
docker-compose run --rm laravel php artisan key:generate
docker-compose run --rm laravel php artisan migrate --seed
```

🔗 **App**: [http://localhost:8000](http://localhost:8000)
🔗 **phpMyAdmin**: [http://localhost:8080](http://localhost:8080) (usuário: `root` / senha: `secret`)

---

## ⚙️ Configuração do `.env`

```dotenv
APP_NAME=BookHair
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mariadb
DB_PORT=3306
DB_DATABASE=bookhair
DB_USERNAME=root
DB_PASSWORD=secret
```

---

## 🔑 Autenticação

* **Sanctum** protege as rotas com token Bearer.
* Cabeçalho HTTP:

  ```
  Authorization: Bearer <token>
  ```

### 🔐 Endpoints de Auth

| Método | Rota                    | Descrição                    |
| ------ | ----------------------- | ---------------------------- |
| `POST` | `/api/v1/auth/register` | Registrar novo usuário       |
| `POST` | `/api/v1/auth/login`    | Fazer login                  |
| `POST` | `/api/v1/auth/logout`   | Logout (requer token)        |
| `POST` | `/api/v1/auth/refresh`  | Renovar token (requer token) |

---

## 📑 Principais Endpoints

### 👤 Usuário

| Método | Rota           | Descrição        |
| ------ | -------------- | ---------------- |
| `GET`  | `/api/v1/user` | Obter perfil     |
| `PUT`  | `/api/v1/user` | Atualizar perfil |

### 💈 Barbearias

| Método   | Rota                                             | Descrição                      |
| -------- | ------------------------------------------------ | ------------------------------ |
| `GET`    | `/api/v1/barbearias`                             | Listar barbearias              |
| `GET`    | `/api/v1/barbearias/search?q=termo`              | Buscar por nome                |
| `GET`    | `/api/v1/barbearias/nearby?lat=&lng=&radius=`    | Próximas ao local              |
| `GET`    | `/api/v1/barbearias/{id}`                        | Detalhar barbearia             |
| `GET`    | `/api/v1/barbearias/{id}/servicos`               | Serviços de uma barbearia      |
| `GET`    | `/api/v1/barbearias/{id}/profissionais`          | Profissionais de uma barbearia |
| `GET`    | `/api/v1/barbearias/{id}/agenda?date=YYYY-MM-DD` | Agenda em data                 |
| `POST`   | `/api/v1/barbearias`                             | Criar barbearia                |
| `PUT`    | `/api/v1/barbearias/{id}`                        | Atualizar barbearia            |
| `DELETE` | `/api/v1/barbearias/{id}`                        | Excluir barbearia              |

### 💇‍♂️ Serviços

| Método   | Rota                    | Descrição         |
| -------- | ----------------------- | ----------------- |
| `GET`    | `/api/v1/servicos`      | Listar serviços   |
| `GET`    | `/api/v1/servicos/{id}` | Detalhar serviço  |
| `POST`   | `/api/v1/servicos`      | Criar serviço     |
| `PUT`    | `/api/v1/servicos/{id}` | Atualizar serviço |
| `DELETE` | `/api/v1/servicos/{id}` | Excluir serviço   |

### 👨‍🔧 Profissionais

| Método   | Rota                                              | Descrição                        |
| -------- | ------------------------------------------------- | -------------------------------- |
| `GET`    | `/api/v1/profissionais`                           | Listar profissionais             |
| `GET`    | `/api/v1/profissionais/{id}`                      | Detalhar profissional            |
| `GET`    | `/api/v1/profissionais/{id}/horarios`             | Horários (agenda)                |
| `GET`    | `/api/v1/profissionais/{id}/servicos`             | Serviços que realiza             |
| `POST`   | `/api/v1/profissionais`                           | Criar profissional               |
| `PUT`    | `/api/v1/profissionais/{id}`                      | Atualizar profissional           |
| `DELETE` | `/api/v1/profissionais/{id}`                      | Excluir profissional             |
| `POST`   | `/api/v1/profissionais/{id}/servicos/{servicoId}` | Vincular serviço ao profissional |
| `DELETE` | `/api/v1/profissionais/{id}/servicos/{servicoId}` | Desvincular serviço              |

### 📅 Agendamentos

| Método | Rota                                    | Descrição               |
| ------ | --------------------------------------- | ----------------------- |
| `GET`  | `/api/v1/agendamentos`                  | Listar agendamentos     |
| `GET`  | `/api/v1/agendamentos/{id}`             | Detalhar agendamento    |
| `GET`  | `/api/v1/agendamentos/history/{userId}` | Histórico de um usuário |
| `POST` | `/api/v1/agendamentos`                  | Criar agendamento       |
| `PUT`  | `/api/v1/agendamentos/{id}`             | Atualizar agendamento   |
| `POST` | `/api/v1/agendamentos/{id}/cancel`      | Cancelar agendamento    |

### 📊 Dashboard

| Método | Rota                      | Descrição            |
| ------ | ------------------------- | -------------------- |
| `GET`  | `/api/v1/dashboard/stats` | Estatísticas mensais |

---

## 🗄️ Migrations e Seeds

* **Migrar**:

  ```bash
  php artisan migrate
  ```
* **Popular**:

  ```bash
  php artisan db:seed
  ```
* **Migrar e Popular**:

  ```bash
  php artisan migrate --seed
  ```

---
