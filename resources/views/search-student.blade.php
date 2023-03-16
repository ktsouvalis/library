<x-layout>
<body>
    <a href="/">Αρχική</a><br><br>
    <div class="container">
    @auth
    
        <form action="" method="post">
            @csrf
            <label for="student_id">Κωδικός μαθητή: </label>
            <input name="student_id" type="number" value="{{old('student_id')}}" required>
            @error('student_id')
                {{$message}}
            @enderror
            <br><br>
            <button type="submit" class="btn btn-primary">Αναζήτηση</button>
        </form>
        <br><br>
        @isset($student)
        {{-- <div class="badge bg-success text-wrap" style="width: 8rem;">
            <p>{{$student->surname}}</p>
            <p>{{$student->name}}</p>
            {{$student->class}}{{$student->sec}}
        </div> --}}
        <div class="badge bg-warning text-wrap" style="width: 8rem;">
            {{$student->surname}} {{$student->name}}, {{$student->class}}{{$student->sec}}
        </div>
           <br> <a href="/profile/{{$student->id}}" target="_blank">Δανεισμοί μαθητή</a>
        @endisset
    @else
        <h3 style="color:red">Δεν έχετε δικαίωμα πρόσβασης στη σελίδα</h3>
        <p><a href="/">Συνδεθείτε</a></p>
    @endauth
    </div>
</x-layout>