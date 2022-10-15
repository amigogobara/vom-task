<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Services\Customer\Product;
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
        return $this->apiResponse($this->product->index());
    }

    public function addToCart(AddToCartRequest $request)
    {
        return $this->apiResponse($this->product->addToCart($request));
    }
}
