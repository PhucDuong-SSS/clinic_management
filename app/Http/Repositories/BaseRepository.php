<?php


namespace App\Http\Repositories;


class BaseRepository
{
    function save($obj)
    {
        $obj->save();
    }

    function delete($obj)
    {
        $obj->delete();
    }
}
