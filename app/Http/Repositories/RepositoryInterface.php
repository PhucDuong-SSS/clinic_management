<?php


namespace App\Http\Repositories;


interface RepositoryInterface
{
    function getAll();
    function findById($id);
    function save($obj);
    function delete($obj);
}
