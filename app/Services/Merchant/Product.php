<?php

namespace App\Services\Merchant;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\PaginateCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Auth\AuthenticationException;

class Product
{

    public function index()
    {
        $merchant = auth()->user();
        $store = $merchant->store()->first();

        $products = $store->products()->paginate();

        return new PaginateCollection($products,ProductResource::class);
    }

    public function save(ProductRequest $request)
    {
        $merchant = auth()->guard('api')->user();
        $store = $merchant->store()->first();

        $product = $store->products()->create([
            'name' => [
                'en' => $request->name_en,
                'ar' => $request->name_ar
            ],
            'description' => [
                'en' => $request->description_en,
                'ar' => $request->description_ar
            ],
            'price' => $request->price,
            'price_has_vat' => $request->price_has_vat
        ]);

        return new ProductResource($product);
    }

    public function update(ProductRequest $request, \App\Models\Product $product)
    {
        $product->update([
            'name' => [
                'en' => $request->name_en,
                'ar' => $request->name_ar
            ],
            'description' => [
                'en' => $request->description_en,
                'ar' => $request->description_ar
            ],
            'price' => $request->price,
            'price_has_vat' => $request->price_has_vat
        ]);

        $product = \App\Models\Product::find($product->id);
        return new ProductResource($product);
    }

    public function show(\App\Models\Product $product)
    {
        return new ProductResource($product);
    }

    public function destroy(\App\Models\Product $product)
    {
        $product->delete();
    }


}
