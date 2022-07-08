<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Exports\ArrayExport;
use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getList(Request $request)
    {
        return $this->userService->getList($request);
    }

    public function find($id)
    {
        return $this->userService->find($id);
    }

    public function create(UserRequest $request)
    {
        return $this->userService->create($request);
    }

    public function edit($id, Request $request)
    {
        return $this->userService->edit($id, $request);
    }

    public function delete($id)
    {
        return $this->userService->delete($id);
    }

    public function deleteMulti(Request $request)
    {
        return $this->userService->deleteMulti($request);
    }

    public function export(Request $request)
    {
        ini_set('max_execution_time', 600);
        return (new UsersExport($request))->download('users.xlsx');
        //return (new ArrayExport($request->options))->download('users.xlsx');
    }
}
