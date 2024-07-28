## Tecnologias Usadas
- **PHP:** 8.2
- **Laravel:** 11
- **Node.js:** 20.9.0
- **npm:** 10.1.0
- **Composer**
- **Banco de Dados:** MySQL
## Configuração do Projeto
### 1. Clone o Repositório
Primeiro, clone o repositório para sua máquina local:

``git clone https://github.com/lwlima/people-management.git``
``cd people-management``

### 2. Instale as Dependências
Instale as dependências do PHP usando Composer:
``composer install``

Instale as dependências do front-end usando npm:
``npm install``

### 3. Configure o Arquivo .env
Copie o arquivo .env.example para um novo arquivo .env e configure as variáveis de ambiente:
``cp .env.example .env``

Edite o arquivo .env com as seguintes configurações:

#### Banco de Dados:
DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=nome_do_banco

DB_USERNAME=seu_usuario

DB_PASSWORD=sua_senha

### 4. Execute as Migrations e Seeders
Para preparar o banco de dados, execute as migrations e seeders:

``php artisan migrate``

``php artisan db:seed``

O seeder cria:

- Um usuário admin com e-mail admin@admin.com e senha password.
- Registra 10 pessoas.
- Cria dois endereços (residencial e comercial) para cada pessoa criada anteriormente.

### 5. Execute o Servidor Backend
Para rodar o backend da aplicação, execute:

``php artisan serve``
### 6. Execute o Frontend
Para rodar o front-end da aplicação, execute:

``npm run dev``

## Funcionalidades

- Registro de pessoas
- Registro de endereços
- Edição de registros
- Listagem de pessoas
