@extends('layouts.app')
@section('title', 'Results')
@section('content')
    <h2>Student List</h2>
    <h3>Class Average: {{number_format($average, 2,'.','')}}</h3>
        <div style="height: 300px; overflow-y: scroll; border: 1px solid #ccc;">
            <table>
                <thead>
                <tr><th>First Name</th><th>Last Name</th><th>Grade</th><th>Days Missed</th><th>Student Status</th></tr>
                </thead>
                <tbody>
                @foreach ($students as $item)
                    @php
                        $student = $item['student']
                    @endphp
                    <tr><td><a href="{{route('select',['studentId'=>$student->studentId])}}">{{ $student->firstName }}</a></td><td>{{ $student->lastName }}</td><td>{{ number_format($student->grade, 2,'.','') }}</td><td>{{ $item['days_absent'] }}</td>
                        <td style = "font-weight: bold; color: {{($item['failing'] || $item['truant']) ? 'red' : 'green'}}"> @if($item['truant'])
                                Student has missed more than 5 days consecutively.
                            @elseif($item['failing'])
                                Student currently has a failing grade.
                            @else
                                in good standing
                            @endif</td></tr>
                @endforeach
                </tbody>
            </table>
        </div>

    <a href="{{url('/createStudent')}}">
        <button type="button">
            Create Student
        </button>
    </a>
@endsection
