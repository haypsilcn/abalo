<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AbTestData extends Model
{
    //use HasFactory;
    function ab_testdata_all(): Collection
    {
        return DB::table("ab_testdata")->get();
    }
}
