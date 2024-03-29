<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectItem;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{

    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable()
    {
        if (\request('n')) {
            $project = Project::withCount('items')->where('id', '!=', \request('n'));
        } else {
            $project = Project::withCount('items');
        }

        return DataTables::of($project)->make(true);
    }

    /**
     * @return Application|Factory|View|JsonResponse
     */
    public function index()
    {
        if (\request()->method() == 'POST') {
            return $this->postData();
        }

        return view('admin.project.project', ['sidebar' => 'project']);
    }

    /**
     * @return JsonResponse
     */
    public function postData()
    {
        \request()->validate([
            'name'          => 'required',
            'client_pic'    => 'required',
            'request_date'  => 'required',
            'duration'      => 'required',
            'duration_unit' => 'required',
            //            'is_lighted'    => 'required',
            'description'   => '',
        ]);
        $data = \request()->all();

        $date                 = \DateTime::createFromFormat('d/m/Y', request('request_date'));
        $data['request_date'] = $date;
        $dProject             = null;
        if (request('id')) {
            $project = Project::find(request('id'));
            $project->update($data);
        } else {
            $project  = new Project();
            $dProject = $project->create($data);
        }
        //        $history = new HistoryController();
        //        $history->postHistory($dProject->id);

        return response()->json(
            [
                'msg'  => 'berhasil',
                'data' => $dProject ? $dProject->id : null,
            ],
            200
        );
    }

    public function indexDetailProject($id)
    {
        $data             = Project::with(['items.item', 'items.city', 'items.pic'])->findOrFail($id);
        $groupedCity      = $data->items->groupBy('city_id');
        $groupedPIC       = $data->items->groupBy('pic_id');
        $groupedCityValue = $groupedCity->values();
        $groupedPICValue  = $groupedPIC->values();

        return view('admin.project.detailproject', [
            'sidebar'     => 'project',
            'data'        => $data,
            'groupedCity' => $groupedCityValue,
            'groupedPIC'  => $groupedPICValue,
        ]);
    }

    /**
     * @param $id
     *
     * @return Application|Factory|View|string
     */
    public function indexBuatHarga($id)
    {
        $data = Project::findOrFail($id);

        return view('admin.project.formharga', ['sidebar' => 'project', 'data' => $data]);
    }

    public function delete($id)
    {
        Project::destroy($id);

        return 'success';
    }

    public function changeStatus(Request $request)
    {
        $id     = $request->id;
        $status = $request->status;

        $pesan = Project::findorfail($id);

        $updated = $pesan->update(
            [
                $pesan->status = $status,
            ]
        );

        if ($updated) {
            return response()->json("berhasil");
        } else {
            return response()->json("gagal");
        }
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function saveSettingPdf($id)
    {
        $project = Project::findorfail($id);

        $field = \request()->validate([
            'number_doc' => 'required',
            'to_name'    => 'required',
        ]);

        $project->update($field);

        return 'success';
    }


}
