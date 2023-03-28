<x-layout>
<div class="p-3 container">
    @include('menu')
<body>
    <div class="p-3 row" >
            <div class="col-sm-2 btn btn-success text-wrap">
                {{$book->code}}, {{$book->title}}, <i>{{$book->writer}}</i>, {{$book->publisher}}
            </div>
            @if($book->available)
                <div class="col-sm-2"><a href="{{route('search_loan_b',[$book->id])}}" class="btn btn-primary bi bi-book-fill">  Καταχώρηση δανεισμού</a></div>
            @else
                <div class="col-sm-2 m-4 badge bg-danger text-wrap " style="width: 12rem;">
                    Το βιβλίο δεν είναι διαθέσιμο για δανεισμό
                </div>
            @endif
            <div class="col-sm-2"><a href="/edit_book/{{$book->id}}" class="btn btn-primary bi bi-tools">  Επεξεργασία στοιχείων βιβλίου</a></div>  
    </div>    
        <table class="table table-striped table-hover table-light">
            <tr>
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
                    <td><a href ="/profile/{{$loan->student->id}}">{{$loan->student->surname}}</a></td>
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
    σύνολο ενεργών δανεισμών: <strong>{{$book->loans->whereNull('date_in')->count()}}</strong> από <strong>{{$book->loans->count()}}</strong>
</div>
</x-layout>