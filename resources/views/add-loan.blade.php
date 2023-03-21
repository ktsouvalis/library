<x-layout>
    <nav class="navbar navbar-light bg-light">
        <div class="badge bg-success text-wrap" style="width: 12rem;">
                {{$student->am}} {{$student->surname}} {{$student->name}} {{$student->f_name}} {{$student->class}}
        </div>
        <form action="/save_loan/{{$student->id}}" method="post" class="container-fluid">
            @csrf
            <input type="hidden" name="student_id" value="{{$student->id}}">
            <input type="hidden" name="asks_to" value="search">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1"><strong>Εισάγετε Κωδικό Βιβιλίου προς Δανεισμό</strong></span>
            </div>
            <div class="input-group">
                <input name="book_id" type="number" value="" class="form-control" placeholder="Κωδικός Βιβλίο" aria-label="Κωδικός Βιβιλίου" aria-describedby="basic-addon2">
            </div>
            <button type="submit" class="btn btn-primary">Αναζήτηση</button>
        </form>
    </nav>
    @isset($dberror)
                <div class="alert alert-danger" role="alert">{{$dberror}}</div>
    @else
        @isset($book)
        
            <div class="badge bg-success text-wrap" style="width: 12rem;">
                {{$book->title}}, <i>{{$book->writer}}</i>, Εκδόσεις {{$book->publisher}}
            </div>
            <form action="/save_loan/{{$student->id}}" method="post" class="container-fluid">
                @csrf
                <input type="hidden" name="asks_to" value="save">
                <input type="hidden" name="student_id" value="{{$student->id}}">
                <input type="hidden" name="book_id" value={{$book->id}}>
                <button type="submit" class="btn btn-primary">Καταχώρηση Δανεισμού</button>
            </form>

            @endif
        @endisset
        @isset($saved)
            <div class="alert alert-success" role="alert">Ο Δανεισμός καταχωρήθηκε</div>
        @endisset
</x-layout>