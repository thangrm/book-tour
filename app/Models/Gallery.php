<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;
use Yajra\DataTables\DataTables;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['tour_id', 'name'];

    function getImagesByTourId($tourId)
    {
        return $this->where('tour_id', $tourId)->get();
    }
}
