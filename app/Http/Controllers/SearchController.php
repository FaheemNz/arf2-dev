<?php

namespace App\Http\Controllers;

use App\Models\ArfForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index()
    {
        return view('search');
    }

    public function view(Request $request)
    {
        $request->validate([
            'search_main' => 'required|string|max:255'
        ]);

        $query = ArfForm::query();

        $query = $query->where('emp_id', '=', $request->search_main);
                       
        
        $query = $query->get();
        
        return view('search', [
            'results' => $query
        ]);
    }
    
    public function searchAsset(Request $request)
    {
        $table = $request->table;
        
        if(!is_string($table)){
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid Table Name'
            ]);
        }
        
        $result = DB::table($table)
                ->whereNull('arf_form_id')
                ->where('status', 'Active')
                ->select('id', DB::raw('asset_code AS text'))
                ->paginate(1000);
        
        $table = rtrim($table, 's');
        
        if(empty($result)){
            return response()->json([
                'success' => false,
                'message' => 'Asset is not available.',
                'type' => $table
            ]);    
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Asset is Available',
            'data'    => $result,
            'type'    => $table
        ]);
    }

    public function getBrands(Request $request)
    {
        $type = $request->input('type');

        if(!$type){
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid Asset Type'
            ]);
        }

        if(!in_array($type, ['Laptop', 'Tablet', 'Mobile', 'Desktop', 'Monitor', 'Sim'])){
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid Asset Type'
            ]);
        }

        $brands = call_user_func(array('\\App\\Models\\' . $type, 'getBrands'));

        return response()->json([
            'success' => true,
            'message' => 'Brands retrieved Successfully',
            'data'    => $brands
        ]);
    }
}
