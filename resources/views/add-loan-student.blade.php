<x-layout>

    <div class="container py-3">
    @include('menu')
    {{-- <nav class="navbar navbar-light bg-light"> --}}
        <div class="badge bg-success text-wrap m-3">
                {{$student->am}}, {{$student->surname}} {{$student->name}}, {{$student->f_name}}, {{$student->class}}
        </div>
        <div class="m-3">
        <form action="{{route('loans_search_student', [$student->id])}}" method="post" class="container-fluid">
            @csrf
            <input type="hidden" name="student_id" value="{{$student->id}}">
            <input type="hidden" name="asks_to" value="search">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1"><strong>Εισάγετε Κωδικό Βιβιλίου προς Δανεισμό</strong></span>
            </div>
            <div class="input-group">
                <input name="book_code" type="number" value="" class="form-control" placeholder="Κωδικός Βιβλίο" aria-label="Κωδικός Βιβιλίου" aria-describedby="basic-addon2">
            </div>
            <button type="submit" class="btn btn-primary">Αναζήτηση</button>
        </form>
        </div>
    {{-- </nav> --}}
    @isset($dberror)
                <div class="alert alert-danger" role="alert">{{$dberror}}</div>
    @else
        @isset($book)
        
        <div class="row py-3 m-3">
            <div class="col-2 badge bg-warning text-wrap">
                {{$book->title}}, <i>{{$book->writer}}</i>, Εκδόσεις {{$book->publisher}}
            </div>
        
            <div class="col">
            <form action="{{route('loans_save_student', [$student->id])}}" method="post" class="container-fluid">
                @csrf
                <input type="hidden" name="asks_to" value="save">
                <input type="hidden" name="student_id" value="{{$student->id}}">
                <input type="hidden" name="book_id" value={{$book->id}}>
                
                <div class="input-group">
                    <button type="submit" class="btn btn-primary" style="">Καταχώρηση Δανεισμού</button>
                </div>
            </form>
            </div>
        </div>

            @endif
        @endisset
        @isset($saved)
            <div class="alert alert-success" role="alert">Ο Δανεισμός καταχωρήθηκε</div>
        @endisset
        </div>
        
</x-layout>