<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'position',
        'division_id',
        'image',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
