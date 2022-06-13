<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Models\type;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;

class TipeController extends CustomController
{

    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable(){
        return DataTables::of(type::query())->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (\request()->isMethod('POST')){
            $field = \request()->validate([
                'name' => 'required',
            ]);

            $image = \request('icon');
            if ($image){
                $image     = $this->generateImageName('icon');
                $stringImg = '/images/type/'.$image;
                $this->uploadImage('icon', $image, 'imageType');
                Arr::set($field, 'icon', $stringImg);
            }

            if (\request('id')){
                $type = type::find(\request('id'));
                if ($image && $type->icon){
                    if (file_exists('../public'.$type->icon)) {
                        unlink('../public'.$type->icon);
                    }
                }
                $type->update($field);
            }else{
                type::create($field);
            }
            return response()->json(
                [
                    'msg' => 'berhasil',
                ],
                200
            );
        }
        return view('admin.tipe', ['sidebar' => 'tipe']);
    }
}
