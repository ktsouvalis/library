<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Δανεισμοί {{$student->surname}} {{$student->name}} </title>
</head>
<body>
    <p>{{$student->surname}}</p>
    <p>{{$student->name}}</p>
    <p>{{$student->class}}{{$student->sec}}</p>
    <br><br><br>
    @isset($loans)
        <table style="border: 1px solid black; text-align:center;width:80%">
            <tr>
                <th>Κωδικός Βιβλίου</th>
                <th>Τίτλος</th>
                <th>Συγγραφέας</th>
                <th>Εκδότης</th>
                <th>Ημερομηνία Δανεισμού</th>
                <th>Ημερομηνία Επιστροφής</th>
            </tr>
            {{$i=0}}
            @foreach($loans as $loan)
            <form action="/return_book" method="post">
                @csrf
                {{-- <input type="hidden" name="student_id" value={{$student->id}}> --}}
                <input type="hidden" name="loan_id" value={{$loan->id}}>
                <tr style="border: 1px solid black">  
                    <td>{{$loan->book->id}}</td>
                    <td>{{$loan->book->title}}</td>
                    <td>{{$loan->book->writer}}</td>
                    <td>{{$loan->book->publisher}}</td>
                    <td>{{$loan->date_out}}</td>
                    @if($loan->date_in==null)
                    <td><input type="submit" value="Επιστροφή"></td>
                    {{$i++;}}
                    @else
                    <td>{{$loan->date_in}}</td>
                    @endif
                </tr>
            </form>
            @endforeach
        </table>
        <br>
    σύνολο ενεργών δανεισμών: <strong>{{$i}}</strong> από <strong>{{$loans->count()}}</strong>
    @endisset
</body>
</html>