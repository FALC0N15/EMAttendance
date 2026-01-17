<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model{
    use HasFactory;
    protected $table = '_attendance_';
    protected $fillable = ['firstName', 'lastName', 'Grade', 'last_attended_date'];
}

