<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getList(){
        return $this->userService->getList();
    }

    public function create(UserRequest $request){
        return $this->userService->create($request);
    }

    public function edit($id,Request $request){
        return $this->userService->edit($id,$request);
    }
}
