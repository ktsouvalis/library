<x-layout>

    @push('links')
        <link href="../DataTables-1.13.4/css/dataTables.bootstrap5.css" rel="stylesheet"/>
        <link href="../Responsive-2.4.1/css/responsive.bootstrap5.css" rel="stylesheet"/>
    @endpush

    @push('scripts')
        <script src="../DataTables-1.13.4/js/jquery.dataTables.js"></script>
        <script src="../DataTables-1.13.4/js/dataTables.bootstrap5.js"></script>
        <script src="../Responsive-2.4.1/js/dataTables.responsive.js"></script>
        <script src="../Responsive-2.4.1/js/responsive.bootstrap5.js"></script>
    @endpush
    
    @push('title')
        <title>Δανεισμός στον μαθητή {{$student->surname}} {{$student->name}} </title>
    @endpush

    <div class="container py-3">
    @include('menu')
        <div class="col-sm-2 btn btn-warning text-wrap">
            <div class="fa-solid fa-graduation-cap"> </div>
            {{$student->am}}, {{$student->surname}} {{$student->name}}, {{$student->f_name}}, {{$student->class}}
        </div>
        @isset($books)
        <div class="table-responsive">
            <table id="dataTable" class="display table table-sm table-striped table-hover">
                <thead>
                <tr>
                    <th id="search">Κωδικός Βιβλίου</th>
                    <th id="search">Τίτλος</th>
                    <th id="search">Συγγραφέας</th>
                    <th id="search">Εκδότης</th>
                    <th id="search">Θεματική</th>
                    <th id="search">Διαθεσιμότητα</th>
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
                    <form action="{{ url("/save_s_loan/$student->id")}}" method="post" class="container-fluid">
                    @csrf
                        <input type="hidden" name="book_id" id="{{$book->id}}" value="{{$book->id}}">
                        <td><button type="submit" class="bi bi-journal-arrow-up btn btn-primary" style="color:white" data-toggle="tooltip" data-placement="top" title="Καταχώρηση δανεισμού" > Δανεισμός  </button></td>
                    </form>
                @else
                    @php
                        $data = $book->loans()->where('book_id', $book->id)->whereNull('date_in')->first()->student  
                    @endphp

                    <td style="color:red" data-toggle="tooltip" title="{{$data->surname}} {{$data->name}} {{$data->class}}"> <strong>ΜΗ ΔΙΑΘΕΣΙΜΟ</strong></td>
                @endif
                </tr>
            @endforeach
            </tbody>
            </table>
        </div>
        @endisset
    </div>
</x-layout>