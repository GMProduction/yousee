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
use Illuminate\Http\Request;

class ProjectDetailController extends Controller
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable()
    {
        $project = ProjectItem::with(['project', 'city', 'pic', 'item.type'])->where('project_id', request('q'));

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
        $qty                = request('qtyPic');
        if (request('id')) {
            $project = ProjectItem::find(request('id'));
            $project->update($data);
        } else {
            for ($x = 1; $x <= $qty; $x++) {
                $project = new ProjectItem();
                $project->create($data);
            }
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
            'city_id'    => 'required',
            'pic_id'     => 'required',
            'item_id'    => 'required',
            'is_lighted' => 'required',
        ]);
        $price                = request('vendor_price');
        $data['vendor_price'] = str_replace(',', '', $price);
        $data['available']    = request('statAvail') ?? request('dateAvail');

        if (request('id')) {
            $projectItem = ProjectItem::where([['item_id', request('item_id')], ['project_id', $id], ['id', '!=', request('id')]])->first();
            if ($projectItem) {
                return response()->json(
                    [
                        'msg' => 'Titik sudah dimasukkan',
                    ],
                    201
                );
            }
            $detail = ProjectItem::find(request('id'));
            $detail->update($data);
        } else {
            $projectItem = ProjectItem::where([['item_id', request('item_id')], ['project_id', $id]])->first();
            if ($projectItem) {
                return response()->json(
                    [
                        'msg' => 'Titik sudah dimasukkan',
                    ],
                    201
                );
            }
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

    public function delete($id)
    {
        ProjectItem::destroy($id);

        return 'success';
    }

    public function getDetailProject($id)
    {
        return ProjectItem::with(['city', 'pic', 'item'])->where('project_id', $id)->get();
    }

    public function savePrice($id)
    {
        $idD   = request('idD');
        $type  = request('type');
        $price = str_replace(',', '', request('price'));

        $project = null;
        if ($type) {
            $project = Project::find($id);
            $project->update(['total_price' => $price]);
        } else {
            $projectItem = ProjectItem::find($idD);
            $projectItem->update([
                'end_price' => $price,
            ]);
        }

        return response()->json(
            [
                'msg'  => 'berhasil',
                'data' => $project,
            ],
            200
        );
    }

    public function saveItemToProject()
    {
        DB::beginTransaction();
        try {
            $item = \request('item');
            $id   = \request('id');

            if (isset($item)) {
                foreach ($item as $i) {
                    $projectItem = ProjectItem::find($i);

                    $check = ProjectItem::where([['project_id', $id], ['item_id', $projectItem->item_id]])->first();
                    if ($check == null) {
                        ProjectItem::create([
                            'project_id'   => $id,
                            'city_id'      => $projectItem->city_id,
                            'pic_id'       => $projectItem->pic_id,
                            'item_id'      => $projectItem->item_id,
                            'vendor_price' => $projectItem->vendor_price,
                            'available'    => $projectItem->available,
                            'is_lighted'   => $projectItem->is_lighted,
                            'end_price'    => $projectItem->end_price,
                        ]);
                    }
                }
            }
            DB::commit();
            $code = 200;
            $msg  = 'Berhasil';
        } catch (\Exception $er) {
            DB::rollBack();
            $code = 500;
            $msg  = 'error : ' . $er->getMessage();
        }

        return response()->json(
            [
                'msg' => $msg,
                'data' => $id
            ],
            $code
        );
    }
}
