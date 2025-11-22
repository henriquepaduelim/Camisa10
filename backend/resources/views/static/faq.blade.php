@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-10 space-y-8">
    <div class="bg-white/80 backdrop-blur rounded-2xl border border-slate-200 shadow-sm p-6">
        <h1 class="text-2xl font-bold mb-4">Perguntas frequentes</h1>
        <div class="space-y-4 text-slate-700 text-sm sm:text-base">
            <details class="group border border-slate-200 rounded-xl p-4">
                <summary class="flex items-center justify-between cursor-pointer font-semibold text-slate-900">
                    Como funciona a entrega?
                    <span class="text-brand group-open:rotate-90 transition"><i class="fa-solid fa-chevron-right"></i></span>
                </summary>
                <p class="mt-3">Enviamos para todo o Brasil com prazos exibidos no checkout. Após a postagem, você recebe o código de rastreio por e-mail.</p>
            </details>
            <details class="group border border-slate-200 rounded-xl p-4">
                <summary class="flex items-center justify-between cursor-pointer font-semibold text-slate-900">
                    As camisas são oficiais?
                    <span class="text-brand group-open:rotate-90 transition"><i class="fa-solid fa-chevron-right"></i></span>
                </summary>
                <p class="mt-3">Trabalhamos com linhas oficiais e retrô premium. Cada produto possui a indicação de autenticidade na descrição.</p>
            </details>
            <details class="group border border-slate-200 rounded-xl p-4">
                <summary class="flex items-center justify-between cursor-pointer font-semibold text-slate-900">
                    Posso trocar tamanhos?
                    <span class="text-brand group-open:rotate-90 transition"><i class="fa-solid fa-chevron-right"></i></span>
                </summary>
                <p class="mt-3">Sim, em até 7 dias após o recebimento, com a peça sem uso e etiqueta preservada. Consulte as instruções por e-mail.</p>
            </details>
            <details class="group border border-slate-200 rounded-xl p-4">
                <summary class="flex items-center justify-between cursor-pointer font-semibold text-slate-900">
                    Quais meios de pagamento?
                    <span class="text-brand group-open:rotate-90 transition"><i class="fa-solid fa-chevron-right"></i></span>
                </summary>
                <p class="mt-3">Aceitamos cartão de crédito, PIX e boleto (quando habilitado). O checkout é seguro e criptografado.</p>
            </details>
        </div>
    </div>
</section>
@endsection
