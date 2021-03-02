<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingAppRequest;
use App\Http\Services\SettingAppService;
use App\Models\Setting;
use Illuminate\Http\Request;



class SettingAppController extends Controller
{
    protected $settingAppService;

    public function __construct(SettingAppService $settingAppService)
    {
        $this->settingAppService = $settingAppService;
    }

    public function index()
    {
        $settingApps = Setting::all();

        return view('settingApplication.list',compact('settingApps'));
    }


    public function create()
    {
        return view('settingApplication.add');
    }

    public function store(SettingAppRequest $request)
    {
        $this->settingAppService->add($request);

        $message = 'Thêm thành công!';

        return redirect()->route('setting.index')->with('success',$message);
    }

    public function edit($id)
    {
        $settingApps = $this->settingAppService->findById($id);

        return view('settingApplication.edit',compact('settingApps'));
    }


    public function update(SettingAppRequest $request, $id)
    {
        $settingApps = $this->settingAppService->findById($id);

        $this->settingAppService->update($request,$settingApps);

        $message = 'Sửa thành công!';

        return redirect()->route('setting.index')->with('success',$message);

    }


    public function destroy($id)
    {
        $settingApp = $this->settingAppService->findById($id);

        $settingApp->delete();

        $message = 'Xóa thành công!';

        return redirect()->route('setting.index')->with('success',$message);
    }
}
