<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Auth\Client as Authenticatable;
use Auth;
use Hash;
class Client extends Authenticatable
{
    use SoftDeletes, HasFactory;

    public $table = 'clients';

    protected $hidden = [
        'password',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        'student' => 'student',
        'teacher' => 'teacher',
        'driver'  => 'driver',
        'parent'  => 'parent',
    ];

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'type',
        'parent_id',
        'nationalid',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    public function classsections()
    {
        return $this->HasMany(ClassSection::class, 'teacher_id');
    }
    public function attendances()
    {
        return $this->HasMany(Attendance::class, 'teacher_id');
    }
    public function homeworks()
    {
        return $this->HasMany(Homework::class, 'teacher_id');
    }
}
