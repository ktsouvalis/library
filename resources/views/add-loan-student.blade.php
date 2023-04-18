<x-layout>

    @push('links')
        <link href="../DataTables-1.13.4/css/dataTables.bootstrap5.css" rel="stylesheet"/>
        <link href="../Responsive-2.4.1/css/responsive.bootstrap5.css" rel="stylesheet"/>
    @endpush

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script
                  src="https://code.jquery.com/jquery-3.6.4.min.js"
                  integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
                  crossorigin="anonymous">
        </script>
        {{-- <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
        <script src="../DataTables-1.13.4/js/jquery.dataTables.js"></script>
        <script src="../DataTables-1.13.4/js/dataTables.bootstrap5.js"></script>
        <script src="../Responsive-2.4.1/js/dataTables.responsive.js"></script>
        <script src="../Responsive-2.4.1/js/responsive.bootstrap5.js"></script>
        <script>
          $(document).ready(function () {
        // Setup - add a text input to each footer cell
        $('#dataTable tfoot tr #search').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" style="width:7rem;" placeholder="' + title + '" />');
        });
     
        // DataTable
        var table = $('#dataTable').DataTable({
            initComplete: function () {
                // Apply the search
                this.api()
                    .columns()
                    .every(function () {
                        var that = this;
     
                        $('input', this.footer()).on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        });
                    });
                },
            });
        });
        </script>
    @endpush
    
    <div class="container py-3">
    @include('menu')
        <div class="col-sm-2 btn btn-warning text-wrap">
                {{$student->am}}, {{$student->surname}} {{$student->name}}, {{$student->f_name}}, {{$student->class}}
        </div>
        @isset($books)
            <table id="dataTable" class="display table table-sm table-striped table-hover">
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