<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        // Only allow authenticated users with manage-products ability
        return $this->user() && $this->user()->can('manage-products');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|size:3',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
            'track_inventory' => 'boolean',
            'image' => 'nullable|image|max:2048', // single main image
            'images.*' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ];
    }
}

