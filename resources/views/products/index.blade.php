@extends('layouts.app')

@section('title', 'Administrar catálogo | González & Salazar')

@section('content')
<section class="catalog-header">
    <p class="breadcrumb">
        <a href="{{ route('home') }}">Inicio</a>
        <span>›</span>
        <span>Catálogo</span>
    </p>

    <h1>Administrar catálogo</h1>
    <p>
        Desde esta sección se pueden consultar, buscar, agregar, modificar y eliminar
        los productos del sistema.
    </p>
</section>

<section class="catalog-layout">
    <aside class="filters">
        <h2>Búsqueda</h2>

        <form method="GET" action="{{ route('productos.index') }}">
            <label for="buscar">Palabra clave</label>
            <input
                type="text"
                id="buscar"
                name="buscar"
                value="{{ $search }}"
                placeholder="Nombre, productor, uva..."
            >

            <label for="categoria">Categoría</label>
            <select name="categoria" id="categoria">
                <option value="">Todas</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>
                        {{ $category->type }} - {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <label for="orden">Orden</label>
            <select name="orden" id="orden">
                <option value="recientes" @selected($sort === 'recientes')>Más recientes</option>
                <option value="nombre" @selected($sort === 'nombre')>Nombre</option>
                <option value="precio_asc" @selected($sort === 'precio_asc')>Precio menor a mayor</option>
                <option value="precio_desc" @selected($sort === 'precio_desc')>Precio mayor a menor</option>
                <option value="anio_desc" @selected($sort === 'anio_desc')>Año más reciente</option>
            </select>

            <button type="submit" class="btn dark full">Buscar</button>
            <a href="{{ route('productos.index') }}" class="btn outline full">Limpiar</a>
        </form>
    </aside>

    <section class="catalog-content">
        <div class="catalog-tools">
            <span>{{ $products->total() }} productos registrados</span>
            <a href="{{ route('productos.create') }}" class="btn dark">Agregar producto</a>
        </div>

        @if ($products->count())
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <img
                                        src="{{ asset('images/productos/' . ($product->image ?: 'sin-imagen.jpg')) }}"
                                        alt="{{ $product->name }}"
                                        class="table-image"
                                    >
                                </td>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                    <span>{{ $product->producer }}</span>
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td>₡ {{ number_format($product->price, 2, ',', '.') }}</td>
                                <td>{{ $product->stock }}</td>
                                <td class="actions">
                                    <a href="{{ route('productos.show', $product) }}">Ver</a>
                                    <a href="{{ route('productos.edit', $product) }}">Editar</a>

                                    <form
                                        action="{{ route('productos.destroy', $product) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Desea eliminar este producto?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $products->links('vendor.pagination.custom') }}
            </div>
        @else
            <div class="empty-state">
                No se encontraron productos.
            </div>
        @endif
    </section>
</section>
@endsection