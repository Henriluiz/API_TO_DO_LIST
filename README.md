---

# 🚀 Laravel API - Setup Inicial

## 📋 Pré-requisitos

* PHP >= 8.x
* Composer
* Banco de dados (MySQL, PostgreSQL, etc.)

---

## ⚙️ Instalação

```bash
# Clonar o projeto
git clone URL_DO_REPOSITORIO
cd nome-do-projeto

# Instalar dependências
composer install
```

---

## 📄 Configurar ambiente

```bash
# Criar arquivo .env
cp .env.example .env
```

### ✏️ Editar o `.env`

Altere as principais variáveis:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=root
DB_PASSWORD=senha
```

---

## 🔑 Gerar chave da aplicação

```bash
php artisan key:generate
```

---

## 🗄️ Rodar migrations

```bash
php artisan migrate
```

---

## ▶️ Iniciar servidor

```bash
php artisan serve
```

A API estará disponível em:
👉 [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 📦 (Opcional) Criar estrutura básica de API

```bash
# Criar controller
php artisan make:controller NomeController

# Criar model + migration
php artisan make:model Nome -m
```

---

## 🔁 (Opcional) Seeders

```bash
php artisan db:seed
```

---

## 🧪 Rotas da API

Edite:

```
routes/api.php
```

---

Pronto! Sua API Laravel está rodando 🎉
