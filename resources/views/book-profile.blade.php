<x-layout>
<div class="p-3 container">
    @include('menu')
<body>
    @push('title')
        <title>{{$book->title}}</title>
    @endpush
    <div class="p-3 row" >
        <div class="container-md">
            
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
    </div>
    <div class="p-3 row" >
        @if($book->available)
            <div class="col-sm-2"><a href="{{route('search_loan_b',[$book->id])}}" class="btn btn-primary bi bi-search" style="text-decoration:none;">  Αναζήτηση μαθητή για νέο δανεισμό του βιβλίου</a></div>
        @else
            <div class="col-sm-2 btn btn-danger bi bi-bricks rounded text-light" style="text-align:center;    ">
                Το βιβλίο δεν είναι διαθέσιμο για δανεισμό
            </div>
        @endif
        <div class="col-sm-2"><a href="{{url("/edit_book/$book->id")}}" class="btn btn-primary bi bi-journal-text" style="text-decoration:none;">  Επεξεργασία στοιχείων βιβλίου</a></div>
        @if($book->available)
            <div class=col-sm-2>
                <form action="{{url("/delete_book/$book->id")}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger bi bi-journal-x" onclick="return confirm('Με τη διαγραφή του βιβλίου θα διαγραφεί όλο το ιστορικό των δανεισμών του. Είστε βέβαιοι ότι θέλετε να προχωρήσετε;')"> Διαγραφή βιβλίου</button>
                </form>    
            </div>  
        @endif
    </div>    
        <table class="table table-striped table-hover table-light">
            <tr>
                <th>Αριθμός Μητρώου</th>
                <th>Επώνυμο</th>
                <th>Όνομα</th>
                <th>Τάξη</th>
                <th>Ημερομηνία Δανεισμού</th>
                <th>Ημερομηνία Επιστροφής</th>
            </tr>
            @foreach($book->loans as $loan)
            
                <tr >
                    <td>{{$loan->student->am}}</td>
                    @php
                        $lsi = $loan->student->id;      
                    @endphp  
                    <td><div class="badge bg-warning text-wrap"><a href ="{{url("/student_profile/$lsi")}}" style="color:black; text-decoration:none;">{{$loan->student->surname}}</a></div></td>
                    <td>{{$loan->student->name}}</td>
                    @if($loan->student->class <> '0')
                        <td>{{$loan->student->class}}</td>
                    @else
                        <td style="color:red"> ΑΠΟΦΟΙΤΟΣ </td>
                    @endif
                    <td>{{$loan->date_out}}</td>
                    @if($loan->date_in==null)
                    <form action="{{url("/return_loan/$loan->id")}}" method="post">
                        @csrf
                        <td><button class="bi bi-journal-arrow-down btn btn-secondary" type="submit" style="color:white" data-toggle="tooltip" data-placement="top" title="Επιστροφή"> Επιστροφή  </button></td>
                    </form>
                    @else
                        <td>{{$loan->date_in}}</td>
                    @endif
                </tr>
            @endforeach
        </table>
        <br>
    σύνολο ενεργών δανεισμών: <strong>{{$book->loans->whereNull('date_in')->count()}}</strong> από <strong>{{$book->loans->count()}}</strong>
</div>
</x-layout>