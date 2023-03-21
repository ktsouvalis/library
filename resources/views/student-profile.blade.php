<x-layout>
<body>
    <div class="badge bg-success text-wrap" style="width: 12rem;">
        {{$student->am}} {{$student->surname}} {{$student->name}} {{$student->f_name}} {{$student->class}}
    </div>
    <p></p>
    <div class="badge bg-warning text-wrap" style="width: 12rem;">
        <a href="/edit_student/{{$student->id}}" target="_blank">Επεξεργασία στοιχείων μαθητή</a>
    </div>
    <div class="badge bg-warning text-wrap" style="width: 12rem;">
        <a href="/add_loan/{{$student->id}}">Καταχώρηση δανεισμού</a>
    </div>
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
                    @else
                        <td>{{$loan->date_in}}</td>
                    @endif
                </tr>
            </form>
            @endforeach
        </table>
        <br>
    σύνολο ενεργών δανεισμών: <strong>{{$loans->whereNull('date_in')->count()}}</strong> από <strong>{{$loans->count()}}</strong>
    @endisset

</x-layout>