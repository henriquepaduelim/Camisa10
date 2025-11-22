# Gallo Classics – E-commerce de camisas (Laravel 12, pt-BR)

## Requisitos
- PHP 8.2+, Composer.
- Node 18+, npm.
- MySQL 8+ ou PostgreSQL 14+ (ou SQLite para testes rápidos).

## Setup rápido
```bash
cp .env.example .env
# Ajuste DB_* (SQLite por padrão; configure PG/MySQL se preferir).
composer install
php artisan key:generate
php artisan migrate --seed
npm install
npm run dev   # ou npm run build para produção
php artisan serve
```

Credenciais demo (seed):
- Admin: `admin@galloclassics.test` / `Admin123!`
- Cliente: `cliente@galloclassics.test` / `Cliente123`
- Cupom: `BEMVINDO10`

## Principais rotas
- Web: `/` (home), `/produtos`, `/produtos/{slug}`, `/carrinho`, `/checkout`.
- API pública: `GET /api/produtos`, `GET /api/produtos/{slug}`, `POST /api/registrar`, `POST /api/login`, `GET /api/clubes|ligas|categorias`.
- Carrinho/checkout: `GET/POST /api/carrinho`, `PATCH/DELETE /api/carrinho/{item}`, `POST /api/carrinho/cupom`, `POST /api/checkout`.
- Conta: `GET /api/me`, `PUT /api/me`, `GET /api/pedidos`, `GET /api/pedidos/{id}` (todas com `auth:sanctum`).
- Admin (`auth:sanctum` + `admin`): `api/admin/produtos|categorias|clubes|ligas|cupons` (CRUD), `api/admin/pedidos`, `api/admin/pedidos/{id}/status`, `api/admin/settings`.

## Estrutura resumida
- `app/Models`: entidades (produtos, clubes, ligas, categorias, carrinho, pedidos, cupom, settings).
- `app/Services`: `ProductService`, `CartService`, `CheckoutService`, `PaymentService`.
- `app/Http/Controllers/Api`: auth, produtos, carrinho, checkout, pedidos; admin CRUD.
- `database/migrations`: tabelas completas (produtos, imagens, tamanhos, cupons, carrinho, pedidos, settings).
- `database/seeders/DemoSeeder.php`: dados demo, pedido teste.
- `resources/views`: layout Blade mobile-first, componentes (navbar, footer, card), páginas home/catálogo/produto/carrinho/checkout.

## Customização rápida
- Tema: edite variáveis em `resources/css/app.css` (`--cor-primaria`, fontes).
- Breakpoints/tipografia: ajustar em Tailwind (vite + tailwindcss v4).
- Textos: todos em pt-BR, alterar nas views.
- Pagamento: `config/payment.php` (`PAYMENT_PROVIDER=mock` ou Pagar.me).

## Testes
- Rode `php artisan test`. Já há testes para checkout (cupom+tamanho), admin pedidos/status, filtros de catálogo e auth/conta.

## Fluxo admin
- Login: `/admin/login` (admin seed).
- CRUD produtos, taxonomias, cupons, pedidos e settings via painel `/admin`.

## Pagamento
- Mock padrão: `PAYMENT_PROVIDER=mock`.
- Pagar.me: defina `PAYMENT_PROVIDER=pagarme` e `PAGARME_API_KEY` no `.env` + `php artisan config:clear`.

## Deploy checklist
- `.env` com APP_KEY, APP_URL, DB_* e PAYMENT_PROVIDER configurados.
- Banco migrado/seed: `php artisan migrate --seed`.
- Link de storage para uploads: `php artisan storage:link`.
- Build frontend: `npm run build`.
- Permissões: `storage/` e `bootstrap/cache` graváveis.
- Opcional: `php artisan config:cache` e `php artisan route:cache` após revisar `.env`.
