<x-layout>
    @push('title')
        <title>{{$student->surname}} {{$student->name}}</title>
    @endpush
    <div class="p-3 container">
    @include('menu')
<body>
    <div class="p-3 row">
        <div class="container-md">
        <div class="row rounded-top bg-warning bg-gradient  text-wrap">
            <div class="col">Αριθμός Μητρώου</div>
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
            @if($student->class==0)
                <div class="col"><strong>ΑΠΟΦΟΙΤΟΣ</strong></div>
            @else
                <div class="col">{{$student->class}}</div>
            @endif
        </div>
        </div>
    </div>
    <div class="p-3 row">
        @if($student->class <> '0')
            <div class="col-sm-2" >
                <a href="{{route('search_loan_s',[$student->id])}} " class="btn btn-primary bi bi-search" style="text-decoration:none;">  Αναζήτηση βιβλίου για νέο δανεισμό στον μαθητή</a>
            </div> 
            <div class="col-sm-2 " >
                <a href="/edit_student/{{$student->id}}" class="btn btn-primary bi bi-journal-text" style="text-decoration:none;">  Επεξεργασία στοιχείων μαθητή</a>
            </div>
        @endif
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
        
            <tr >  
                <td>{{$loan->book->code}}</td>
                <td><div class="badge bg-success text-wrap"><a href='/book_profile/{{$loan->book->id}}' style="color:white; text-decoration:none;">{{$loan->book->title}}</a></div></td>
                <td>{{$loan->book->writer}}</td>
                <td>{{$loan->book->publisher}}</td>
                <td>{{$loan->date_out}}</td>
                @if($loan->date_in==null)
                <form action="/return_loan/{{$loan->id}}" method="post">
                    @csrf
                    <td><button class="bi bi-journal-arrow-down bg-secondary" style="color:white" type="submit" data-toggle="tooltip" data-placement="top" title="Επιστροφή"> Επιστροφή  </button></td>
                </form>
                @else
                    <td>{{$loan->date_in}}</td>
                @endif
            </tr>
        @endforeach
    </table>
    <br>
    σύνολο ενεργών δανεισμών: <strong>{{$student->loans->whereNull('date_in')->count()}}</strong> από <strong>{{$student->loans->count()}}</strong>
    
</div>
</x-layout>