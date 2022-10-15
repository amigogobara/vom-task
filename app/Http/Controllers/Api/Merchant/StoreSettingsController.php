<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingsRequest;
use App\Services\Merchant\StoreSettings;
use Illuminate\Http\Request;

class StoreSettingsController extends Controller
{
    public $storeSettings;

    public function __construct(StoreSettings $settings)
    {
        $this->storeSettings = $settings;
    }

    public function index()
    {
        return $this->apiResponse(auth()->user()->store);
    }

    public function update(StoreSettingsRequest $request)
    {
        auth()->user()->store()->update($request->validated());

        return $this->apiResponse(auth()->user()->store);
    }
}
