<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowingDetail extends Model
{
    protected $table = 'borrowing_details';
    protected $guarded = [];

    // relasi ke table tools
    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}
