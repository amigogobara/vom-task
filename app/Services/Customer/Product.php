<?php

namespace App\Services\Customer;

use App\Http\Resources\PaginateCollection;
use App\Http\Resources\ProductResource;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;
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
}
