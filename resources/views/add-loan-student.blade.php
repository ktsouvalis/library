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
            <form action="{{route('loans_save_student', [$student->id])}}" method="post" class="container-fluid">
            @csrf
            <div class="row py-3 m-3">
                <div class="col">
                    @foreach($books as $book)
                        @if($book->available)
                        <div class="row py-2">
                            <input type="radio" class="btn-check" name="book_id" id="{{$book->id}}" value="{{$book->id}}" autocomplete="off">
                            <label style="color:black" class="btn btn-outline-success" for="{{$book->id}}">{{$book->code}}, {{$book->title}}, {{$book->writer}}, {{$book->publisher}}</label>
                        </div>
                        @else
                        <div class="row py-2">
                            <input type="radio" class="btn-check" name="book_id" id="{{$book->id}}" value="{{$book->id}}" autocomplete="off" disabled>
                            <label style="color:black" class="btn btn-outline-danger" for="{{$book->id}}">{{$book->code}}, {{$book->title}}, {{$book->writer}}, {{$book->publisher}}: <strong>ΜΗ ΔΙΑΘΕΣΙΜΟ</strong></label>
                        </div>
                        @endif
                    @endforeach
                </div>
                <div class="col">
                        <input type="hidden" name="student_id" value={{$student->id}}>
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary" style="">Καταχώρηση Δανεισμού</button>
                        </div>
                </div>
            </div>
            </form>
        @endisset
    @endisset
    </div>
    
    {{-- @isset($saved)
        <div class="alert alert-success" role="alert">Ο Δανεισμός καταχωρήθηκε</div>
    @endisset --}}
</x-layout>