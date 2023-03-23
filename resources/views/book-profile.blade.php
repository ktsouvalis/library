<x-layout>
    <div class="container">
<body>
    <div class="badge bg-success text-wrap" style="width: 12rem;">
        {{$book->code}}, {{$book->title}}, <i>{{$book->writer}}</i>, {{$book->publisher}}
    </div>
    <p></p>
    {{-- <div class="badge bg-warning text-wrap" style="width: 12rem;">
        <a href="/edit_student/{{$student->id}}" target="_blank">Επεξεργασία στοιχείων μαθητή</a>
    </div> --}}
    @if($book->available)
        <div class="badge bg-warning text-wrap" style="width: 12rem;">
            <a href="">Καταχώρηση δανεισμού</a>
        </div>
    @else
        <div class="alert alert-danger fade show" role="alert">
            <strong>Το βιβλίο δεν είναι διαθέσιμο για δανεισμό</strong>
        </div>
    @endif
    <br><br><br>
    

    @isset($loans)
        <table class="table table-striped table-hover table-light">
            <tr>
                <th>Επίθετο</th>
                <th>Όνομα</th>
                <th>Τάξη</th>
                <th>Ημερομηνία Δανεισμού</th>
                <th>Ημερομηνία Επιστροφής</th>
            </tr>
            @foreach($loans as $loan)
            <form action="/loans/return" method="post">
                @csrf
                {{-- <input type="hidden" name="student_id" value={{$student->id}}> --}}
                <input type="hidden" name="loan_id" value={{$loan->id}}>
                <tr >  
                    <td>{{$loan->student->surname}}</td>
                    <td>{{$loan->student->name}}</td>
                    <td>{{$loan->student->class}}</td>
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
</div>
</x-layout>