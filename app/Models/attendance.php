<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model{
    //use HasFactory;
    protected $table = '_attendance_';
    protected $primaryKey = 'studentId';
    protected $fillable = ['firstName', 'lastName', 'grade', 'last_attended_date'];
}

