<x-layout>
    <div class="container">
    @include('menu')
    <div class="d-flex justify-content-end">
        <a href="/loans_dl" class="btn btn-danger bi bi-download"> Λήψη αρχείου δανεισμών </a>
    </div>
    @isset($loans)
        <table class="table table-striped table-hover table-light">
            <tr>
                <th>Κωδικός Βιβλίου</th>
                <th>Τίτλος</th>
                <th>Συγγραφέας</th>
                <th>Εκδότης</th>
                <th>Επίθετο μαθητή</th>
                <th>Όνομα μαθητή</th>
                <th>Τάξη μαθητή</th>
                <th>Ημερομηνία Δανεισμού</th>
                <th>Ημερομηνία Επιστροφής</th>
            </tr>
            @foreach($loans as $loan)
            <form action="/loans/return" method="post">
                @csrf
                <input type="hidden" name="loan_id" value={{$loan->id}}>
                <tr >  
                    <td>{{$loan->book->code}}</td>
                    <td><div class="badge bg-success text-wrap"><a href="/book_profile/{{$loan->book->id}}" style="color:white">{{$loan->book->title}}</a></div></td>
                    <td>{{$loan->book->writer}}</td>
                    <td>{{$loan->book->publisher}}</td>
                    <td><div class="badge bg-warning text-wrap"><a href="/student_profile/{{$loan->student->id}}" style="color:black">{{$loan->student->surname}}</a></div></td>
                    <td>{{$loan->student->name}}</td>
                    <td><strong>{{$loan->student->class}}</strong></td>
                    <td>{{$loan->date_out}}</td>
                    @if($loan->date_in==null)
                        <td><button class="bi bi-journal-arrow-down bg-primary" type="submit"> Επιστροφή</button></td>
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