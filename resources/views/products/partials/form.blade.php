@if ($errors->any())
    <div class="alert error">
        <strong>Revise los campos del formulario.</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-grid">
    <div class="form-group">
        <label for="category_id">Categoría</label>
        <select name="category_id" id="category_id" required>
            <option value="">Seleccione una categoría</option>
            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(old('category_id', $product->category_id) == $category->id)
                >
                    {{ $category->type }} - {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="name">Nombre del producto</label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $product->name) }}"
            required
        >
    </div>

    <div class="form-group">
        <label for="producer">Productor</label>
        <input
            type="text"
            id="producer"
            name="producer"
            value="{{ old('producer', $product->producer) }}"
            required
        >
    </div>

    <div class="form-group">
        <label for="image">Imagen del producto</label>
        <input
            type="file"
            id="image"
            name="image"
            accept="image/png,image/jpeg,image/jpg,image/webp"
        >

        @if ($product->image)
            <small>Imagen actual: {{ $product->image }}</small>
            <img
                src="{{ asset('images/productos/' . $product->image) }}"
                alt="{{ $product->name }}"
                style="width: 80px; height: 110px; object-fit: contain; margin-top: 10px;"
            >
        @else
            <small>Formatos permitidos: jpg, jpeg, png o webp. Tamaño máximo: 2 MB.</small>
        @endif
    </div>

    <div class="form-group full">
        <label for="description">Descripción</label>
        <textarea
            id="description"
            name="description"
            rows="5"
            required
        >{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="form-group">
        <label for="price">Precio</label>
        <input
            type="number"
            step="0.01"
            min="0"
            id="price"
            name="price"
            value="{{ old('price', $product->price) }}"
            required
        >
    </div>

    <div class="form-group">
        <label for="wine_type">Tipo</label>
        <select name="wine_type" id="wine_type" required>
            @foreach (['Tinto', 'Blanco', 'Rosado'] as $type)
                <option value="{{ $type }}" @selected(old('wine_type', $product->wine_type) === $type)>
                    {{ $type }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="grape">Uva</label>
        <input
            type="text"
            id="grape"
            name="grape"
            value="{{ old('grape', $product->grape) }}"
            required
        >
    </div>

    <div class="form-group">
        <label for="country">País</label>
        <select name="country" id="country" required>
            @foreach (['Francia', 'Chile', 'Argentina', 'España', 'Italia', 'Nueva Zelanda', 'EE.UU.', 'Australia'] as $country)
                <option value="{{ $country }}" @selected(old('country', $product->country) === $country)>
                    {{ $country }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="region">Región</label>
        <input
            type="text"
            id="region"
            name="region"
            value="{{ old('region', $product->region) }}"
            placeholder="Ejemplo: Champagne, Rioja, Mendoza, Napa Valley"
            required
        >
    </div>

    <div class="form-group">
        <label for="appellation">Denominación</label>
        <input
            type="text"
            id="appellation"
            name="appellation"
            value="{{ old('appellation', $product->appellation) }}"
            placeholder="Ejemplo: AOC Champagne, DOCa Rioja"
        >
    </div>

    <div class="form-group">
        <label for="vintage_year">Año / añada</label>
        <input
            type="number"
            id="vintage_year"
            name="vintage_year"
            min="1900"
            max="2035"
            value="{{ old('vintage_year', $product->vintage_year) }}"
        >
        <small>Si el producto no tiene añada, puede dejar este campo vacío.</small>
    </div>

    <div class="form-group">
        <label for="volume_ml">Volumen</label>
        <select name="volume_ml" id="volume_ml" required>
            @foreach ([375, 750, 1500] as $volume)
                <option value="{{ $volume }}" @selected(old('volume_ml', $product->volume_ml ?: 750) == $volume)>
                    {{ $volume }} ml
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="alcohol_percentage">Alcohol %</label>
        <input
            type="number"
            step="0.1"
            min="5"
            max="20"
            id="alcohol_percentage"
            name="alcohol_percentage"
            value="{{ old('alcohol_percentage', $product->alcohol_percentage) }}"
            required
        >
    </div>

    <div class="form-group">
        <label for="stock">Stock</label>
        <input
            type="number"
            id="stock"
            name="stock"
            min="0"
            max="999"
            value="{{ old('stock', $product->stock) }}"
            required
        >
    </div>

    <div class="form-group">
        <label for="condition">Condición</label>
        <select name="condition" id="condition" required>
            @foreach (['Excelente', 'Muy bueno', 'Bueno'] as $condition)
                <option value="{{ $condition }}" @selected(old('condition', $product->condition) === $condition)>
                    {{ $condition }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="rating_source">Fuente de reseña</label>
        <input
            type="text"
            id="rating_source"
            name="rating_source"
            value="{{ old('rating_source', $product->rating_source) }}"
            placeholder="Ejemplo: Catálogo"
        >
    </div>

    <div class="form-group">
        <label for="rating_score">Puntaje</label>
        <input
            type="number"
            step="0.1"
            min="0"
            max="100"
            id="rating_score"
            name="rating_score"
            value="{{ old('rating_score', $product->rating_score) }}"
        >
    </div>

    <div class="form-group checkbox-group full">
        <label>
            <input
                type="checkbox"
                name="is_featured"
                value="1"
                @checked(old('is_featured', $product->is_featured))
            >
            Mostrar como producto destacado
        </label>
    </div>
</div>