# BookHair API 💈🛠️

O **BookHair API** é o backend do aplicativo BookHair, responsável por fornecer uma API RESTful para gerenciamento de barbearias, serviços, profissionais e agendamentos. Ele integra-se ao aplicativo Flutter, permitindo uma experiência completa de agendamento e gestão para clientes e barbearias.

---

## 📦 Tecnologias Utilizadas

- Node.js com Express.js – Estrutura principal do servidor
- MongoDB com Mongoose – Banco de dados NoSQL para persistência de dados
- JWT (JSON Web Tokens) – Autenticação e autorização seguras
- Docker – Containerização para facilitar o desenvolvimento e a implantação
- Swagger – Documentação interativa da API
- Nodemailer – Envio de e-mails (confirmações de agendamento, notificações, etc.)

---

## 📁 Estrutura do Projeto

```
bookhair-api/
├── src/
│   ├── controllers/        # Lógica dos endpoints da API
│   ├── models/             # Modelos Mongoose (Barbearia, Serviço, Usuário, Agendamento)
│   ├── routes/             # Definição das rotas da API
│   ├── middlewares/        # Autenticação, validação, tratamento de erros
│   ├── services/           # Lógica de negócios e integrações externas
│   ├── config/             # Configurações de ambiente, banco de dados, etc.
│   └── app.js              # Configuração principal do Express
├── .env.example            # Variáveis de ambiente (exemplo)
├── Dockerfile              # Dockerfile para containerização
├── docker-compose.yml      # Configuração do Docker Compose
├── README.md               # Documentação do projeto
└── package.json            # Dependências e scripts
```

---

## 🚀 Como Executar Localmente

**Pré-requisitos**

- Docker e Docker Compose instalados


**Passos**

Clone o repositório: git clone https://github.com/lucasfeva/bookhair-api.git

Instale as dependências: npm install

Configure as variáveis de ambiente: copie .env.example para .env e atualize os valores conforme necessário

Inicie a aplicação:
- Com Docker Compose: docker-compose up


---

## 📌 Endpoints Principais

- `POST /auth/register` – Registro de novos usuários
- `POST /auth/login` – Autenticação de usuários
- `GET /barbershops` – Listagem de barbearias
- `GET /barbershops/:id` – Detalhes de uma barbearia específica
- `POST /appointments` – Criação de novos agendamentos
- `GET /appointments/user/:userId` – Agendamentos de um usuário
- `GET /appointments/barbershop/:barbershopId` – Agendamentos de uma barbearia

---
