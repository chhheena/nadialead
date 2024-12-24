<?php

namespace App\Http\Controllers\User;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    use ApiResponse;

    protected $userService;

    public function __construct(UserService $userService = null)
    {
        $this->userService = $userService;
    }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
        */
        public function index(Request $request){

            try {
                $responseArr = [];
                $inputs = $request->all();
                $users = new UserCollection($this->userService->getList($inputs));
                $responseArr = $users->response()->getData(true);
                $responseArr['message'] = 'Users fetched successfully.';
                return $this->successResponse($responseArr);
            } catch (\Exception $e) {
                Log::error('Users fetched_api', ['error' => $e->getMessage()]);
                report($e);
                return $this->failResponse();
            }
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Resquest $request
         * @return \Illuminate\Http\Response
        */
        public function store(Request $request)
        {
            dd($request->all());
            $responseArr = [];
            $inputs = $request->all();
            try {
                $responseArr['data'] = $this->userService->store($inputs);

                $responseArr['message'] = 'User Created Successfully.';
                return $this->successResponse($responseArr);
            } catch (\Exception $e) {
                Log::error('User store api', ['error' => $e->getMessage()]);
                report($e);
                return $this->failResponse();
            }

        }

        /**
         * Store a newly created resource in storage.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
        */
        public function show($id) {
            try {
                $responseArr = [];
                $responseArr['data']['row'] = new UserResource($this->userService->show($id));
                $responseArr['data']['team'] = User::select('id','name')->role('team')->get();
                $responseArr['message'] = 'User fetched Successfully.';
                return $this->successResponse($responseArr);
            } catch (\Exception $e) {
                Log::error('User fetched api', ['error' => $e->getMessage()]);
                report($e);
                return $this->failResponse();
            }
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Resquest $request
         * @param int $id
         * @return \Illuminate\Http\Response
        */
        public function update(Request $request , $id)
        {
            $responseArr = [];
            $inputs = $request->only('id','name','email','role','parent_id','password');
            //$inputs = $request->all();
            dd($inputs);

            try {
                $responseArr['data'] = $this->userService->update($inputs,$id);
                $responseArr['message'] = 'User Updated Successfully.';
                return $this->successResponse($responseArr);
            } catch (\Exception $e) {
                Log::error('User update api', ['error' => $e->getMessage()]);
                report($e);
                return $this->failResponse();
            }
        }

}
