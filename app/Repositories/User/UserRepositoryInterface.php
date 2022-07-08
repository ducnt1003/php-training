<?php
namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getListWithRole($whereLike, $orderBy);
    public function getUserWithRole($id);
    public function deleteAllUser();
}
