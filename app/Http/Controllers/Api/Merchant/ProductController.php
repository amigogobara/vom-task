<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\Merchant\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        return $this->apiResponse($this->product->index(), 'List store products');
    }

    public function store(ProductRequest $request)
    {
        return $this->apiResponse($this->product->save($request), 'product saved');
    }

    public function show(\App\Models\Product $product)
    {
        return $this->apiResponse($this->product->show($product));
    }

    public function update(ProductRequest $request, \App\Models\Product $product)
    {
        return $this->apiResponse($this->product->update($request, $product), 'product updated');
    }

    public function destroy(\App\Models\Product $product)
    {
        $this->product->destroy($product);
        return $this->apiResponse(new \stdClass(), 'Product Deleted');
    }
}
