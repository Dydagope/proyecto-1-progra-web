<article class="product-card">
    <a href="{{ route('productos.show', $product) }}" class="product-image-link">
        <img
            src="{{ asset('images/productos/' . ($product->image ?: 'sin-imagen.jpg')) }}"
            alt="{{ $product->name }}"
            class="product-image"
        >
    </a>

    <div class="product-card-body">
        <p class="rating">
            ★ {{ $product->rating_source ?: 'Selección' }}
            @if ($product->rating_score)
                {{ number_format($product->rating_score, 0) }}
            @endif
        </p>

        <h3>{{ $product->producer }}</h3>

        <p class="product-name">
            {{ $product->name }}
        </p>

        <p class="product-meta">
            {{ $product->country }} · {{ $product->region }} · {{ $product->vintage_year }}
        </p>

        <p class="product-price">
            ₡ {{ number_format($product->price, 2, ',', '.') }}
        </p>

        <a href="{{ route('productos.show', $product) }}" class="btn outline">
            Ver detalle
        </a>
    </div>
</article>