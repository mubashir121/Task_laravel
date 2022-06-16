<?php

namespace App\Services;

use App\Helpers\Helpers;
use App\Models\Objekts;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class YajraDataTableService
{
 public static function ProjektTable(){

      $references = Objekts::orderBy('id', 'desc')
            ->when(request()->has('category') && request()->filled('category'), function ($q){
                $q->where('category', request()->category);
            })
            ->when(request()->has('objekt_type') && request()->filled('objekt_type'), function ($q){
                $q->where('objekt_type_code', request()->objekt_type);
            });


        return DataTables::of($references)
            ->addColumn('objekt_name', function($row){
                return "<div class='row'>" .
                    "<div class='col-sm-4 g-0 pe-50'>" .
                    "</div>" .
                    "<div class='col-sm-8 pt-25 g-0'>" .
                    "<a class='text-dark' href='". route('edit', $row->id) ."'>" .
                    "<b>" . $row['name'] ."</b>" .
                    "<span class='text-muted ms-25 font-small-2 d-block'>" .
                    "". $row['city']."" .
                    "</span>" .
                    "</a>" .
                    "</div>" .
                    "</div>";
            })
            ->addColumn('country', function($row){
                return  !empty($row->country) ? __('countries.'.$row->country?->name) : '';
            })
            ->addColumn('city_name', function($row){
                $country = !empty($row->country) ? __('countries.'.$row->country?->name) : '';
                return $row['city'] . "<div class='text-muted'>" . $country . "</div>";
            })
            ->addColumn('action', function($row){
                return view('pages.action', ['reference' => $row])->render();
            })
            ->rawColumns(['action','objekt_name','projekt_types','updated_at','competence','country','city_name'])
            ->make(true);
    }
}

?>