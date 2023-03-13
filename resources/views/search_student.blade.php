<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Βιβιλιοθήκη</title>
</head>
<body>
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
        
        <h4 style="color:blue">{{$student->surname}}</h4>
        <h4 style="color:blue">{{$student->name}}</h4>
        <h4 style="color:blue">{{$student->class}}{{$student->sec}}</h4>
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
                <form action="/return" method="post">
                    <input type="hidden" name="book_id" value={{$loan->book->id}}>
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