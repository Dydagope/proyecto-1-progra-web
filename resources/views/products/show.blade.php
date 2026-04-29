@extends('layouts.app')

@section('title', $product->name . ' | Vinoteca Académica')

@section('content')
<section class="product-detail">
    <div class="product-detail-image">
        <p class="breadcrumb">
            <a href="{{ route('home') }}">Inicio</a>
            <span>›</span>
            <a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a>
            <span>›</span>
            <span>{{ $product->name }}</span>
        </p>

        <img
            src="{{ asset('images/productos/' . ($product->image ?: 'sin-imagen.jpg')) }}"
            alt="{{ $product->name }}"
        >
    </div>

    <div class="product-detail-info">
        <p class="eyebrow">{{ $product->producer }}</p>
        <h1>{{ $product->name }}</h1>

        <div class="stars">
            ★★★★★
            <span>
                {{ $product->rating_score ? number_format($product->rating_score, 1) : 'Sin calificación' }}
                @if ($product->rating_source)
                    · {{ $product->rating_source }}
                @endif
            </span>
        </div>

        <div class="detail-price">
            ₡ {{ number_format($product->price, 2, ',', '.') }}
        </div>

        <div class="fake-buy-box">
            <input type="number" value="1" min="1" max="{{ max($product->stock, 1) }}">
            <button type="button">Agregar al carrito</button>
        </div>

        <p class="stock-note">
            Stock disponible: {{ $product->stock }} unidades.
        </p>

        <p class="description">
            {{ $product->description }}
        </p>

        <div class="admin-actions">
            <a href="{{ route('productos.edit', $product) }}" class="btn dark">Modificar</a>

            <form
                action="{{ route('productos.destroy', $product) }}"
                method="POST"
                onsubmit="return confirm('¿Desea eliminar este producto?')"
            >
                @csrf
                @method('DELETE')
                <button type="submit" class="btn danger">Eliminar</button>
            </form>

            <a href="{{ route('productos.index') }}" class="btn light">Volver al catálogo</a>
        </div>

        <dl class="product-specs">
            <div>
                <dt>Categoría</dt>
                <dd>{{ $product->category->name }}</dd>
            </div>
            <div>
                <dt>Tipo</dt>
                <dd>{{ $product->wine_type }}</dd>
            </div>
            <div>
                <dt>Productor</dt>
                <dd>{{ $product->producer }}</dd>
            </div>
            <div>
                <dt>Añada</dt>
                <dd>{{ $product->vintage_year ?: 'NV' }}</dd>
            </div>
            <div>
                <dt>País</dt>
                <dd>{{ $product->country }}</dd>
            </div>
            <div>
                <dt>Región</dt>
                <dd>{{ $product->region }}</dd>
            </div>
            <div>
                <dt>Denominación</dt>
                <dd>{{ $product->appellation ?: 'No especificada' }}</dd>
            </div>
            <div>
                <dt>Uva</dt>
                <dd>{{ $product->grape }}</dd>
            </div>
            <div>
                <dt>Alcohol</dt>
                <dd>{{ number_format($product->alcohol_percentage, 1) }}%</dd>
            </div>
            <div>
                <dt>Volumen</dt>
                <dd>{{ $product->volume_ml }} ml</dd>
            </div>
            <div>
                <dt>Condición</dt>
                <dd>{{ $product->condition }}</dd>
            </div>
        </dl>
    </div>
</section>

@if ($relatedProducts->count())
<section class="section">
    <div class="section-header">
        <p class="eyebrow">Productos relacionados</p>
        <h2>También puede interesarle</h2>
    </div>

    <div class="product-grid">
        @foreach ($relatedProducts as $related)
            @include('products.partials.card', ['product' => $related])
        @endforeach
    </div>
</section>
@endif
@endsection