# 💼 Carteira Financeira - Desafio Técnico

## 📚 Descrição

Sistema de carteira digital com funcionalidades de depósito, transferência entre usuários e reversão de transações. A aplicação permite que usuários realizem movimentações financeiras de forma segura, validando saldo e mantendo o histórico de todas as operações.

---

## 🚀 Tecnologias Utilizadas

- PHP 8.2
- Laravel 10.x
- MySQL
- Docker
- Blade (View engine nativa do Laravel)

---

## ⚙️ Como Rodar o Projeto

1. Clone o repositório:
   ```bash
   git clone https://github.com/pazygor/carteira-financeira.git
   cd carteira-financeira
Suba o ambiente com Docker:

bash
Copiar
Editar
docker-compose up -d --build
Acesse o container do app:

bash
Copiar
Editar
docker exec -it nome-do-container-app bash
Execute as migrations e seed (caso tenha):

bash
Copiar
Editar
php artisan migrate --seed
🔐 Acesso à Aplicação
URL: http://localhost:8000
rodar npm install e npm run dev para rodar o front.
Usuário do banco: user

Senha do banco: secret

🧪 Funcionalidades
✅ Registro e autenticação de usuários

✅ Depósito de valores

✅ Transferência entre usuários

✅ Verificação de saldo em tempo real

✅ Reversão de transações com ajuste automático de saldo

✅ Histórico completo de transações

✅ Interface simples e funcional

✅ Validações e Regras de Negócio
❌ Transferência não permitida sem saldo suficiente

✔️ Depósito cobre saldo negativo, se houver

🔁 Transações podem ser revertidas com segurança

🔒 Cada usuário só pode operar sobre sua própria carteira

⚠️ Proteção contra reversões duplicadas

🛠️ Arquitetura e Boas Práticas
MVC (Model-View-Controller)

Utilização do Eloquent ORM para comunicação com o banco de dados

Transações no banco para garantir atomicidade

Código limpo com nomes de métodos e variáveis descritivos

Separação de responsabilidades entre controllers e models

Reutilização de views e componentes Blade

Organização por namespaces (ex: Http\Controllers, Models)

🐳 Docker
Projeto dockerizado com os seguintes serviços:

app (Laravel)

mysql (Banco de dados)

phpmyadmin (opcional)

Com o ambiente docker, não há necessidade de instalar PHP ou MySQL localmente. Basta rodar:

bash
Copiar
Editar
docker-compose up -d
✨ Diferenciais
💻 Ambiente 100% dockerizado

🔁 Funcionalidade de reversão de transações

✅ Seeds para testes rápidos (opcional)

🔐 Segurança com CSRF, autenticação e autorização

🔄 Uso de transações no DB para evitar inconsistências

💬 Considerações Finais
Durante a execução do projeto, optei por utilizar o Laravel devido à sua produtividade, segurança nativa e excelente estrutura para desenvolvimento rápido e organizado. As principais decisões de arquitetura e regras de negócio foram pensadas para refletir um cenário realista de carteira digital.

Sinta-se à vontade para revisar o código, executar testes e simular transferências ou reversões.

📞 Contato
Ygor Paz
LinkedIn: https://www.linkedin.com/in/ygor-paz-4406411a4/
pazygor080@gmail.com