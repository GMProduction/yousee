<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectItem;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProjectDetailController extends Controller
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable()
    {
        $project = ProjectItem::with(['project', 'city', 'pic', 'item'])->where('project_id', request('q'));

        return DataTables::of($project)->make(true);

    }

    /**
     * @return Application|Factory|View|JsonResponse|null
     */
    public function indexTambahProject()
    {
        $param = request('q');
        if (request()->method() == 'POST') {
            if (request('action')) {
                return $this->postTitik($param);
            } else {
                return $this->postData();
            }
        }
        $project = [];
        if ($param) {
            $project = Project::find($param);
        }

        return view('admin.project.tambahproject', ['sidebar' => 'project', 'data' => $project]);
    }

    /**
     * @return JsonResponse
     */
    public function postData()
    {
        $data               = \request()->validate([
            'city_id' => 'required',
            'pic_id'  => 'required',
        ]);
        $data['project_id'] = request('q');

        if (request('id')) {
            $project = ProjectItem::find(request('id'));
            $project->update($data);
        } else {
            $project = new ProjectItem();
            $project->create($data);

        }
//
//        $history = new HistoryController();
//        $history->postHistory($project->id);

        return response()->json(
            [
                'msg' => 'berhasil',
            ],
            200
        );
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function postTitik($id)
    {
        $data                 = request()->validate([
            'city_id' => 'required',
            'pic_id'  => 'required',
            'item_id' => 'required',
        ]);
        $data['vendor_price'] = request('vendor_price');
        if (request('id')) {
            $detail = ProjectItem::find(request('id'));
            $detail->update($data);
        } else {
            $data['project_id'] = $id;
            $detail             = new ProjectItem();
            $detail->create($data);
        }

        return response()->json(
            [
                'msg' => 'berhasil',
            ],
            200
        );
    }

    public function getCountCity($id)
    {
        return DB::table('project_items')
                 ->selectRaw('cities.name,count(project_items.id) as count')
                 ->join('cities', 'cities.id', '=', 'project_items.city_id')
                 ->where('project_items.project_id', '=', $id)
                 ->groupBy('cities.id')
                 ->get();
    }

    public function getCountPIC($id)
    {
        return DB::table('project_items')
                 ->selectRaw('users.nama,count(project_items.id) as count')
                 ->join('users', 'users.id', '=', 'project_items.pic_id')
                 ->where('project_items.project_id', '=', $id)
                 ->groupBy('users.id')
                 ->get();
    }


    public function delete($id){
        ProjectItem::destroy($id);
        return 'success';
    }
}
