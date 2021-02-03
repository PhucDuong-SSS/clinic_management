<?php

namespace App\Http\Controllers;

use App\Http\Requests\SymptonRequest;
use App\Http\Services\SymtonService;
use Illuminate\Http\Request;
use App\Models\Sympton;
use Illuminate\Support\Facades\Validator;

class SymptonController extends Controller
{
    protected $symtonService;

    public function __construct(SymtonService $symtonService)
    {
        $this->symtonService = $symtonService;
    }

    // Phúc
    public function addSympton(SymptonRequest $request)
    {

            Sympton::create( [
            'sympton_name' => $request->sympton_name
        ]);

        return response()->json(['code'=>200, 'message'=>'Post Created successfully'], 200);

    }

    public function index()
    {
        $symptons = $this->symtonService->getAll();
        return view('sympton.listSympton',compact('symptons'));
    }

    public function store(Request $request)
    {
        $symptons = $this->symtonService->add($request);

        $message = 'Thêm thành công!';

        $symptons = Sympton::all();

        return response()->json(['sympton'=>$symptons,'success'=>$message]);
    }

    public function edit($id)
    {
        $symptons = $this->symtonService->findById($id);
        return response()->json(['symptons'=>$symptons]);
    }

    public function update(Request $request, $id)
    {
        $symptons = $this->symtonService->findById($id);

        $this->symtonService->update($request,$symptons);
        $message = 'Sửa thành công';

        $symptons = Sympton::all();

        return response()->json(['sympton'=>$symptons,'success'=>$message]);
    }
    public function destroy($id)
    {
        $symptons = $this->symtonService->findById($id);
        $symptons->delete();
        $message = 'Xóa thành công';
        $symptons = Sympton::all();
     
        return response()->json(['sympton'=>$symptons,'success'=>$message]);
    }



}
