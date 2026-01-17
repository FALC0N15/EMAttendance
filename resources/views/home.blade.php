@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <form method="POST" action="/add" id="addToAttendance">
        @csrf

        <div>
            <label for="fname">First Name</label>
            <input type="text" name="fname" id="fname" value ="{{old('fname')}}" required>
        </div>

        <div>
            <label for="lname">Last Name</label>
            <input type="text" name="lname" id="lname" value ="{{old('lname')}}" required>
        </div>

        <div>
            <label for="lastDate">Date of Last Class Attended</label>
            <input type="date" name="lastDate" id="lastDate" value ="{{old('lastDate')}}" required>
        </div>

        <div>
            <label for="grade">Current Grade</label>
            <input type="number" name="grade" id="grade"  value ="{{old('grade')}}" required>
        </div>
        <p id="successMessage" style="color:green; display:none;"></p>
        <p id="formError" style="color:red; display:none;"></p>
        <button type="button" id = "saveBtn">Save</button>

    </form>
    <a href="{{ url('/attendance') }}">
        <button type="button" id="nextBtn">Next</button>
    </a>
    <script>
        (function(){
            const form = document.getElementById('addToAttendance');
            const firstName = document.getElementById('fname');
            const lastName = document.getElementById('lname');
            const currGrade = document.getElementById('grade');
            const lastDate = document.getElementById('lastDate');
            const err = document.getElementById('formError');
            const btn = document.getElementById('saveBtn');
            const nextBtn = document.getElementById('nextBtn');
            const success = document.getElementById('successMessage');

            function formValidation(){
                const fName = firstName.value;
                const lName = lastName.value;
                const currentGrade = Number(currGrade.value)
                const lastChangeStr = lastDate.value;
                const lastChangeVal = new Date(lastDate.value);
                const today = new Date();
                today.setHours(0,0,0,0);

                err.textContent = '';
                err.style.display = 'none';
                btn.disabled = false;
                nextBtn.disabled = false;

                if(!fName || !lName || !lastChangeStr || !currentGrade){
                    err.textContent = 'All fields are required.';
                    err.style.display = 'block';
                    btn.disabled = true
                    nextBtn.disabled = true;
                    return false;
                }
                if(currentGrade >100 || currentGrade <0){
                    err.textContent = "the current grade cannot be greater than 100% or less than 0%"
                    err.style.display = 'block';
                    btn.disabled = true;
                    nextBtn.disabled = true;
                    return false;
                }
                if(lastChangeVal >= today){
                    err.textContent = 'Date of previous attendance must be valid and in the past'
                    err.style.display = 'block';
                    btn.disabled = true;
                    nextBtn.disabled = true;
                    return false;
                }
                return true;
            }
            btn.addEventListener('click', async function () {

                const formData = new FormData(form);

                const response = await fetch('/add', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });

                if (!response.ok) {
                    err.textContent = 'Failed to save student.';
                    err.style.display = 'block';
                    return;
                }

                success.textContent = 'Student saved successfully!';
                success.style.display = 'block';
            });

            form.addEventListener('submit', function(e) {
                if (!formValidation()) {
                    e.preventDefault();
                }
            });

            // Run dynamically on input/change
            [firstName, lastName, currGrade, lastDate].forEach(el => {
                el.addEventListener('input', formValidation);
                el.addEventListener('change', formValidation);
            });
        })();
    </script>
@endsection
