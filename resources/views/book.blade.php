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
        <title>Βιβλία</title>
    @endpush
    @php
        $all_books = App\Models\Book::where('user_id', Illuminate\Support\Facades\Auth::id())->get();
    @endphp
<body>
<div class="container">
    @include('menu')
    <div class="d-flex justify-content-end">
        <a href="/dl_books" class="btn btn-success bi bi-download" style="color:white; text-decoration:none;"> Λήψη αρχείου βιβλίων </a>
    </div>
    <!--tabs-->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link @isset($active_tab) @if($active_tab=='search') {{'active'}} @endif @else {{'active'}} @endisset" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Αναζήτηση Βιβλίου </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link @isset($active_tab) @if($active_tab=='import') {{'active'}} @endif @endisset" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">Μαζική Εισαγωγή Βιβλίων</button>
        </li>
    </ul>
    <!--tab content-->
    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='search') {{'show active'}}  @endif @else {{'show active'}} @endisset" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <!-- 1st tab's content-->
            <div class="table-responsive">
                <table  id="dataTable" class="display table table-sm table-striped table-hover">
                    <thead>
                        
                        <tr>
                            <th id="search">Κωδικός Βιβλίου</th>
                            <th id="search">Τίτλος</th>
                            <th id="search">Συγγραφέας</th>
                            <th id="search">Εκδότης</th>
                            <th id="search">Θεματική</th>
                            <th id="search">Δανεισμός / Επιστροφή</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                    @foreach($all_books as $book)
                        <tr>  
                            <td>{{$book->code}}</td>
                            <td><div class="badge bg-success text-wrap"><a href="/book_profile/{{$book->id}}" style="color:white;text-decoration:none;">{{$book->title}}</a><div></div></td>
                            <td>{{$book->writer}}</td>
                            <td>{{$book->publisher}}</td>
                            <td>{{$book->subject}}</td>
                            @if($book->available)
                                <form action="{{route('search_loan_b',[$book->id])}}" method="get">
                                    @csrf
                                    <td><button class="bi bi-search bg-primary" type="submit" data-toggle="tooltip" title = "Αναζήτηση μαθητή για δανεισμό" style="color: white"> Δανεισμός </button></td>
                                </form>
                            @else
                                <form action="/return_loan/{{$book->loans()->where('book_id', $book->id)->whereNull('date_in')->first()->id}}" method="post">
                                    @csrf
                                    @php
                                        $data = $book->loans()->where('book_id', $book->id)->whereNull('date_in')->first()->student  
                                    @endphp
                                    <td><button class="bi bi-journal-arrow-down bg-secondary" type="submit" data-toggle="tooltip" title = "{{$data->surname}} {{$data->name}} {{$data->class}}" style="color: white"> Επιστροφή </button></td>
                                </form>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            @isset($dberror3)
                <div class="alert alert-danger" role="alert">{{$dberror3}}</div>
            @else
                @isset($record)
                    <div class="alert alert-success" role="alert">Έγινε η καταχώρηση με τα εξής στοιχεία:</div>
                        <div class="col-sm-2 btn btn-success text-wrap">
                            <a href="/book_profile/{{$record->id}}" style="color:white; text-decoration:none;">{{$record->code}}, {{$record->writer}}, <i>{{$record->title}}</i>, {{$record->publisher}}</a>
                        </div>
                    </div>
                @endisset
            @endisset
            <div class="container py-5">
            <div class="container px-5">
            <nav class="navbar navbar-light bg-light">
                <form action="{{route('insert_book')}}" method="post" class="container-fluid">
                    @csrf
                    <input type="hidden" name="asks_to" value="insert">
                    <div class="input-group">
                        <span class="input-group-text w-25"></span>
                        <span class="input-group-text w-75"><strong>Εισαγωγή νέου Βιβλίου</strong></span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon1">Κωδικός*</span>
                        <input name="book_code3" type="number" value="" class="form-control" placeholder="Κωδικός Βιβλίου" aria-label="Κωδικός Βιβλίου" aria-describedby="basic-addon1" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon2">Συγγραφέας*</span>
                        <input name="book_writer3" type="text" class="form-control" placeholder="Συγγραφέας" aria-label="Συγγραφέας" aria-describedby="basic-addon2" required value="@isset($dberror3){{$old_data['book_writer3']}}@endisset"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon3">Τίτλος*</span>
                        <input name="book_title3" type="text" class="form-control" placeholder="Τίτλος" aria-label="Τίτλος" aria-describedby="basic-addon3" required value="@isset($dberror3){{$old_data['book_title3']}}@endisset"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon4">Εκδόσεις*</span>
                        <input name="book_publisher3" type="text" class="form-control" placeholder="Εκδόσεις" aria-label="Εκδόσεις" aria-describedby="basic-addon4" required value="@isset($dberror3){{$old_data['book_publisher3']}}@endisset"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon5">Θεματική</span>
                        <input name="book_subject3" type="text" class="form-control" placeholder="Θεματική" aria-label="Θεματική" aria-describedby="basic-addon5" value="@isset($dberror3){{$old_data['book_subject3']}}@endisset"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon6">Τόπος Έκδοσης</span>
                        <input name="book_publish_place3" type="text" class="form-control" placeholder="Τόπος Έκδοσης" aria-label="Τόπος Έκδοσης" aria-describedby="basic-addon6" value="@isset($dberror3){{$old_data['book_publish_place3']}}@endisset"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon7">Χρονολογία Έκδοσης</span>
                        <input name="book_publish_year3" type="text" class="form-control" placeholder="Χρονολογία Έκδοσης" aria-label="Χρονολογία Έκδοσης" aria-describedby="basic-addon7" value="@isset($dberror3){{$old_data['book_publish_year3']}}@endisset"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon8">Αριθμός Σελίδων</span>
                        <input name="book_no_of_pages3" type="number"  class="form-control" placeholder="Αρ. Σελίδων" aria-label="Αρ. Σελίδων" aria-describedby="basic-addon8" value="@isset($dberror3){{$old_data['book_no_of_pages3']}}@endisset"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon9">Τρόπος απόκτησης</span>
                        <input name="book_acquired_by3" type="text" class="form-control" placeholder="Τρόπος απόκτησης" aria-label="Τρόπος απόκτησης" aria-describedby="basic-addon9" value="@isset($dberror3){{$old_data['book_acquired_by3']}}@endisset"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon10">Χρονολογία απόκτησης</span>
                        <input name="book_acquired_year3" type="text" class="form-control" placeholder="Χρονολογία απόκτησης" aria-label="Χρονολογία απόκτησης" aria-describedby="basic-addon10" value="@isset($dberror3){{$old_data['book_acquired_year3']}}@endisset"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon11">Σχόλια</span>
                        <input name="book_comments3" type="text" class="form-control" placeholder="Σχόλια" aria-label="Σχόλια" aria-describedby="basic-addon11" value="@isset($dberror3){{$old_data['book_comments3']}}@endisset"><br>
                    </div>
                    <div class="input-group">
                        <span class="w-25"></span>
                        <button type="submit" class="btn btn-primary m-2">Προσθήκη</button>
                        <a href="/book" class="btn btn-outline-secondary m-2">Ακύρωση</a>
                    </div>
                </form>
            </nav>
            </div></div>
        </div>

        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='import') {{'show active'}} @endif @endisset" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            @if(empty($asks_to))
            <nav class="navbar navbar-light bg-light">
                <a href="/books_template.xlsx" class="link-info">Πρότυπο αρχείο για συμπλήρωση</a>
                <form action="{{route('book_template_upload')}}" method="post" class="container-fluid" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="file" name="import_books" > 
                    <button type="submit" class="btn bi bi-filetype-xlsx btn-primary"> Αποστολή αρχείου</button>
                </form>
            </nav>
            @else
            <div style="p-3 mb-2 bg-info text-dark">
                Διαβάστηκαν τα ακόλουθα βιβλία από το αρχείο:
            </div>
            
            <table class="table table-striped table-hover table-light">
                <tr>
                    <th>Κωδικός Βιβλίου</th>
                    <th>Τίτλος</th>
                    <th>Συγγραφέας</th>
                    <th>Εκδότης</th>
                    <th>Χρονολογία έκδοσης</th>
                    <th>Αριθμός σελίδων</th>
                    <th>Χρονολογία απόκτησης</th>
                </tr>
                @foreach($books_array as $book)
                    <tr>  
                        <td @if ($book['code']=="Ο κωδικός χρησιμοποιείται" or $book['code']=="Κενός κωδικός") style='color:red;' @endif>{{$book['code']}}</td>
                        <td @if ($book['title']=='Κενό πεδίο τίτλου') style='color:red;' @endif>{{$book['title']}}</td>
                        <td @if ($book['writer']=='Κενό πεδίο συγγραφέα') style='color:red;' @endif>{{$book['writer']}}</td>
                        <td @if ($book['publisher']=='Κενό πεδίο εκδότη') style='color:red;' @endif>{{$book['publisher']}}</td>
                        <td @if ($book['publish_year']=='Πρέπει να είναι αριθμός') style='color:red;' @endif>{{$book['publish_year']}}</td>
                        <td @if ($book['no_of_pages']=='Πρέπει να είναι αριθμός') style='color:red;' @endif>{{$book['no_of_pages']}}</td>
                        <td @if ($book['acquired_year']=='Πρέπει να είναι αριθμός') style='color:red;' @endif>{{$book['acquired_year']}}</td>
                    </tr>
                @endforeach
            </table>
                @if($asks_to=='save')
                    Να προχωρήσει η εισαγωγή αυτών των στοιχείων;
                    <div class="row">
                        <form action="/insert_books" method="post" class="col container-fluid" enctype="multipart/form-data">
                        @csrf
                            <button type="submit" class="btn btn-primary bi bi-file-arrow-up"> Εισαγωγή</button>
                        </form>
                        <a href="/book" class="col">Ακύρωση</a>
                    </div>
                    @else
                    <div class="row">
                        <div>
                            Διορθώστε τα σημειωμένα σφάλματα και υποβάλετε εκ νέου το αρχείο.
                        </div>
                        <a href="/book" class="col">Ακύρωση</a>
                    </div>
                @endif
            @endif
            @isset($dberror2)
                <div class="alert alert-danger" role="alert">{{$dberror2}}</div>
            @endisset
        </div>
    </div>
</div>
</x-layout>