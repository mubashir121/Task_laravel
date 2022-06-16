<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objekts extends Model
{
    use HasFactory;
    
    public static $objekt_type_codes = [
        'HB'=>'Hallenbad',
        'FB'=>'Freibad',
        'HFB'=>'Hallen-Freibad',
        //'DT'=>'Dachterasse'
    ];

    public static $objekt_categories = [
        'KOM' => 'Kommunal',
        'PB'=>'Privat',
        'HOT'=>'Hotel'
    ];

    protected $fillable = [
        'name' ,
        'website' ,
        'category',
        'street',
        'city',
        'postal_code' ,
        'country_code',
        'longitude',
        'latitude' ,
        'total_water_surface',
        'objekt_type_code' ,
        'order' ,
        'de_description' ,
        'en_description' ,
        'fr_description',
        'note',
        'created_at',
        'updated_at'
    ];

}
