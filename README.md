<h1 align="center">📊 EmpresaManager</h1>

<p align="center">
💼 Sistema de gestão empresarial com Laravel, Livewire e Tailwind CSS. Administra grupos econômicos, bandeiras, unidades e colaboradores de forma prática e moderna.
</p>

<p align="center">
<img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
<img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" />
<img src="https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
<img src="https://img.shields.io/badge/Livewire-3.x-4E56A6?style=for-the-badge&logo=laravel&logoColor=white" />
<img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" />
<img src="https://img.shields.io/badge/Maatwebsite-Excel-217346?style=for-the-badge&logo=microsoft-excel&logoColor=white" />
</p>

---

## 📦 Instalação (Windows / Linux)

### 🧰 Requisitos

* PHP 8.2+
* Composer 2.x
* MySQL 8.x
* Node.js 18+ / NPM 9+
* Laravel 11
* Git

---

### ⚙️ Passo a passo

```bash
# Clonar o repositório
git clone https://github.com/seu-usuario/gestao-grupos.git
cd gestao-grupos

# Instalar dependências
composer install
npm install

# Criar e configurar .env
cp .env.example .env
php artisan key:generate

# Configurar banco
# (edite DB_DATABASE, DB_USERNAME, DB_PASSWORD no .env)

# Migrar e popular banco
php artisan migrate --seed

# Criar link de storage
php artisan storage:link

# Compilar assets
npm run dev

# Rodar servidor Laravel
php artisan serve
```

💡 Em outro terminal:

```bash
php artisan queue:work
```

---

## ☕ Uso do Sistema

1. Acesse [http://127.0.0.1:8000](http://127.0.0.1:8000)
2. Clique em **Registrar** e crie seu usuário
3. Faça login
4. Use o painel para:

   * Criar **Grupos Econômicos**
   * Adicionar **Bandeiras**
   * Cadastrar **Unidades** com CNPJ válido
   * Adicionar **Colaboradores**
   * Gerar **Relatórios Excel**
   * Visualizar **Auditoria**

---

## 🪄 Funcionalidades Principais

| 🔧 Recurso         | Descrição                                 |
| ------------------ | ----------------------------------------- |
| 🏢 Grupo Econômico | CRUD completo com auditoria               |
| 🏷️ Bandeira       | Vinculada ao grupo econômico              |
| 🏬 Unidade         | Validação de CNPJ, associada à bandeira   |
| 👥 Colaborador     | Vinculado à unidade                       |
| 📊 Relatórios      | Filtros dinâmicos + exportação Excel      |
| 🔐 Autenticação    | Laravel Breeze (Login e Registro)         |
| 🧾 Auditoria       | Registro de alterações com usuário e data |
| ⚙️ Filas           | Exportações processadas em background     |

---

## 🧪 Testes

Rodar todos os testes:

```bash
php artisan test
```

Testar manualmente os CRUDs via navegador ou Postman.

---

## 🧰 Tecnologias

| Tecnologia        | Uso                     |
| ----------------- | ----------------------- |
| Laravel 11.x      | Backend principal       |
| Livewire 3.x      | Componentes dinâmicos   |
| Tailwind CSS      | Front-end moderno       |
| Breeze            | Autenticação simples    |
| Maatwebsite/Excel | Exportação Excel        |
| Queue / Jobs      | Processos em background |
| PHPUnit           | Testes automatizados    |

---

## 🧱 Desenvolvimento

### Rodar ambiente completo:

```bash
php artisan serve
npm run dev
php artisan queue:work
```

### Testar dados diretamente:

```bash
php artisan tinker
```

---

## 📫 Contribuindo

```bash
git checkout -b minha-feature
git commit -m "Nova funcionalidade"
git push origin minha-feature
```

---

## 🤝 Colaboradores

| Nome              | Função                  |
| ----------------- | ----------------------- |
| **Igor Gabriel**  | 💻 Full Stack Developer |
| **Space Studios** | 🎮 Games & Apps         |

---

## 📝 Licença

MIT – veja [LICENSE](LICENSE)

---

## 🖼️ Prints

<p align="center">
<img src="./img/dashboard.png" width="800" alt="Dashboard GIF" /><br/>
<sub>Dashboard interativo</sub>
</p>

<p align="center">
<img src="./img/colaboradores.png" width="800" alt="Cadastro Colaboradores GIF" /><br/>
<sub>Cadastro de colaboradores</sub>
</p>

---