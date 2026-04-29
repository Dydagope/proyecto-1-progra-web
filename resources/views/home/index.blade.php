@extends('layouts.app')

@section('title', 'Inicio | González & Salazar')

@section('content')
<section class="search-section">
    <form action="{{ route('home') }}" method="GET" class="main-search">
        <span class="search-icon">⌕</span>
        <input
            type="text"
            name="buscar"
            value="{{ $search }}"
            placeholder="Buscar por nombre, productor, uva, país, región o año"
        >
        <button type="submit">Buscar</button>

        @if ($search)
            <a href="{{ route('home') }}" class="clear-search">Limpiar</a>
        @endif
    </form>
</section>

@if (!$search && $featuredProducts->count())
<section class="section">
    <div class="section-header">
        <p class="eyebrow">Recomendados</p>
        <h2>Productos destacados</h2>
    </div>

    <div class="product-grid">
        @foreach ($featuredProducts as $product)
            @include('products.partials.card', ['product' => $product])
        @endforeach
    </div>
</section>
@endif

<section class="section" id="ultimos">
    <div class="section-header">
        <p class="eyebrow">Catálogo</p>
        <h2>
            @if ($search)
                Resultados para “{{ $search }}”
            @else
                Últimos productos agregados
            @endif
        </h2>
    </div>

    @if ($products->count())
        <div class="product-grid">
            @foreach ($products as $product)
                @include('products.partials.card', ['product' => $product])
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $products->links('vendor.pagination.custom') }}
        </div>
    @else
        <div class="empty-state">
            No se encontraron productos con ese criterio de búsqueda.
        </div>
    @endif
</section>

<section class="section" id="categorias">
    <div class="section-header">
        <p class="eyebrow">Exploración</p>
        <h2>Categorías del catálogo</h2>
    </div>

    <div class="category-grid">
        @foreach ($categories as $category)
            <a href="{{ route('categories.show', $category) }}" class="category-card">
                @if ($category->image)
                    <img
                        src="{{ asset('images/categorias/' . $category->image) }}"
                        alt="{{ $category->name }}"
                        class="category-image"
                    >
                @endif

                <span>{{ $category->type }}</span>
                <h3>{{ $category->name }}</h3>
                <p>{{ $category->description }}</p>
                <small>{{ $category->products_count }} productos</small>
            </a>
        @endforeach
    </div>
</section>

<section class="info-block" id="blog">
    <div>
        <p class="eyebrow">Blog</p>
        <h2>Notas sobre vinos</h2>
    </div>
    <p>
        El vino puede clasificarse por su tipo, uva, región, añada y método de elaboración.
        Los vinos tintos suelen acompañar carnes, pastas y comidas con mayor intensidad;
        los blancos se asocian con pescados, mariscos, quesos suaves y platos ligeros;
        mientras que los rosados y champanes funcionan bien en aperitivos, celebraciones
        y maridajes frescos. También influyen aspectos como la temperatura de servicio,
        el volumen de la botella, el porcentaje de alcohol y el tiempo de conservación.
    </p>
</section>

<section class="info-block" id="historia">
    <div>
        <p class="eyebrow">Historia</p>
        <h2>Historia de González & Salazar</h2>
    </div>
    <p>
        González & Salazar nace como una tienda costarricense especializada en vinos y
        champanes seleccionados. Su propuesta se enfoca en ofrecer un catálogo organizado,
        elegante y fácil de consultar, donde cada producto pueda identificarse por su
        productor, país, región, uva, añada, precio y disponibilidad. La tienda busca
        acercar al público de Costa Rica a etiquetas reconocidas internacionalmente,
        combinando productos clásicos, opciones premium y referencias ideales para
        celebraciones, regalos o acompañamiento gastronómico.
    </p>
</section>
@endsection