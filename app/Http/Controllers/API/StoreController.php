<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    //

    public function add(Request $request){

        try {

            $store = new Store([
                'name' => $request->name,
                'image' => '',
                'qty' => $request->qty,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell
            ]);

            $store->save();

           

                $success = true;
                $message = 'ບັນທຶກຂໍ້ມູນສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {

            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

    }

    public function index(){

        // $store = Store::orderBy('id','asc')->get();
        // return $store;
        $PerPage = \Request::get('perpage');
        $Sort = \Request::get('sort');
        $search = \Request::get('search');

        $store = Store::orderBy('id',$Sort)
        ->where(
            function($query) use ($search){
                $query->where('name','LIKE',"%{$search}%")
                ->orWhere('price_buy','LIKE',"%{$search}%");
            }
        )
        ->paginate($PerPage)
        ->toArray();

        return array_reverse($store);


    }
}
