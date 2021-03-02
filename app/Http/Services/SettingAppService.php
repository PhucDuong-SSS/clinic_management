<?php

namespace App\Http\Services;

use App\Http\Repositories\SettingAppRepository;

use App\Models\Setting;

class SettingAppService implements ServiceInterface
{
    protected $settingAppRepo;

    public function __construct(SettingAppRepository $settingAppRepo)
    {
        $this->settingAppRepo = $settingAppRepo;
    }

    public function getAll()
    {
       return $this->settingAppRepo->getAll();
    }

    public function findById($id)
    {
       return $this->settingAppRepo->findById($id);
    }

    public function add($request, $obj = null)
    {
        $obj = new Setting();
        $obj->name_doctor = $request->name_doctor;
        $obj->degree = $request->degree;
        $obj->name_clinic = $request->name_clinic;
        $obj->phone = $request->phone;
        $obj->address = $request->address;
        $this->settingAppRepo->save($obj);
    }

    public function delete($obj)
    {
        $this->settingAppRepo->delete($obj);
    }

    public function update($request, $obj = null)
    {
        $obj->fill($request->all());
        $this->settingAppRepo->save($obj);
    }
}
