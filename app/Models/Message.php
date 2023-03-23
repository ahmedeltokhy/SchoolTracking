<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'messages';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'teacher_id',
        'student_id',
        'classsection_id',
        'content',
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

    public function student()
    {
        return $this->belongsTo(Client::class, 'student_id');
    }

    public function classsection()
    {
        return $this->belongsTo(ClassSection::class, 'classsection_id');
    }
}
