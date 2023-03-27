<x-layout>

    <div class="container py-3">
    @include('menu')
    {{-- <nav class="navbar navbar-light bg-light"> --}}
        <div class="badge bg-success text-wrap m-3">
                {{$book->code}}, {{$book->title}}, {{$book->writer}}, {{$book->publisher}}
        </div>
        <div class="m-3">
        <form action="{{route('loans_search_book', [$book->id])}}" method="post" class="container-fluid">
            @csrf
            <input type="hidden" name="student_id" value="{{$book->id}}">
            <input type="hidden" name="asks_to" value="search">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1"><strong>Εισάγετε όνομα μαθητή για δανεισμό</strong></span>
            </div>
            <div class="input-group">
                <input name="student_surname" type="text" value="" class="form-control" placeholder="Επώνυμο Μαθητή" aria-label="Επώνυμο Μαθητή" aria-describedby="basic-addon2" required>
            </div>
            <button type="submit" class="btn btn-primary">Αναζήτηση</button>
        </form>
        </div>
    {{-- </nav> --}}
    @isset($dberror)
                <div class="alert alert-danger" role="alert">{{$dberror}}</div>
    @else
        @isset($students)
        <form action="{{route('loans_save_book', [$book->id])}}" method="post" class="container-fluid">
            @csrf
            <div class="row py-3 m-3">
                <div class="col">
                    @foreach($students as $student)
                        <div class="row py-2">
                        <input type="radio" class="btn-check" name="student_id" id="{{$student->id}}" value="{{$student->id}}" autocomplete="off">
                        <label style="color:black" class="btn btn-outline-warning" for="{{$student->id}}">{{$student->surname}} {{$student->name}}, {{$student->f_name}}, {{$student->class}}</label>
                        {{-- <div class="custom-control custom-radio">
                            <input type="radio" name="student_id" value="{{$student->id}}" class="custom-control-input">
                            <label class="custom-control-label" for="student_id">
                                <div class="col-2 badge bg-warning text-wrap" style="width: 12rem; color: black">
                                    {{$student->surname}} {{$student->name}}, {{$student->f_name}}, {{$student->class}}
                                </div>
                            </label>
                        </div> --}}
                        </div>
                    @endforeach
                </div>
                <div class="col">
                        <input type="hidden" name="asks_to" value="save">
                        <input type="hidden" name="book_id" value={{$book->id}}>
                        
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary" style="">Καταχώρηση Δανεισμού</button>
                        </div>
                    </form>
                </div>
            </div>
        @endisset
        @isset($saved)
            <div class="alert alert-success" role="alert">Ο Δανεισμός καταχωρήθηκε</div>
        @endisset
        </div>
    @endisset
</x-layout>