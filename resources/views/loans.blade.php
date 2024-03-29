<x-layout>

    @push('links')
        <link href="DataTables-1.13.4/css/dataTables.bootstrap5.css" rel="stylesheet"/>
        <link href="Responsive-2.4.1/css/responsive.bootstrap5.css" rel="stylesheet"/>
    @endpush

    @push('scripts')
        <script src="DataTables-1.13.4/js/jquery.dataTables.js"></script>
        <script src="DataTables-1.13.4/js/dataTables.bootstrap5.js"></script>
        <script src="Responsive-2.4.1/js/dataTables.responsive.js"></script>
        <script src="Responsive-2.4.1/js/responsive.bootstrap5.js"></script>
    @endpush

    @push('title')
        <title>Ιστορικό Δανεισμών</title>
    @endpush

    @php
        $loans = App\Models\Loan::where('user_id', Illuminate\Support\Facades\Auth::id())->get();
    @endphp
    <div class="container">
    @include('menu')
    <div class="d-flex justify-content-end">
        <a href="{{url('/dl_loans')}}" class="btn btn-danger bi bi-download"> Λήψη αρχείου δανεισμών </a>
    </div>
    <div class="table-responsive">
        <table id="dataTable" class="display table table-sm table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th id="search">ID Δανεισμού</th>
                <th id="search">Επώνυμο μαθητή</th>
                <th id="search">Όνομα μαθητή</th>
                <th id="search">Τάξη μαθητή</th>
                <th id="search">Κωδικός Βιβλίου</th>
                <th id="search">Τίτλος</th>
                <th id="search">Συγγραφέας</th>
                {{-- <th id="search">Εκδότης</th> --}}
                <th id="search">Ημ/νία Δανεισμού</th>
                <th id="search">Ημ/νία Επιστροφής</th>
                <th id="search">Διαγραφή Δανεισμού</th>
                </tr>
            </thead>
            <tbody>
            @foreach($loans as $loan)
                <tr >  
                    <td>{{$loan->id}}</td>
                    @php $lsi = $loan->student->id @endphp
                    <td><div class="badge bg-warning text-wrap"><a href="{{url("/student_profile/$lsi")}}" style="color:black; text-decoration:none;">{{$loan->student->surname}}</a></div></td>
                    <td>{{$loan->student->name}}</td>
                    @if($loan->student->class <> '0')
                        <td><strong>{{$loan->student->class}}</strong></td>
                    @else
                        <td style="color:red"> ΑΠΟΦΟΙΤΟΣ </td>
                    @endif
                    <td>{{$loan->book->code}}</td>
                    @php $lbi = $loan->book->url @endphp
                    <td><div class="badge bg-success text-wrap"><a href="{{url("/book_profile/$lbi")}}" style="color:white; text-decoration:none;">{{$loan->book->title}}</a></div></td>
                    <td>{{$loan->book->writer}}</td>
                    {{-- <td>{{$loan->book->publisher}}</td> --}}
                    
                    <td>{{$loan->date_out}}</td>
                    @if($loan->date_in==null)
                    <form action="{{url("/return_loan/$loan->id")}}" method="post">
                        @csrf
                        <td><button class="bi bi-journal-arrow-down btn btn-secondary" type="submit" style="color:white"> Επιστροφή</button></td>
                    </form>
                    <td> - </td>
                    @else
                        <td>{{$loan->date_in}}</td>
                        <form action="{{url("/delete_loan/$loan->id")}}" method="post">
                            @csrf
                            <td><button class="bi bi-x-circle btn btn-danger" type="submit" style="color:white" onclick="return confirm('Επιβεβαίωση διαγραφής δανεισμού;')"> Διαγραφή</button></td>
                        </form>
                    @endif
                </tr>
            
            @endforeach
            </tbody>
        </table>
    </div>
        <br>
    σύνολο ενεργών δανεισμών: <strong>{{$loans->whereNull('date_in')->count()}}</strong> από <strong>{{$loans->count()}}</strong>
    </div>
</x-layout>