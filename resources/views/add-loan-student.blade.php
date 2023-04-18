<x-layout>

    <div class="container py-3">
    @include('menu')
        <div class="col-sm-2 btn btn-warning text-wrap">
                {{$student->am}}, {{$student->surname}} {{$student->name}}, {{$student->f_name}}, {{$student->class}}
        </div>
        @isset($books)
            <table id="dataTable" class="display">
                <thead>
                <tr>
                <th>Κωδικός Βιβλίου</th>
                <th>Τίτλος</th>
                <th>Συγγραφέας</th>
                <th>Εκδότης</th>
                <th>Θεματική</th>
                <th>Καταχώρηση Δανεισμού</th>
                </tr>
            </thead>
            <tbody>
            @foreach($books as $book)
                <tr>  
                <td>{{$book->code}}</td>
                <td><div class="badge bg-success text-wrap" style="color:white">{{$book->title}}</div></td>
                <td>{{$book->writer}}</td>
                <td>{{$book->publisher}}</td>
                <td>{{$book->subject}}</td>
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
            </tbody>
            <tfoot>
                <tr>
                    <th id="search">Κωδικός Βιβλίου</th>
                    <th id="search">Τίτλος</th>
                    <th id="search">Συγγραφέας</th>
                    <th id="search">Εκδότης</th>
                    <th id="search">Θεματική</th>
                    <th id="search">Δανεισμός / Επιστροφή</th>
                </tr>
            </tfoot>
            </table>
        @endisset
    </div>
</x-layout>