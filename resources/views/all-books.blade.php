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
        <title>Βιβλία</title>
    @endpush
<div class="container p-5">
@isset($school)
    <div class="d-flex justify-content-center"><p class="h3" style="color:black"> Κατάλογος Βιβλίων </p></div>
    <div class="d-flex justify-content-center"><p class="h6" style="color:black">{{$school->display_name}}</p></div>        
@endisset
@isset($books)
    <div class="table-responsive">
    <table id="dataTable" class="table table-striped table-bordered table-sm table-hover">
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
    @foreach($books as $book)
        <tr> 
            <td>{{$book->code}}</td>
            <td>{{$book->title}}</td>
            <td>{{$book->writer}}</td>
            <td>{{$book->publisher}}</td>
            <td>{{$book->subject}}</td>
            @if($book->available)
                <td>Διαθέσιμο</td>
            @else
                <td>-</td>
            @endif
        </tr>
    @endforeach
    </table>
    </div>
@endisset
</div>
</x-layout>