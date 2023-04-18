<x-layout>
    <div class="container">
    @include('menu')
    <div class="d-flex justify-content-end">
        <a href="/loans_dl" class="btn btn-danger bi bi-download"> Λήψη αρχείου δανεισμών </a>
    </div>
    @isset($loans)
        <table id="dataTable" class="display table table-sm table-striped table-hover">
            <thead>
            <tr>
                <th>Κωδικός Βιβλίου</th>
                <th>Τίτλος</th>
                <th>Συγγραφέας</th>
                <th>Εκδότης</th>
                <th>Επώνυμο μαθητή</th>
                <th>Όνομα μαθητή</th>
                <th>Τάξη μαθητή</th>
                <th>Ημερομηνία Δανεισμού</th>
                <th>Ημερομηνία Επιστροφής</th>
            </tr>
            </thead>
            <tbody>
            @foreach($loans as $loan)
           
                <tr >  
                    <td>{{$loan->book->code}}</td>
                    <td><div class="badge bg-success text-wrap"><a href="/book_profile/{{$loan->book->id}}" style="color:white; text-decoration:none;">{{$loan->book->title}}</a></div></td>
                    <td>{{$loan->book->writer}}</td>
                    <td>{{$loan->book->publisher}}</td>
                    <td><div class="badge bg-warning text-wrap"><a href="/student_profile/{{$loan->student->id}}" style="color:black; text-decoration:none;">{{$loan->student->surname}}</a></div></td>
                    <td>{{$loan->student->name}}</td>
                    @if($loan->student->class <> '0')
                        <td><strong>{{$loan->student->class}}</strong></td>
                    @else
                        <td style="color:red"> ΑΠΟΦΟΙΤΟΣ </td>
                    @endif
                    <td>{{$loan->date_out}}</td>
                    @if($loan->date_in==null)
                    <form action="/loans/return" method="post">
                        @csrf
                        <input type="hidden" name="loan_id" value={{$loan->id}}>
                        <td><button class="bi bi-journal-arrow-down bg-secondary" type="submit" style="color:white"> Επιστροφή</button></td>
                    </form>
                    @else
                        <td>{{$loan->date_in}}</td>
                    @endif
                </tr>
            
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                <th id="search">Κωδικός Βιβλίου</th>
                <th id="search">Τίτλος</th>
                <th id="search">Συγγραφέας</th>
                <th id="search">Εκδότης</th>
                <th id="search">Επώνυμο μαθητή</th>
                <th id="search">Όνομα μαθητή</th>
                <th id="search">Τάξη μαθητή</th>
                <th id="search">Ημερομηνία Δανεισμού</th>
                <th id="search">Ημερομηνία Επιστροφής</th>
                </tr>
            </tfoot>
        </table>
        <br>
    σύνολο ενεργών δανεισμών: <strong>{{$loans->whereNull('date_in')->count()}}</strong> από <strong>{{$loans->count()}}</strong>
    @endisset
    </div>
</x-layout>