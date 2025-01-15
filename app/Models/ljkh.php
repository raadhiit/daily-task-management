<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JobList;

class ljkh extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_ljkh';

    protected $guarded = [];

    public function jobList()
    {
        return $this->belongsTo(JobList::class);
    }
}
