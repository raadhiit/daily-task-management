<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobList extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_jobList';


    protected $guarded = ['id_jobList'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id_project');
    }

    public function ljkh()
    {
        return $this->hasOne(ljkh::class);
    }
}