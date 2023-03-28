<x-layout>
    <div class="p-3 container">
    @include('menu')
<body>
    <div class="p-3 row">
        <div class="col-sm-2 btn btn-success text-wrap" >
            {{$student->am}}, {{$student->surname}} {{$student->name}}, {{$student->f_name}}, {{$student->class}}
        </div>
        <div class="col-sm-2 " >
            <a href="/edit_student/{{$student->id}}" class="btn btn-primary bi bi-journal-text">  Επεξεργασία στοιχείων μαθητή</a>
        </div>
        <div class="col-sm-2" >
            <a href="{{route('search_loan_s',[$student->id])}} " class="btn btn-primary bi bi-journal-arrow-up">  Καταχώρηση δανεισμού</a>
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
                <td><a href='/book_profile/{{$loan->book->id}}'>{{$loan->book->title}}</a></td>
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
    σύνολο ενεργών δανεισμών: <strong>{{$student->loans->whereNull('date_in')->count()}}</strong> από <strong>{{$student->loans->count()}}</strong>
    
</div>
</x-layout>