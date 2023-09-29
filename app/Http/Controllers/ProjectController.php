<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{

    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable(){
        $project = Project::query();
        return DataTables::of($project)->make(true);

    }

    /**
     * @return Application|Factory|View|JsonResponse
     */
    public function index()
    {
        if (\request()->method() == 'POST'){
            return $this->postData();
        }
        return view('admin.project.project', ['sidebar' => 'project']);
    }

    /**
     * @return JsonResponse
     */
    public function postData()
    {
        $data = \request()->validate([
            'name'          => 'required',
            'client_pic'    => 'required',
            'request_date'  => 'required',
            'duration'      => 'required',
            'duration_unit' => 'required',
//            'is_lighted'    => 'required',
            'description'   => '',
        ]);
        $date = \DateTime::createFromFormat('d/m/Y',request('request_date'));
        $data['request_date'] = $date;

        if (request('id')){
            $project = Project::find(request('id'));
            $project->update($data);
        }else{
            $project = new Project();
            $project->create($data);

        }

        $history = new HistoryController();
        $history->postHistory($project->id);

        return response()->json(
            [
                'msg' => 'berhasil',
            ],
            200
        );
    }




    public function indexDetailProject($id)
    {
        $data = Project::findOrFail($id);
        return view('admin.project.detailproject', ['sidebar' => 'project', 'data' => $data]);
    }

    public function indexBuatHarga()
    {
        return view('admin.project.formharga', ['sidebar' => 'project']);
    }
}
