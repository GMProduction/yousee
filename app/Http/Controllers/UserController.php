<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable()
    {
        $user = User::withCount('items')->get();
        return DataTables::of($user)->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (\request()->isMethod('POST')) {
            return $this->create();
        }

        return view('admin.user', ['sidebar' => 'user']);
    }

    /**
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function create()
    {
        //

        if (\request('id')) {
            $field         = \request()->validate(
                [
                    'nama'     => 'required',
                    'email'    => 'required|string',
                    'no_hp'    => 'required',
                    'role'     => 'required',
                    'username' => 'required|string',
                ]
            );
            $fieldPassword = \request()->validate(
                [
                    'password' => 'required|confirmed',
                ]
            );
            $user          = User::find(\request('id'));
            $cekEmail      = User::where([['email', '=', \request('email')], ['id', '!=', \request('id')]])->first();
            if ($cekEmail) {
                return \request()->validate(
                    [
                        'email' => 'required|string|unique:users,email',
                    ]
                );
            }

            $cekUsername   = User::where([['username', '=', \request('username')], ['id', '!=', \request('id')]])->first();
            if ($cekUsername) {
                return \request()->validate(
                    [
                        'username' => 'required|string|unique:users,username',
                    ]
                );
            }
            if (strpos($fieldPassword['password'], '*') === false) {
                $password = Hash::make($fieldPassword['password']);
                Arr::set($field, 'password', $password);
            }
            $user->update($field);
        } else {
            $field = \request()->validate(
                [
                    'nama'     => 'required',
                    'email'    => 'required|string|unique:users,email',
                    'password' => 'required|confirmed',
                    'no_hp'    => 'required',
                    'role'     => 'required',
                    'username' => 'required|string|unique:users,username',
                ]
            );
            $password = Hash::make($field['password']);
            Arr::set($field, 'password', $password);
            $user = new User();
            $user->create($field);
        }

        return response()->json(
            [
                'msg' => 'berhasil',
            ],
            200
        );
    }

    public function updateActive(){
        try {
            $user = User::find(\request('id'));
            $active = false;
            if (\request('isActive') == "0"){
                $active = true;

            }
            $user->update([
                'isActive' => $active
            ]);
            $code = 200;
            $msg = 'Berhasil';
        }catch (\Exception $er){
            $code = 500;
            $msg = 'error : '.$er->getMessage();
        }
        return response()->json(
            [
                'msg' => $msg,
            ],
            $code
        );
    }

    /**
     * @return User|Collection
     */
    public function dataJson(){
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
