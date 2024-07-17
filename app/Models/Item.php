<?php

namespace App\Models;

use App\Models\Checklist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
}
