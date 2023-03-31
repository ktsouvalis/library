<x-layout>
<div class="p-3 container">
    @include('menu')
<body>
    <div class="p-3 row" >
        <div class="row rounded-top bg-success bg-gradient text-light  text-wrap">
            <div class="col">Κωδικός</div>
            <div class="col">Τίτλος</div>
            <div class="col">Συγγραφέας</div>
            <div class="col">Εκδόσεις</div>
            <div class="col">Θεματική</div>
            <div class="col">Αρ. Σελίδων</div>
            <div class="col">Σχόλια</div>
        </div>
        <div class="row rounded-bottom bg-success text-white p-3 text-wrap" style="opacity:0.9">
            <div class="col"><strong>{{$book->code}}</strong></div>
            <div class="col"><strong>{{$book->title}}</strong></div>
            <div class="col"><i>{{$book->writer}}</i></div>
            <div class="col">{{$book->publisher}}</div>
            <div class="col">{{$book->subject}}</div>
            <div class="col">{{$book->no_of_pages}}</div>
            <div class="col">{{$book->comments}}</div>
            <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMoreElements" aria-expanded="false" aria-controls="collapseMoreElements">
                Περισσότερα στοιχεία...
            </button>
            <div class="collapse" id="collapseMoreElements">
                <div class="card card-body bg-success text-white">
                    Έτος έκδοσης: {{$book->publish_year}}<br>
                    Τόπος έκδοσης: {{$book->publish_place}}<br>
                    Τρόπος απόκτησης: {{$book->acquired_by}}<br>
                    Χρονολογία απόκτησης: {{$book->acquired_year}}<br>


                </div>
            </div>
        </div>
    </div>
    <div class="p-3 row" >
        @if($book->available)
            <div class="col-sm-2"><a href="{{route('search_loan_b',[$book->id])}}" class="btn btn-primary bi bi-journal-arrow-up">  Καταχώρηση δανεισμού</a></div>
        @else
            <div class="col-sm-2 bg-danger rounded text-light">
                Το βιβλίο δεν είναι διαθέσιμο για δανεισμό
            </div>
        @endif
        <div class="col-sm-2"><a href="/edit_book/{{$book->id}}" class="btn btn-primary bi bi-journal-text">  Επεξεργασία στοιχείων βιβλίου</a></div>
        @if($book->available)
            <div class=col-sm-2>
                <form action="/delete_book/{{$book->id}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger bi bi-journal-x"> Διαγραφή βιβλίου</button>
                </form>    
            </div>  
        @endif
    </div>    
        <table class="table table-striped table-hover table-light">
            <tr>
                <th>Αριθμός Μητρώου</th>
                <th>Επίθετο</th>
                <th>Όνομα</th>
                <th>Τάξη</th>
                <th>Ημερομηνία Δανεισμού</th>
                <th>Ημερομηνία Επιστροφής</th>
            </tr>
            @foreach($book->loans as $loan)
            <form action="/loans/return" method="post">
                @csrf
                <input type="hidden" name="loan_id" value={{$loan->id}}>
                <tr >
                    <td>{{$loan->student->am}}</td>  
                    <td><div class="badge bg-warning text-wrap"><a href ="/profile/{{$loan->student->id}}" style="color:black">{{$loan->student->surname}}</a></div></td>
                    <td>{{$loan->student->name}}</td>
                    <td>{{$loan->student->class}}</td>
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
    σύνολο ενεργών δανεισμών: <strong>{{$book->loans->whereNull('date_in')->count()}}</strong> από <strong>{{$book->loans->count()}}</strong>
</div>
</x-layout>