<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSection extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'class_sections';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'subject',
        'teacher_id',
        'notes',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function teacher()
    {
        return $this->belongsTo(Client::class, 'teacher_id');
    }
    // public function today_attendance()
    // {
    //     return $this->HasMany(Client::class, 'teacher_id');
    // }

    public function students()
    {
        return $this->belongsToMany(Client::class);
    }
}
