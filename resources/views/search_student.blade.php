<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Βιβιλιοθήκη</title>
</head>
<body>
    <a href="/">Αρχική</a><br>
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
        <br><br><br>
        @isset($books_loaned)
            <table style="border: 1px solid black; text-align:center;width:80%">
                <tr>
                    <th>Κωδικός Βιβλίου</th>
                    <th>Τίτλος</th>
                    <th>Συγγραφέας</th>
                    <th>Εκδότης</th>
                    <th>Ημερομηνία Δανεισμού</th>
                </tr>
                @foreach($books_loaned as $loan)
                <form action="/return_book" method="post">
                    @csrf
                    <input type="hidden" name="student_id" value={{$student->id}}>
                    <input type="hidden" name="loan_id" value={{$loan->id}}>
                    <tr style="border: 1px solid black">  
                        <td>{{$loan->book->id}}</td>
                        <td>{{$loan->book->title}}</td>
                        <td>{{$loan->book->writer}}</td>
                        <td>{{$loan->book->publisher}}</td>
                        <td>{{$loan->date_out}}</td>
                        <td><input type="submit" value="Επιστροφή"></td>
                    </tr>
                </form>
                @endforeach
            </table>
        @endisset
    @endisset
    @else
    <h3 style="color:red">Δεν έχετε δικαίωμα πρόσβασης στη σελίδα</h3>
    <p><a href="/">Συνδεθείτε</a></p>
    @endauth     
</body>
</html>