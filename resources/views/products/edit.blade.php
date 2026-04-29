@extends('layouts.app')

@section('title', 'Editar producto | González & Salazar')

@section('content')
<section class="form-page">
    <div class="form-header">
        <p class="breadcrumb">
            <a href="{{ route('home') }}">Inicio</a>
            <span>›</span>
            <a href="{{ route('productos.index') }}">Catálogo</a>
            <span>›</span>
            <span>Editar producto</span>
        </p>

        <h1>Editar producto</h1>
        <p>
            Modifique los datos del producto seleccionado.
        </p>
    </div>

    <div class="form-card">
        <form action="{{ route('productos.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('products.partials.form', [
                'product' => $product,
                'categories' => $categories,
            ])

            <div class="form-actions">
                <button type="submit" class="btn dark">Actualizar producto</button>
                <a href="{{ route('productos.show', $product) }}" class="btn light">Cancelar</a>
            </div>
        </form>
    </div>
</section>
@endsection