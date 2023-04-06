<x-layout>
    <div class="p-3 container">
    @include('menu')
<body>
    <div class="p-3 row">
        <div class="container-md">
        <div class="row rounded-top bg-warning bg-gradient  text-wrap">
            <div class="col">Κωδικός</div>
            <div class="col">Επώνυμο</div>
            <div class="col">Όνομα</div>
            <div class="col">Όνομα πατρός</div>
            <div class="col">Τάξη/Τμήμα</div>
        </div>
        <div class="row rounded-bottom bg-warning p-3 text-wrap" style="">
            <div class="col"><strong>{{$student->am}}</strong></div>
            <div class="col"><strong>{{$student->surname}}</strong></div>
            <div class="col"><strong>{{$student->name}}</strong></div>
            <div class="col">{{$student->f_name}}</div>
            <div class="col">{{$student->class}}</div>
        </div>
        </div>
    </div>
    <div class="p-3 row">
        <div class="col-sm-2" >
            <a href="{{route('search_loan_s',[$student->id])}} " class="btn btn-primary bi bi-journal-arrow-up" style="text-decoration:none;">  Καταχώρηση δανεισμού</a>
        </div> 
        <div class="col-sm-2 " >
            <a href="/edit_student/{{$student->id}}" class="btn btn-primary bi bi-journal-text" style="text-decoration:none;">  Επεξεργασία στοιχείων μαθητή</a>
        </div>
    </div>
    <table class="table table-striped table-hover table-light">
        <tr>
            <th>Κωδικός Βιβλίου</th>
            <th>Τίτλος</th>
            <th>Συγγραφέας</th>
            <th>Εκδότης</th>
            <th>Ημερομηνία Δανεισμού</th>
            <th>Ημερομηνία Επιστροφής</th>
        </tr>
        @foreach($student->loans as $loan)
        <form action="/loans/return" method="post">
            @csrf
            <input type="hidden" name="loan_id" value={{$loan->id}}>
            <tr >  
                <td>{{$loan->book->code}}</td>
                <td><div class="badge bg-success text-wrap"><a href='/book_profile/{{$loan->book->id}}' style="color:white; text-decoration:none;">{{$loan->book->title}}</a></div></td>
                <td>{{$loan->book->writer}}</td>
                <td>{{$loan->book->publisher}}</td>
                <td>{{$loan->date_out}}</td>
                @if($loan->date_in==null)
                    <td><button class="bi bi-journal-arrow-down bg-secondary" style="color:white" type="submit" data-toggle="tooltip" data-placement="top" title="Επιστροφή">   </button></td>
                @else
                    <td>{{$loan->date_in}}</td>
                @endif
            </tr>
        </form>
        @endforeach
    </table>
    <br>
    σύνολο ενεργών δανεισμών: <strong>{{$student->loans->whereNull('date_in')->count()}}</strong> από <strong>{{$student->loans->count()}}</strong>
    
</div>
</x-layout>