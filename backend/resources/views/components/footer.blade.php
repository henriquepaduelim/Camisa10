<footer class="bg-[var(--cor-primaria)] text-white mt-12">
    <div class="max-w-6xl mx-auto px-4 py-10 grid grid-cols-1 sm:grid-cols-3 gap-8">
        <div>
            <div class="flex items-center gap-2 font-bold text-lg text-white">
                <i class="fa-solid fa-futbol"></i>
                <span>{{ config('app.name') }}</span>
            </div>
            <p class="mt-3 text-sm text-slate-200">Camisas oficiais e retrôs dos principais clubes e seleções, com experiência mobile-first.</p>
        </div>
        <div>
            <h4 class="font-semibold mb-3 text-sm uppercase tracking-wide text-slate-100">Institucional</h4>
            <ul class="space-y-2 text-sm text-slate-200">
                <li><a class="hover:text-white" href="{{ url('/faq') }}">FAQ</a></li>
                <li><a class="hover:text-white" href="{{ url('/contato') }}">Contato</a></li>
                <li><a class="hover:text-white" href="{{ url('/termos') }}">Termos de uso</a></li>
                <li><a class="hover:text-white" href="{{ url('/privacidade') }}">Política de privacidade</a></li>
                <li><a class="hover:text-white" href="{{ url('/admin/login') }}">Área do lojista</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-3 text-sm uppercase tracking-wide text-slate-100">Atendimento</h4>
            <ul class="space-y-2 text-sm text-slate-200">
                <li><i class="fa-solid fa-envelope mr-2"></i>contato@galloclassics.test</li>
                <li><i class="fa-solid fa-phone mr-2"></i>(11) 98888-7777</li>
                <li><i class="fa-solid fa-location-dot mr-2"></i>São Paulo - SP</li>
            </ul>
        </div>
    </div>
    <div class="bg-[var(--cor-primaria-escura)] text-center text-xs text-slate-300 py-3">
        © {{ date('Y') }} {{ config('app.name') }} - Todos os direitos reservados. • Desenvolvido por <strong>StatCat</strong>
    </div>
</footer>
