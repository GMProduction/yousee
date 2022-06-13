<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    //

    public function postHistory($item)
    {
        History::create(
            [
                'user_id' => auth()->id(),
                'item_id' => $item
            ]
        );

        return 'success';
    }

    public function getHistory($id)
    {
        $his = History::where('item_id',$id)->orderBy('created_at', 'DESC')->get();

        return $his;
    }

}
