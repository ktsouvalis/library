<x-layout>

    @push('links')
        <link href="DataTables-1.13.4/css/dataTables.bootstrap5.css" rel="stylesheet"/>
        <link href="Responsive-2.4.1/css/responsive.bootstrap5.css" rel="stylesheet"/>
    @endpush

    @push('scripts')
        {{-- <script src="/bootstrap/js/bootstrap.js"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script
                src="https://code.jquery.com/jquery-3.6.4.min.js"
                integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
                crossorigin="anonymous">
        </script>
        {{-- <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
        <script src="DataTables-1.13.4/js/jquery.dataTables.js"></script>
        <script src="DataTables-1.13.4/js/dataTables.bootstrap5.js"></script>
        <script src="Responsive-2.4.1/js/dataTables.responsive.js"></script>
        <script src="Responsive-2.4.1/js/responsive.bootstrap5.js"></script>
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

    <div class="container">
    @include('menu')
    <div class="d-flex justify-content-end">
        <a href="/loans_dl" class="btn btn-danger bi bi-download"> Λήψη αρχείου δανεισμών </a>
    </div>
    @isset($loans)
        <table id="dataTable" class="display table table-sm table-striped table-hover">
            <thead>
            <tr>
                <th>Κωδικός Βιβλίου</th>
                <th>Τίτλος</th>
                <th>Συγγραφέας</th>
                <th>Εκδότης</th>
                <th>Επώνυμο μαθητή</th>
                <th>Όνομα μαθητή</th>
                <th>Τάξη μαθητή</th>
                <th>Ημερομηνία Δανεισμού</th>
                <th>Ημερομηνία Επιστροφής</th>
            </tr>
            </thead>
            <tbody>
            @foreach($loans as $loan)
           
                <tr >  
                    <td>{{$loan->book->code}}</td>
                    <td><div class="badge bg-success text-wrap"><a href="/book_profile/{{$loan->book->id}}" style="color:white; text-decoration:none;">{{$loan->book->title}}</a></div></td>
                    <td>{{$loan->book->writer}}</td>
                    <td>{{$loan->book->publisher}}</td>
                    <td><div class="badge bg-warning text-wrap"><a href="/student_profile/{{$loan->student->id}}" style="color:black; text-decoration:none;">{{$loan->student->surname}}</a></div></td>
                    <td>{{$loan->student->name}}</td>
                    @if($loan->student->class <> '0')
                        <td><strong>{{$loan->student->class}}</strong></td>
                    @else
                        <td style="color:red"> ΑΠΟΦΟΙΤΟΣ </td>
                    @endif
                    <td>{{$loan->date_out}}</td>
                    @if($loan->date_in==null)
                    <form action="/loans/return" method="post">
                        @csrf
                        <input type="hidden" name="loan_id" value={{$loan->id}}>
                        <td><button class="bi bi-journal-arrow-down bg-secondary" type="submit" style="color:white"> Επιστροφή</button></td>
                    </form>
                    @else
                        <td>{{$loan->date_in}}</td>
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
                <th id="search">Επώνυμο μαθητή</th>
                <th id="search">Όνομα μαθητή</th>
                <th id="search">Τάξη μαθητή</th>
                <th id="search">Ημερομηνία Δανεισμού</th>
                <th id="search">Ημερομηνία Επιστροφής</th>
                </tr>
            </tfoot>
        </table>
        <br>
    σύνολο ενεργών δανεισμών: <strong>{{$loans->whereNull('date_in')->count()}}</strong> από <strong>{{$loans->count()}}</strong>
    @endisset
    </div>
</x-layout>