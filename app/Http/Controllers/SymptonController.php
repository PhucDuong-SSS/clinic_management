<?php

namespace App\Http\Controllers;

use App\Http\Requests\SymptonRequest;
use App\Http\Services\SymtonService;
use Illuminate\Http\Request;
use App\Models\Sympton;

class SymptonController extends Controller
{
    protected $symtonService;

    public function __construct(SymtonService $symtonService)
    {
        $this->symtonService = $symtonService;
    }

    public function addSympton(SymptonRequest $request)
    {

            Sympton::create( [
            'sympton_name' => $request->sympton_name
        ]);

        return response()->json(['code'=>200, 'message'=>'Post Created successfully'], 200);

    }
}
