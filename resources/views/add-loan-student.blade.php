<x-layout>

    <div class="container py-3">
    @include('menu')
        <div class="col-sm-2 btn btn-warning text-wrap">
                {{$student->am}}, {{$student->surname}} {{$student->name}}, {{$student->f_name}}, {{$student->class}}
        </div>
        <div class="m-3">
        <form action="{{route('loans_search_student', [$student->id])}}" method="post" class="container-fluid">
            @csrf
            <input type="hidden" name="student_id" value="{{$student->id}}">
            <input type="hidden" name="asks_to" value="search">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1"><strong>Εισάγετε Κωδικό ή μέρος του τίτλου του βιβλίου προς δανεισμό</strong></span>
            </div>
            <div class="input-group">
                <input name="book_code" type="number" value="" class="form-control" placeholder="Κωδικός Βιβλίου" aria-label="Κωδικός Βιβιλίου" aria-describedby="basic-addon2">
            </div>
            <div class="input-group">
                <input name="book_title" type="text" value="" class="form-control" placeholder="Τίτλος Βιβλίου" aria-label="Τίτλος Βιβιλίου" aria-describedby="basic-addon2">
            </div>
            <button type="submit" class="btn btn-primary">Αναζήτηση</button>
        </form>
        </div>
    @isset($dberror)
                <div class="alert alert-danger" role="alert">{{$dberror}}</div>
    @else
        @isset($books)
            <table class="table table-striped table-hover table-light">
                <tr>
                <th>Κωδικός Βιβλίου</th>
                <th>Τίτλος</th>
                <th>Συγγραφέας</th>
                <th>Εκδότης</th>
                <th>Καταχώρηση Δανεισμού</th>
                </tr>
            @foreach($books as $book)
                <tr>  
                <td>{{$book->code}}</td>
                <td><div class="badge bg-success text-wrap" style="color:white">{{$book->title}}</div></td>
                <td>{{$book->writer}}</td>
                <td>{{$book->publisher}}</td>
                @if($book->available)
                    <form action="{{route('loans_save_student', [$student->id])}}" method="post" class="container-fluid">
                    @csrf
                        <input type="hidden" name="book_id" id="{{$book->id}}" value="{{$book->id}}">
                        <td><button type="submit" class="bi bi-journal-arrow-up bg-primary" style="color:white" data-toggle="tooltip" data-placement="top" title="Καταχώρηση δανεισμού" >   </button></td>
                    </form>
                @else
                    <td style="color:red">Μη διαθέσιμο</td>
                @endif
                </tr>
            @endforeach
            </table>
        @endisset
    @endisset
    </div>
</x-layout>