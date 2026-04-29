<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:180'],
            'producer' => ['required', 'string', 'max:180'],
            'description' => ['required', 'string', 'min:20'],

            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'price' => ['required', 'numeric', 'min:0'],
            'wine_type' => ['required', 'in:Tinto,Blanco,Rosado'],
            'grape' => ['required', 'string', 'max:180'],
            'country' => ['required', 'in:Francia,Chile,Argentina,España,Italia,Nueva Zelanda,EE.UU.,Australia'],
            'region' => ['required', 'string', 'max:120'],
            'appellation' => ['nullable', 'string', 'max:180'],
            'vintage_year' => ['nullable', 'integer', 'min:1900', 'max:2035'],
            'volume_ml' => ['required', 'integer', 'in:375,750,1500'],
            'alcohol_percentage' => ['required', 'numeric', 'min:5', 'max:20'],
            'stock' => ['required', 'integer', 'min:0', 'max:999'],
            'condition' => ['required', 'in:Excelente,Muy bueno,Bueno'],
            'rating_source' => ['nullable', 'string', 'max:120'],
            'rating_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Debe seleccionar una categoría.',
            'category_id.exists' => 'La categoría seleccionada no existe.',

            'name.required' => 'Debe ingresar el nombre del producto.',
            'name.max' => 'El nombre del producto no puede superar los 180 caracteres.',

            'producer.required' => 'Debe ingresar el productor.',
            'producer.max' => 'El productor no puede superar los 180 caracteres.',

            'description.required' => 'Debe ingresar una descripción.',
            'description.min' => 'La descripción debe tener al menos 20 caracteres.',

            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser de tipo jpg, jpeg, png o webp.',
            'image.max' => 'La imagen no puede pesar más de 2 MB.',

            'price.required' => 'Debe ingresar el precio.',
            'price.numeric' => 'El precio debe ser un valor numérico.',
            'price.min' => 'El precio no puede ser menor que 0.',

            'wine_type.required' => 'Debe seleccionar el tipo de vino.',
            'wine_type.in' => 'El tipo de vino seleccionado no es válido.',

            'grape.required' => 'Debe ingresar la uva o mezcla de uvas.',
            'grape.max' => 'La uva no puede superar los 180 caracteres.',

            'country.required' => 'Debe seleccionar el país.',
            'country.in' => 'El país seleccionado no es válido.',

            'region.required' => 'Debe ingresar la región.',
            'region.max' => 'La región no puede superar los 120 caracteres.',

            'appellation.max' => 'La denominación no puede superar los 180 caracteres.',

            'vintage_year.integer' => 'La añada debe ser un número entero.',
            'vintage_year.min' => 'La añada no puede ser menor que 1900.',
            'vintage_year.max' => 'La añada no puede ser mayor que 2035.',

            'volume_ml.required' => 'Debe seleccionar el volumen.',
            'volume_ml.in' => 'El volumen debe ser 375 ml, 750 ml o 1500 ml.',

            'alcohol_percentage.required' => 'Debe ingresar el porcentaje de alcohol.',
            'alcohol_percentage.numeric' => 'El porcentaje de alcohol debe ser numérico.',
            'alcohol_percentage.min' => 'El porcentaje de alcohol no puede ser menor que 5.',
            'alcohol_percentage.max' => 'El porcentaje de alcohol no puede ser mayor que 20.',

            'stock.required' => 'Debe ingresar el stock disponible.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser menor que 0.',
            'stock.max' => 'El stock no puede ser mayor que 999.',

            'condition.required' => 'Debe seleccionar la condición del producto.',
            'condition.in' => 'La condición seleccionada no es válida.',

            'rating_source.max' => 'La fuente de reseña no puede superar los 120 caracteres.',

            'rating_score.numeric' => 'El puntaje debe ser numérico.',
            'rating_score.min' => 'El puntaje no puede ser menor que 0.',
            'rating_score.max' => 'El puntaje no puede ser mayor que 100.',
        ];
    }
}