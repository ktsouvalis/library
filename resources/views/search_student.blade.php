<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Αναζήτηση Μαθητή/Μαθήτριας</title>
</head>
<body>
    <a href="/">Αρχική</a><br><br>
    @auth
        <form action="" method="post">
            @csrf
            <label for="student_id">Κωδικός μαθητή</label>
            <input name="student_id" type="text" value="{{old('student_id')}}" required>
            @error('student_id')
                {{$message}}
            @enderror
            <br><br>
            <input type="submit" name="submit" value="Αναζήτηση">
        </form>
        <br><br>
        @isset($student)
            <p>{{$student->surname}}</p>
            <p>{{$student->name}}</p>
            <p>{{$student->class}}{{$student->sec}}</p>
            <a href="/profile/{{$student->id}}" target="_blank">Δανεισμοί μαθητή</a>
        @endisset
        @else
        <h3 style="color:red">Δεν έχετε δικαίωμα πρόσβασης στη σελίδα</h3>
        <p><a href="/">Συνδεθείτε</a></p>
    @endauth     
</body>
</html>