<?php

namespace App\Models;

class Article extends BaseModel
{
    protected $table = "articles";

    protected $fillable = [
        "name",
        "price",
        "description",
        "creator_id",
        "created_at"
    ];

    public function user(){
        return $this->belongsTo(User::class, "creator_id");
    }

}
