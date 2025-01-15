<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_project';

    protected $guarded = ['id_project'];

    public function jobList()
    {
        return $this->hasMany(JobList::class);
    }

}