<x-layout>

    <div class="container py-3">
    @include('menu')
        <div class="col-sm-2 btn btn-success text-wrap">
                {{$book->code}}, {{$book->title}}, <i>{{$book->writer}}</i>, {{$book->publisher}}
        </div>
        <div class="m-3">
        <form action="{{route('loans_search_book', [$book->id])}}" method="post" class="">
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
    @isset($dberror)
                <div class="alert alert-danger" role="alert">{{$dberror}}</div>
    @else
        @isset($students)
            <table class="table table-striped table-hover table-light">
                <tr>
                <th>Αριθμός Μητρώου</th>
                <th>Επώνυμο</th>
                <th>Όνομα</th>
                <th>Πατρώνυμο</th>
                <th>Τάξη</th>
                <th>Καταχώρηση Δανεισμού</th>
                </tr>
            @foreach($students as $student)
                <tr>     
                <td>{{$student->am}}</td>
                <td><div class="badge bg-warning text-wrap" style="color:black">{{$student->surname}}</div></td>
                <td>{{$student->name}}</td>
                <td>{{$student->f_name}}</td>
                <td>{{$student->class}}</td>
                <form action="{{route('loans_save_book', [$book->id])}}" method="post" class="container-fluid">
                @csrf
                    <input type="hidden" name="student_id"  value="{{$student->id}}">
                    <td><button type="submit" class="bi bi-journal-arrow-up bg-primary" style="color:white" data-toggle="tooltip" data-placement="top" title="Καταχώρηση δανεισμού" >   </button></td>
                </form>
                </tr>
            @endforeach
            </table>
        @endisset
        @isset($saved)
            <div class="alert alert-success" role="alert">Ο Δανεισμός καταχωρήθηκε</div>
        @endisset
        </div>
    @endisset
</x-layout>