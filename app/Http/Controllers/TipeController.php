<?php

namespace App\Http\Controllers;

use App\Models\type;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TipeController extends Controller
{

    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable(){
        return DataTables::of(type::query())->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (\request()->isMethod('POST')){
            $field = \request()->validate([
                'name' => 'required',
                'icon' => 'required'
            ]);



            if (\request('id')){
                $type = type::find(\request('id'));

            }else{
                type::create($field);
            }

        }
        return view('admin.tipe', ['sidebar' => 'tipe']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
