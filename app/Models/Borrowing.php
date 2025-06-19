<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $table = 'borrowings';

    protected $guarded = [];

    // relasi ke table tools
    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    // relasi ke table user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke table details
    public function details()
    {
        return $this->hasMany(BorrowingDetail::class);
    }
}
