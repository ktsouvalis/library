<x-layout>

    <div class="container py-3">
    @include('menu')
        <div class="col-sm-2 btn btn-success text-wrap">
                {{$book->code}}, {{$book->title}}, <i>{{$book->writer}}</i>, {{$book->publisher}}
        </div>
        <div class="m-3">
        @isset($students)

            <table id="dataTable" class="display">
                <thead>
                <tr>
                <th>Αριθμός Μητρώου</th>
                <th>Επώνυμο</th>
                <th>Όνομα</th>
                <th>Πατρώνυμο</th>
                <th>Τάξη</th>
                <th>Καταχώρηση Δανεισμού</th>
                </tr>
                </thead>
                <tbody>
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
                </tbody>
                <tfoot>
                    <tr>
                        <th id="search">Αριθμός Μητρώου</th>
                        <th id="search">Επώνυμο</th>
                        <th id="search">Όνομα</th>
                        <th id="search">Πατρώνυμο</th>
                        <th id="search">Τάξη</th>
                        <th id="search">Δανεισμός / Επιστροφή</th>
                    </tr>
                </tfoot>
            </table>
        @endisset
        @isset($saved)
            <div class="alert alert-success" role="alert">Ο Δανεισμός καταχωρήθηκε</div>
        @endisset
        </div>
</x-layout>