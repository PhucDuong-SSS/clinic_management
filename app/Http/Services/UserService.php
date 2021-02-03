<?php


namespace App\Http\Services;


use App\Http\Repositories\UserRepository;

class UserService implements ServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    function getAll()
    {
        return $this->userRepository->getAll();
    }

    function findById($id)
    {
        return $this->userRepository->findById($id);
    }

    function add($request, $obj = null)
    {
        // TODO: Implement add() method.
    }

    function delete($obj)
    {
        // TODO: Implement delete() method.
    }

    function update($request, $obj = null)
    {
    }
}
