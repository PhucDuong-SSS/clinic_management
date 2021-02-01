<?php

namespace App\Http\Repositories;
use App\Models\Setting;

class SettingAppRepository extends BaseRepository implements RepositoryInterface
{
    protected $settingApp;
    public function __construct(Setting $settingApp)
    {
        $this->settingApp = $settingApp;
    }

    function getAll()
    {
        return $this->settingApp->get();
    }

    function findById($id)
    {
        return $this->settingApp->findOrFail($id);
    }

    function save($obj)
    {
        $obj->save();
    }

    function delete($obj)
    {
        $obj->delete();
    }

}
