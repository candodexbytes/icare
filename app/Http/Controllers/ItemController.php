<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use PDF;

class ItemController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdfview(Request $request)
    {
        $items = DB::table("maintenance_fee")->get();
        view()->share('items',$items);

        if($request->has('download')){
            $path = base_path();
            $filename = $path.'\assets\pdf\pdfview'.time().'.pdf';
            

            $pdf = PDF::loadView('admin.pdfview')->save($filename);
            return true;
        }

        return view('admin.pdfview');
    }
}