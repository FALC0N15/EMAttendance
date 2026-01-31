<?php

use App\Models\Attendance;
use Illuminate\Support\Facades\Route;


Route::get('/createStudent', function () {
    return view('home');
});

Route::post('/add', function (Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'fname' => 'required|string',
        'lname' => 'required|string',
        'lastDate' => 'required|date|before:today',
        'grade' => 'required|numeric|min:0|max:100',
    ]);

    $attendance = attendance::create([
        'firstName'=> $validated['fname'],
        'lastName'=> $validated['lname'],
        'grade'=> $validated['grade'],
        'last_attended_date'=> $validated['lastDate'],
    ]);

return response()->json([
   'success'=> true,
]);

});

Route::get('/next', function (Illuminate\Http\Request $request) {
    return redirect()->route('attendance');
});


route::get('/attendance', function () {
    $students = attendance::all()->map(function ($student) {
        $lastAttended = new DateTime($student->last_attended_date);
        $today = new DateTime('today');
        $interval = $lastAttended->diff($today);
        $daysAbsent = $interval->days;
        return [
            'student' => $student,
            'days_absent' => $daysAbsent,
            'truant' => $daysAbsent > 5,
            'grade'=> $student->grade,
            'failing' => $student->grade < 55,
        ];
    });
    $average = $students->avg('grade');
    return view('attendanceSheet', ['students' => $students, 'average' => $average]);
})->name('attendance');

route::get('/select/{studentId}', function ($studentId) {
$selectedStudent = attendance::findorfail($studentId);
return view('selectedStudent', ['selectedStudent' => $selectedStudent]);
})->name('select');

route::post('/update/{studentId}', function (Illuminate\Http\Request $request, $studentId) {
    $validated = $request->validate([
        'lastDate' => 'required|date|before:today',
        'grade' => 'required|numeric|min:0|max:100',
        ]);
    $selectedStudent = attendance::findorfail($studentId);
    $selectedStudent->update([
        'last_attended_date' => $validated['lastDate'],
        'grade' => $validated['grade'],
    ]);
    $selectedStudent->save();

    return response()->json([
        'success'=> true,
    ]);

})->name('update');

route::get('/', function () {
    $students = attendance::all()->map(function ($student) {
        $lastAttended = new DateTime($student->last_attended_date);
        $today = new DateTime('today');
        $interval = $lastAttended->diff($today);
        $daysAbsent = $interval->days;
        return [
            'student' => $student,
            'days_absent' => $daysAbsent,
            'truant' => $daysAbsent > 5,
            'grade'=> $student->grade,
            'failing' => $student->grade < 55,
        ];
    });
    $average = $students->avg('grade');
    return view('attendanceSheet', ['students' => $students, 'average' => $average]);
})->name('attendance');
