<?php

namespace App\Services\Customer;

use App\Http\Requests\AddToCartRequest;
use App\Http\Resources\PaginateCollection;
use App\Http\Resources\ProductResource;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Product
{
    protected $store;

    public function __construct()
    {
        $origin = request()->header('origin');
        $this->store = Store::where('url',$origin)->first();
        if(is_null($this->store)){
            throw new NotFoundHttpException('Store Not found');
        }
    }

    public function index()
    {
        $validator = Validator::make(request()->all(),[
            'lang' => 'required'
        ]);
        if($validator->fails()){ throw  new ValidationException($validator);}
        $products = $this->store->products()->paginate();

        return new PaginateCollection($products, ProductResource::class);
    }

    public function addToCart(AddToCartRequest $request)
    {
        $cardId = Str::uuid()->toString();
        $products = [];

        $totalPriceIncludeVat = 0;
        $totalPriceExcludeVat = 0;
        foreach ($request->products as $product) {
            $productModel = \App\Models\Product::find($product['product_id']);

            if ($productModel->price_has_vat) {
                $totalPriceIncludeVat += $productModel->price * $product['quantity'];
                $vatNote = 'This price include VAT';
            } else {
                $totalPriceExcludeVat += $productModel->price * $product['quantity'];
                $vatNote =  'This price doesn\'t include VAT';
            }

            $products[] = [
                'product_name' => $productModel->getTranslation('name', $request->lang),
                'unit_product_price' => $productModel->price,
                'quantity'          => $product['quantity'],
                'price_include_vat' => $vatNote
            ];
        }

       $totalPrice = $this->calculateTotalPrice($totalPriceExcludeVat, $totalPriceIncludeVat);

        return [
            'card_id' => $cardId,
            'products' => $products,
            'VAT'      => (float)$this->store->vat_value. ' '. $this->store->vat_value_type,
            'shipping' => (float)$this->store->shipping_cost_value.' '.$this->store->shipping_cost_value_type,
            'total_price' => $totalPrice
        ];
    }

    private function calculateTotalPrice($totalPriceExcludeVat, $totalPriceIncludeVat)
    {
        $totalWithVat = $this->calculateTotalPriceWithVat($totalPriceExcludeVat, $totalPriceIncludeVat);

        return $this->calculateTotalPriceWithShippingCost($totalWithVat);
    }

    private function calculateTotalPriceWithVat($totalPriceExcludeVat, $totalPriceIncludeVat)
    {
        $storeVat = $this->store->vat_value;
        if ($storeVat != 0) {
            if ($this->store->vat_value_type == 'percentage') {
                $vatValue = ($totalPriceExcludeVat * $storeVat) / 100;
                $totalPriceWithVat = $totalPriceExcludeVat + $vatValue +
                    $totalPriceIncludeVat;
            } else {
                $totalPriceWithVat = $totalPriceExcludeVat + $storeVat +
                    $totalPriceIncludeVat;
            }
        } else {
            $totalPriceWithVat = $totalPriceIncludeVat + $totalPriceExcludeVat;
        }

        return $totalPriceWithVat;
    }

    private function calculateTotalPriceWithShippingCost($totalPrice)
    {
        $shippingValue = $this->store->shipping_cost_value;
        if ($shippingValue != 0) {
            if ($this->store->shipping_cost_value_type == 'percentage') {
                $shippingCost = $totalPrice * $shippingValue / 100;
                $totalPrice = $totalPrice + $shippingCost;
            } else {
                $shippingCost = $shippingValue;
                $totalPrice = $totalPrice + $shippingCost;
            }
        }

        return $totalPrice;
    }
}
