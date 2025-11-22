# Codex – Base para e-commerce de camisas de futebol (pt-BR)

## Visão geral
- Plataforma full-stack focada em camisas de futebol, mobile-first, toda a UI em pt-BR.
- Backend em PHP 8.2+ com Laravel 10.x (MVC, serviços, repositórios). Banco: MySQL ou PostgreSQL.
- Frontend em Blade + Tailwind CSS (config customizável), JS leve com Alpine.js; ícones Font Awesome.
- API REST completa para produtos, categorias, clubes, ligas, usuários, carrinho, pedidos, pagamentos (mock), área admin.

## Estrutura sugerida de pastas
```
backend/
  app/
    Http/Controllers/Api/...
    Http/Controllers/Web/...
    Http/Requests/...
    Models/
    Services/
    Repositories/
  database/
    migrations/
    seeders/
  routes/
    api.php
    web.php
  config/
  tests/
frontend/  (opcional para assets separados; se preferir, use somente resources/)
```

## Setup rápido
1) `cp .env.example .env` e ajuste credenciais (veja abaixo).  
2) `composer install`  
3) `php artisan key:generate`  
4) `php artisan migrate --seed` (cria tabelas e dados de exemplo, incluindo admin e pedido teste).  
5) `php artisan serve` (backend + Blade).  
6) `npm install && npm run dev` (build Tailwind/JS).

## .env base (local)
```
APP_NAME="Loja Fut"
APP_ENV=local
APP_KEY=base64:GENERATE_AQUI
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lojafut
DB_USERNAME=lojafut
DB_PASSWORD=senha123

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_MAILER=log

PAYMENT_PROVIDER=mock
PAGARME_KEY=trocar_quando_real
```

## Migrações principais (tabelas)
- `users` (roles: customer/admin), `password_resets`
- `clubs`, `leagues`, `categories`
- `products` (camisas), `product_images`, `product_sizes` (tamanhos e estoque)
- `coupons`
- `carts`, `cart_items`
- `orders`, `order_items`, `order_status_history`
- `addresses` (endereços do usuário)
- `settings` (nome loja, logo, cor primária, email contato)
- Índices: slug de produto, chave estrangeira de categoria/club/league, status de pedido, email único, coupon code único.

## Seeders (dados mínimos)
- Usuário admin: email `admin@lojafut.test`, senha `Admin123!` (trocar depois).
- Clientes demo, clubes (ex: Flamengo, Corinthians, Barcelona), ligas (Brasileirão, Champions), categorias (Masculina, Infantil).
- Produtos exemplo com imagens placeholder, tamanhos P/M/G/EG e estoque variado.
- Pedido teste com itens, endereço de envio e status `pago`.
- Cupom demo `BEMVINDO10` (10%).

## Camadas e padrões
- Controllers finos chamando Services/UseCases; validação em FormRequests.
- Repositories encapsulam Eloquent; Models usam casts, fillable e scopes.
- DTOs simples para respostas API quando necessário.
- Respostas JSON padronizadas: `{ data, meta?, errors? }` com mensagens em pt-BR.
- Autenticação: Laravel Breeze/Jetstream ou Sanctum para SPA/API; guard separado `admin`.
- Políticas/Policies para operações admin.
- Middlewares: `auth`, `auth:sanctum`, `role:admin`, `locale` fixo pt-BR, `throttle`.
- CSRF ligado nas rotas web; API com tokens.

## Rotas essenciais
- `GET /api/produtos` (filtros: clube, liga, categoria, tamanho, preço, disponibilidade, ordenação)
- `GET /api/produtos/{slug}`
- `POST /api/carrinho` (adicionar), `PATCH /api/carrinho/{item}`, `DELETE /api/carrinho/{item}`, `GET /api/carrinho`
- `POST /api/checkout` (dados cliente + envio + pagamento mock)
- `POST /api/login`, `POST /api/registrar`, `GET /api/me`, `PUT /api/me`
- `GET /api/pedidos`, `GET /api/pedidos/{id}`
- Admin: `api/admin/produtos`, `api/admin/categorias`, `api/admin/clubes`, `api/admin/ligas`, `api/admin/pedidos`, `api/admin/cupons`, `api/admin/settings`

## Frontend (Blade + Tailwind + Alpine)
- Mobile-first: grid de produtos 1 coluna (xs), 2 colunas (sm+); tipografia 16px base.
- Componentes Blade: `layouts/app.blade.php`, `components/navbar.blade.php`, `components/footer.blade.php`, `components/product-card.blade.php`, `components/badge.blade.php`, `components/form-field.blade.php`.
- Páginas: home (hero + destaques + novidades), lista de produtos com filtros, detalhes do produto (galeria touch), carrinho, checkout em passos, conta (login, perfil, pedidos), admin (dashboard responsivo).
- CSS: usar variáveis em `resources/css/theme.css` (`--cor-primaria`, `--cor-secundaria`, `--cor-fundo`, `--fonte-base`, `--raio-borda`). Ajustar breakpoints via `tailwind.config.js`.
- Ícones: `<i class="fa-solid fa-cart-shopping"></i>` etc. (Font Awesome).

## UX e textos (pt-BR)
- Botões: “Adicionar ao carrinho”, “Finalizar compra”, “Continuar comprando”.
- Feedbacks: toast/alert em pt-BR para sucesso/erro de validação.
- Placeholders e labels sempre em português (“E-mail”, “Senha”, “CEP”, “Telefone”).
- Mensagens de erro API padronizadas: “Campo obrigatório”, “Produto indisponível”, “Cupom inválido ou expirado”.

## Testes
- Feature: listagem de produtos (filtros), detalhes, fluxo de carrinho/checkout, registro/login, criação de pedido.
- Unit: services de carrinho, cálculo de totais/descontos, aplicação de cupom.
- Usar `php artisan test`; factories para produtos, clubes, ligas e pedidos.

## Extensão e ajustes
- Tema: editar `resources/css/theme.css` e `tailwind.config.js`.
- Breakpoints: ajustar `screens` em `tailwind.config.js`.
- Pagamento: service `PaymentService` com driver mock; adicionar gateway real implementando interface.
- Novos atributos de produto: adicionar colunas via migração, incluir nos Models, Requests e DTOs.
- Cache: ativar `cache` em repositórios (ex: produtos destacados) via config flag.

## Segurança e qualidade
- Sanitizar inputs, validação em todas as rotas de escrita.
- CSRF habilitado nas rotas web; headers corretos na API.
- Rate limiting em login e rotas sensíveis.
- Logs em `storage/logs` + contexto de usuário/rota.
- Cabeçalhos HTTP básicos via middleware (`X-Frame-Options`, `X-Content-Type-Options`).

## Próximos passos de implementação
- Scaffold Laravel, criar migrações/seeders listados, configurar guards e políticas.
- Construir componentes Blade e páginas mobile-first.
- Implementar serviços e testes principais antes de refinar UI.
- Documentar credenciais demo e fluxos no README.
