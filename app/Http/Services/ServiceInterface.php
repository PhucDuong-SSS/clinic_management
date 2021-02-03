<?php


namespace App\Http\Services;


interface ServiceInterface
{
    function getAll();
    function findById($id);
    function add($request, $obj = null);
    function delete($obj);
    function update($request, $obj = null);
}
