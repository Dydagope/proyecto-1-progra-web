@extends('layouts.app')

@section('title', 'Agregar producto | González & Salazar')

@section('content')
<section class="form-page">
    <div class="form-header">
        <p class="breadcrumb">
            <a href="{{ route('home') }}">Inicio</a>
            <span>›</span>
            <a href="{{ route('productos.index') }}">Catálogo</a>
            <span>›</span>
            <span>Agregar producto</span>
        </p>

        <h1>Agregar producto</h1>
        <p>
            Complete la información del vino o champán que desea registrar en el catálogo.
        </p>
    </div>

    <div class="form-card">
        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('products.partials.form', [
                'product' => $product,
                'categories' => $categories,
            ])

            <div class="form-actions">
                <button type="submit" class="btn dark">Guardar producto</button>
                <a href="{{ route('productos.index') }}" class="btn light">Cancelar</a>
            </div>
        </form>
    </div>
</section>
@endsection