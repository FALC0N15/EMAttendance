@extends('layouts.app')
@section('title', 'Results')
@section('content')
    <h2>Student List</h2>
    @foreach($students as $item)
        @php
        $student = $item['student']
        @endphp
    <p>
        <strong> First Name:</strong>{{$student->firstName}}<br>
        <strong> Last Name:</strong>{{$student->lastName}}<br>
        <strong> Grade:</strong>{{$student->grade}}<br>
        <strong> Days Missed:</strong>{{$item['days_absent']}}<br>
    </p>

    <p style = "font-weight: bold; color: {{($item['failing'] || $item['truant']) ? 'red' : 'green'}}">
        @if($item['truant'])
            Student has missed more than 5 days consecutively.
        @elseif($item['failing'])
            Student currently has a failing grade.
        @else
            in good standing
        @endif
    </p>
    @endforeach
    <a href="{{url('/')}}">
        <button type="button">
            Back
        </button>
    </a>
@endsection
