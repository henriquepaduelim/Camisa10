<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Club;
use App\Models\Coupon;
use App\Models\League;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $cliente = User::updateOrCreate(
            ['email' => 'cliente@galloclassics.test'],
            [
                'name' => 'Cliente Demo',
                'telefone' => '(11) 98888-7777',
                'role' => 'cliente',
                'password' => Hash::make('Cliente123'),
            ]
        );

        $categorias = collect([
            ['nome' => 'Masculina', 'slug' => 'masculina'],
            ['nome' => 'Infantil', 'slug' => 'infantil'],
            ['nome' => 'Seleções', 'slug' => 'selecoes'],
            ['nome' => 'Clubes', 'slug' => 'clubes'],
            ['nome' => 'Retrô', 'slug' => 'retro'],
        ])->map(fn ($c) => Category::updateOrCreate(['slug' => $c['slug']], $c));

        $clubes = collect([
            ['nome' => 'Flamengo', 'slug' => 'flamengo', 'pais' => 'Brasil'],
            ['nome' => 'Corinthians', 'slug' => 'corinthians', 'pais' => 'Brasil'],
            ['nome' => 'Barcelona', 'slug' => 'barcelona', 'pais' => 'Espanha'],
            ['nome' => 'Real Madrid', 'slug' => 'real-madrid', 'pais' => 'Espanha'],
            ['nome' => 'Paris Saint-Germain', 'slug' => 'psg', 'pais' => 'França'],
            ['nome' => 'AC Milan', 'slug' => 'ac-milan', 'pais' => 'Itália'],
            ['nome' => 'Manchester City', 'slug' => 'manchester-city', 'pais' => 'Inglaterra'],
            ['nome' => 'Inter Miami', 'slug' => 'inter-miami', 'pais' => 'EUA'],
        ])->map(fn ($c) => Club::updateOrCreate(['slug' => $c['slug']], $c));

        $ligas = collect([
            ['nome' => 'Brasileirão', 'slug' => 'brasileirao', 'pais' => 'Brasil'],
            ['nome' => 'Champions League', 'slug' => 'champions-league', 'pais' => 'Europa'],
            ['nome' => 'La Liga', 'slug' => 'la-liga', 'pais' => 'Espanha'],
            ['nome' => 'Premier League', 'slug' => 'premier-league', 'pais' => 'Inglaterra'],
            ['nome' => 'MLS', 'slug' => 'mls', 'pais' => 'EUA'],
        ])->map(fn ($l) => League::updateOrCreate(['slug' => $l['slug']], $l));

        $produtos = [
            [
                'nome' => 'Camisa Flamengo 23/24',
                'slug' => 'camisa-flamengo-23-24',
                'category_id' => $categorias->firstWhere('slug', 'clubes')->id,
                'club_id' => $clubes->firstWhere('slug', 'flamengo')->id,
                'league_id' => $ligas->firstWhere('slug', 'brasileirao')->id,
                'descricao' => 'Camisa oficial Flamengo temporada 23/24, tecido dry fit e patch oficial.',
                'preco' => 349.90,
                'preco_promocional' => 299.90,
                'destaque' => true,
                'mais_vendido' => true,
            ],
            [
                'nome' => 'Camisa Barcelona 23/24',
                'slug' => 'camisa-barcelona-23-24',
                'category_id' => $categorias->firstWhere('slug', 'clubes')->id,
                'club_id' => $clubes->firstWhere('slug', 'barcelona')->id,
                'league_id' => $ligas->firstWhere('slug', 'la-liga')->id,
                'descricao' => 'Camisa titular Barcelona 23/24 com listras clássicas e escudo bordado.',
                'preco' => 399.90,
                'preco_promocional' => null,
                'destaque' => true,
                'lancamento' => true,
            ],
            [
                'nome' => 'Camisa Real Madrid 23/24',
                'slug' => 'camisa-real-madrid-23-24',
                'category_id' => $categorias->firstWhere('slug', 'clubes')->id,
                'club_id' => $clubes->firstWhere('slug', 'real-madrid')->id,
                'league_id' => $ligas->firstWhere('slug', 'champions-league')->id,
                'descricao' => 'Branco clássico com detalhes dourados, tecido leve e confortável.',
                'preco' => 419.90,
                'preco_promocional' => 379.90,
                'mais_vendido' => true,
            ],
            [
                'nome' => 'Camisa Corinthians Home 23/24',
                'slug' => 'camisa-corinthians-23-24',
                'category_id' => $categorias->firstWhere('slug', 'clubes')->id,
                'club_id' => $clubes->firstWhere('slug', 'corinthians')->id,
                'league_id' => $ligas->firstWhere('slug', 'brasileirao')->id,
                'descricao' => 'Branca com detalhes pretos, corte moderno e tecido respirável.',
                'preco' => 349.90,
                'preco_promocional' => null,
                'destaque' => true,
            ],
            [
                'nome' => 'Camisa PSG 23/24',
                'slug' => 'camisa-psg-23-24',
                'category_id' => $categorias->firstWhere('slug', 'clubes')->id,
                'club_id' => $clubes->firstWhere('slug', 'psg')->id,
                'league_id' => $ligas->firstWhere('slug', 'champions-league')->id,
                'descricao' => 'Azul marinho com faixa central, logo e patrocínio em branco.',
                'preco' => 399.90,
                'preco_promocional' => 359.90,
                'mais_vendido' => true,
            ],
            [
                'nome' => 'Camisa AC Milan 23/24',
                'slug' => 'camisa-ac-milan-23-24',
                'category_id' => $categorias->firstWhere('slug', 'clubes')->id,
                'club_id' => $clubes->firstWhere('slug', 'ac-milan')->id,
                'league_id' => $ligas->firstWhere('slug', 'champions-league')->id,
                'descricao' => 'Listras vermelhas e pretas, gola em V, tecido dry.',
                'preco' => 389.90,
                'preco_promocional' => null,
                'destaque' => true,
            ],
            [
                'nome' => 'Camisa Manchester City 23/24',
                'slug' => 'camisa-manchester-city-23-24',
                'category_id' => $categorias->firstWhere('slug', 'clubes')->id,
                'club_id' => $clubes->firstWhere('slug', 'manchester-city')->id,
                'league_id' => $ligas->firstWhere('slug', 'premier-league')->id,
                'descricao' => 'Azul celeste com detalhes brancos, modelo campeão da Premier League.',
                'preco' => 409.90,
                'preco_promocional' => 379.90,
                'lancamento' => true,
            ],
            [
                'nome' => 'Camisa Inter Miami 23/24',
                'slug' => 'camisa-inter-miami-23-24',
                'category_id' => $categorias->firstWhere('slug', 'clubes')->id,
                'club_id' => $clubes->firstWhere('slug', 'inter-miami')->id,
                'league_id' => $ligas->firstWhere('slug', 'mls')->id,
                'descricao' => 'Rosa icônico com detalhes pretos, modelo de jogo MLS.',
                'preco' => 379.90,
                'preco_promocional' => null,
                'destaque' => true,
            ],
            [
                'nome' => 'Camisa Seleção Brasil 2002 Retrô',
                'slug' => 'camisa-brasil-2002-retro',
                'category_id' => $categorias->firstWhere('slug', 'retro')->id,
                'club_id' => null,
                'league_id' => $ligas->firstWhere('slug', 'champions-league')->id,
                'descricao' => 'Retrô do penta 2002, amarelo clássico com detalhes verdes.',
                'preco' => 299.90,
                'preco_promocional' => null,
                'mais_vendido' => true,
            ],
            [
                'nome' => 'Camisa Seleção Argentina 2022',
                'slug' => 'camisa-argentina-2022',
                'category_id' => $categorias->firstWhere('slug', 'selecoes')->id,
                'club_id' => null,
                'league_id' => $ligas->firstWhere('slug', 'champions-league')->id,
                'descricao' => 'Faixas celestes e brancas, modelo campeão do mundo 2022.',
                'preco' => 389.90,
                'preco_promocional' => 349.90,
                'destaque' => true,
            ],
        ];

        foreach ($produtos as $produtoData) {
            $produto = Product::updateOrCreate(
                ['slug' => $produtoData['slug']],
                array_merge($produtoData, ['moeda' => 'BRL', 'ativo' => true, 'estoque_total' => 0])
            );

            $produto->images()->delete();

            $tamanhos = [
                ['tamanho' => 'P', 'estoque' => 10],
                ['tamanho' => 'M', 'estoque' => 12],
                ['tamanho' => 'G', 'estoque' => 8],
                ['tamanho' => 'EG', 'estoque' => 5],
            ];
            $produto->sizes()->delete();
            $estoqueTotal = 0;
            foreach ($tamanhos as $tam) {
                ProductSize::create(array_merge($tam, ['product_id' => $produto->id]));
                $estoqueTotal += $tam['estoque'];
            }
            $produto->update(['estoque_total' => $estoqueTotal]);
        }

        $cupom = Coupon::updateOrCreate(
            ['codigo' => 'BEMVINDO10'],
            [
                'tipo' => 'percentual',
                'valor' => 10,
                'valor_minimo' => 200,
                'limite_uso' => 100,
                'ativo' => true,
            ]
        );

        Setting::updateOrCreate(['chave' => 'nome_loja'], ['valor' => 'Gallo Classics']);
        Setting::updateOrCreate(['chave' => 'email_contato'], ['valor' => 'contato@galloclassics.test']);
        Setting::updateOrCreate(['chave' => 'cor_primaria'], ['valor' => '#111111']);

        $endereco = Address::updateOrCreate(
            ['user_id' => $cliente->id, 'apelido' => 'Principal'],
            [
                'nome' => 'Cliente Demo',
                'telefone' => '(11) 98888-7777',
                'cep' => '01000-000',
                'rua' => 'Av. Paulista',
                'numero' => '1000',
                'bairro' => 'Bela Vista',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'pais' => 'Brasil',
            ]
        );

        $produtoPedido = Product::first();
        $cart = Cart::create([
            'user_id' => $cliente->id,
            'coupon_id' => $cupom->id,
            'status' => 'convertido',
            'subtotal' => $produtoPedido->preco,
            'desconto' => 10,
            'total' => $produtoPedido->preco - 10,
        ]);

        $size = $produtoPedido->sizes()->first();
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $produtoPedido->id,
            'product_size_id' => $size?->id,
            'quantidade' => 1,
            'preco_unitario' => $produtoPedido->preco,
            'total' => $produtoPedido->preco,
        ]);

        $order = Order::create([
            'user_id' => $cliente->id,
            'cart_id' => $cart->id,
            'address_id' => $endereco->id,
            'coupon_id' => $cupom->id,
            'status' => 'pago',
            'pagamento_status' => 'pago',
            'pagamento_metodo' => 'mock',
            'subtotal' => $cart->subtotal,
            'desconto' => $cart->desconto,
            'frete' => 0,
            'total' => $cart->total,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $produtoPedido->id,
            'nome' => $produtoPedido->nome,
            'tamanho' => $size?->tamanho,
            'quantidade' => 1,
            'preco_unitario' => $produtoPedido->preco,
            'total' => $produtoPedido->preco,
        ]);

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status' => 'pago',
            'comentario' => 'Pedido de exemplo criado pelo seeder.',
        ]);
    }
}
