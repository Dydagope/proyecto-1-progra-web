@extends('layouts.app')

@section('title', $title . ' | González & Salazar')

@section('content')
<section class="catalog-header">
    <p class="breadcrumb">
        <a href="{{ route('home') }}">Inicio</a>
        <span>›</span>
        <span>{{ $title }}</span>
    </p>

    <h1>{{ $title }}</h1>

    @if ($category)
        <p>{{ $category->description }}</p>
    @else
        <p>
            Explore los productos disponibles mediante categorías, búsqueda y ordenamiento.
        </p>
    @endif
</section>

<section class="catalog-layout">
    <aside class="filters">
        <h2>Filtros</h2>

        <form method="GET">
            <label for="buscar">Buscar</label>
            <input
                type="text"
                id="buscar"
                name="buscar"
                value="{{ $search }}"
                placeholder="Nombre, productor, región..."
            >

            @isset($categoryId)
                <label for="categoria">Categoría</label>
                <select name="categoria" id="categoria">
                    <option value="">Todas</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}" @selected((string) $categoryId === (string) $item->id)>
                            {{ $item->name }} ({{ $item->products_count }})
                        </option>
                    @endforeach
                </select>
            @endisset

            <label for="orden">Ordenar por</label>
            <select name="orden" id="orden">
                <option value="recientes" @selected($sort === 'recientes')>Más recientes</option>
                <option value="nombre" @selected($sort === 'nombre')>Nombre</option>
                <option value="precio_asc" @selected($sort === 'precio_asc')>Precio menor a mayor</option>
                <option value="precio_desc" @selected($sort === 'precio_desc')>Precio mayor a menor</option>
                <option value="anio_desc" @selected($sort === 'anio_desc')>Año más reciente</option>
            </select>

            <button type="submit" class="btn dark full">Aplicar filtros</button>
        </form>

        <div class="filter-list">
            <h3>Categorías</h3>
            @foreach ($categories as $item)
                <a href="{{ route('categories.show', $item) }}">
                    {{ $item->name }}
                    <span>{{ $item->products_count }}</span>
                </a>
            @endforeach
        </div>
    </aside>

    <section class="catalog-content">
        <div class="catalog-tools">
            <span>{{ $products->total() }} productos encontrados</span>
            <a href="{{ route('productos.create') }}" class="btn light">Agregar producto</a>
        </div>

        @if ($products->count())
            <div class="product-grid catalog-grid">
                @foreach ($products as $product)
                    @include('products.partials.card', ['product' => $product])
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $products->links('vendor.pagination.custom') }}
            </div>
        @else
            <div class="empty-state">
                No hay productos para mostrar.
            </div>
        @endif
    </section>
</section>
@endsection