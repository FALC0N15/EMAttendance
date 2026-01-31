@extends('layouts.app')
@section('title', 'Results')
@section('content')
    <form method="POST" action="/update/{{$selectedStudent->studentId}}" id="updateStudent">
        @csrf
<h2>{{$selectedStudent->firstName}}, {{$selectedStudent->lastName}}'s report</h2>
    <table>
        <thead>
    <tr><th>Current Grade Average</th></tr>
        </thead>
        <tr><td><b>{{ number_format($selectedStudent->grade, 2,'.','') }}</b></td></tr>
    </table>
<div>
    <label for="lastDate">Update Date of Last Class Attended</label>
    <input type="date" name="lastDate" id="lastDate" value ="{{old('lastDate')}}" required>
</div>

<div>
    <label for="grade">Update Current Grade Average</label>
    <input type="number" name="grade" id="grade"  value ="{{old('grade')}}" required>
</div>
<p id="successMessage" style="color:green; display:none;"></p>
<p id="formError" style="color:red; display:none;"></p>

<button type="button" id = "saveBtn">Update</button>
    </form>
<a href="{{url('/attendance')}}">
    <button type="button">
        Back To Attendance List
    </button>
</a>
    <script>
        ( function() {
            const form = document.getElementById('updateStudent');
                const currGrade = document.getElementById('grade');
                const lastDate = document.getElementById('lastDate');
                const err = document.getElementById('formError');
                const btn = document.getElementById('saveBtn');
                const success = document.getElementById('successMessage');
                function formValidation() {
                    const currentGrade = Number(currGrade.value);
                    const testCurrGrade = currGrade.value;
                    const lastChangeStr = lastDate.value;
                    const lastChangeVal = new Date(lastDate.value);
                    const today = new Date();
                    today.setHours(0,0,0,0);

                    err.textContent = '';
                    err.style.display = 'none';
                    btn.disabled = false;

                    if (!lastChangeStr || testCurrGrade ==='') {
                        err.textContent = 'All fields are required.';
                        err.style.display = 'block';
                        btn.disabled = true
                        return false;
                    }
                    if (currentGrade > 100 || currentGrade < 0) {
                        err.textContent = "The current grade cannot be greater than 100% or less than 0%"
                        err.style.display = 'block';
                        btn.disabled = true;
                        return false;
                    }
                    if (lastChangeVal >= today) {
                        err.textContent = 'Date of previous attendance must be valid and in the past'
                        err.style.display = 'block';
                        btn.disabled = true;
                        return false;
                    }
                    return true;
                }
                btn.addEventListener('click', async function () {

                    const formData = new FormData(form);
                    const formUpdateUrlTemplate = "{{ route('update', ':studentId') }}";
                    const studentId = {{$selectedStudent->studentId}};
                    const formUpdateUrl = formUpdateUrlTemplate.replace(':studentId', studentId);
                    console.log(formUpdateUrl)
                    const response = await fetch(formUpdateUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        err.textContent = 'Failed to update student.';
                        err.style.display = 'block';
                        return;
                    }

                    success.textContent = 'Student updated successfully!';
                    success.style.display = 'block';
                });

                form.addEventListener('submit', function(e) {
                    if (!formValidation()) {
                        e.preventDefault();
                    }
                });

                // Run dynamically on input/change
                [currGrade, lastDate].forEach(el => {
                    el.addEventListener('input', formValidation);
                    el.addEventListener('change', formValidation);
                });
            })();
    </script>
@endsection
