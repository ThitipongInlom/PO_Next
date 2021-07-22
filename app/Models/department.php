<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    public $table = "departments";

    protected $fillable = [
        'department_code',
        'department_name_th',
        'department_name_en',
        'status',
        'is_deleted',
        'by_deleted',
        'date_deleted'
    ];

    protected $primaryKey = 'department_id';
}
