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
        $all_books = Illuminate\Support\Facades\Auth::user()->books;
    @endphp
<body>
<div class="container">
    @include('menu')
    <div class="d-flex justify-content-end">
        <a href="{{url('/dl_books')}}" class="btn btn-success bi bi-download" style="color:white; text-decoration:none;"> Λήψη αρχείου βιβλίων </a>
    </div>
    <!--tabs-->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link @if(!session()->has('active_tab'))  {{'active'}} @endif" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Αναζήτηση Βιβλίου </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link @if(session()->has('active_tab'))  @if(session('active_tab')=='import') {{'active'}} @endif @endif" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">Μαζική Εισαγωγή Βιβλίων</button>
        </li>
    </ul>
    <!--tab content-->
    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade @if(!session()->has('active_tab')) {{'show active'}}  @endif" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <!-- 1st tab's content-->
            <div class="table-responsive">
                <table  id="dataTable" class=" table table-sm table-striped table-bordered table-hover">
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
                            <td><div class="badge bg-success text-wrap"><a href="{{url("/book_profile/$book->url")}}" style="color:white;text-decoration:none;">{{$book->title}}</a><div></div></td>
                            <td>{{$book->writer}}</td>
                            <td>{{$book->publisher}}</td>
                            <td>{{$book->subject}}</td>
                            @if($book->available)
                                <form action="{{url("/search_b_loan/$book->id")}}" method="get">
                                    @csrf
                                    <td><button class="bi bi-search btn btn-primary" type="submit" data-toggle="tooltip" title = "Αναζήτηση μαθητή για δανεισμό" style="color: white"> Δανεισμός </button></td>
                                </form>
                            @else
                                @php 
                                    $bl = $book->loans->whereNull('date_in');
                                    if($bl)
                                        $bl_id = $bl->first()->id; 
                                @endphp
                                <form action="{{url("/return_loan/$bl_id")}}" method="post">
                                    @csrf
                                    @php
                                        $data = $book->loans->whereNull('date_in')->first()->student  
                                    @endphp
                                    <td><button class="bi bi-journal-arrow-down btn btn-secondary" type="submit" data-toggle="tooltip" title = "{{$data->surname}} {{$data->name}} {{$data->class}}" style="color: white"> Επιστροφή </button></td>
                                </form>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            
            @if(session()->has('record'))
                <div class="col-sm-2 btn btn-success text-wrap">
                    @php $ses_rec =session('record')->url; @endphp
                    <a href="{{url("/book_profile/$ses_rec")}}" style="color:white; text-decoration:none;">{{session('record')->code}}, {{session('record')->writer}}, <i>{{session('record')->title}}</i>, {{session('record')->publisher}}</a>
                </div>
            @endif
           
            <div class="container py-5">
            <div class="container px-5">
            <nav class="navbar navbar-light bg-light">
                <form action="{{url('/insert_book')}}" method="post" class="container-fluid">
                    @csrf
                    <input type="hidden" name="asks_to" value="insert">
                    <div class="input-group">
                        <span class="input-group-text w-25"></span>
                        <span class="input-group-text w-75"><strong>Εισαγωγή νέου Βιβλίου</strong></span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon1">Κωδικός</span>
                        <input name="book_code3" type="text" value="" class="form-control" placeholder="Κωδικός Βιβλίου" aria-label="Κωδικός Βιβλίου" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon2">Συγγραφέας*</span>
                        <input name="book_writer3" type="text" class="form-control" placeholder="Συγγραφέας" aria-label="Συγγραφέας" aria-describedby="basic-addon2" required value="@if(session()->has('old_data')){{session('old_data')['book_writer3']}}@endif"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon3">Τίτλος*</span>
                        <input name="book_title3" type="text" class="form-control" placeholder="Τίτλος" aria-label="Τίτλος" aria-describedby="basic-addon3" required value="@if(session()->has('old_data')){{session('old_data')['book_title3']}}@endif"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon4">Εκδόσεις</span>
                        <input name="book_publisher3" type="text" class="form-control" placeholder="Εκδόσεις" aria-label="Εκδόσεις" aria-describedby="basic-addon4" value="@if(session()->has('old_data')){{session('old_data')['book_publisher3']}}@endif"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon5">Θεματική</span>
                        <input name="book_subject3" type="text" class="form-control" placeholder="Θεματική" aria-label="Θεματική" aria-describedby="basic-addon5" value="@if(session()->has('old_data')){{session('old_data')['book_subject3']}}@endif"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon6">Τόπος Έκδοσης</span>
                        <input name="book_publish_place3" type="text" class="form-control" placeholder="Τόπος Έκδοσης" aria-label="Τόπος Έκδοσης" aria-describedby="basic-addon6" value="@if(session()->has('old_data')){{session('old_data')['book_publish_place3']}}@endif"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon7">Χρονολογία Έκδοσης</span>
                        <input name="book_publish_year3" type="text" class="form-control" placeholder="Χρονολογία Έκδοσης" aria-label="Χρονολογία Έκδοσης" aria-describedby="basic-addon7" value="@if(session()->has('old_data')){{session('old_data')['book_publish_year3']}}@endif"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon8">Αριθμός Σελίδων</span>
                        <input name="book_no_of_pages3" type="number"  class="form-control" placeholder="Αρ. Σελίδων" aria-label="Αρ. Σελίδων" aria-describedby="basic-addon8" value="@if(session()->has('old_data')){{session('old_data')['book_no_of_pages3']}}@endif"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon9">Τρόπος απόκτησης</span>
                        <input name="book_acquired_by3" type="text" class="form-control" placeholder="Τρόπος απόκτησης" aria-label="Τρόπος απόκτησης" aria-describedby="basic-addon9" value="@if(session()->has('old_data')){{session('old_data')['book_acquired_by3']}}@endif"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon10">Χρονολογία απόκτησης</span>
                        <input name="book_acquired_year3" type="text" class="form-control" placeholder="Χρονολογία απόκτησης" aria-label="Χρονολογία απόκτησης" aria-describedby="basic-addon10" value="@if(session()->has('old_data')){{session('old_data')['book_acquired_year3']}}@endif"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon11">Σχόλια</span>
                        <input name="book_comments3" type="text" class="form-control" placeholder="Σχόλια" aria-label="Σχόλια" aria-describedby="basic-addon11" value="@if(session()->has('old_data')){{session('old_data')['book_comments3']}}@endif"><br>
                    </div>
                    <div class="input-group">
                        <span class="w-25"></span>
                        <div class="hstack">
                        <button type="submit" class="btn btn-primary m-2 bi bi-plus-circle"> Προσθήκη</button>
                        <a href="{{url('/book')}}" class="btn btn-outline-secondary m-2 bi bi-x-circle"> Ακύρωση</a>
                        </div>
                    </div>
                </form>
            </nav>
            </div></div>
        </div>

        
            <div class="tab-pane fade @if(session()->has('active_tab')) @if(session('active_tab')=='import') {{'show active'}} @endif @endif" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            @if(!session()->has('asks_to'))
            <nav class="navbar navbar-light bg-light">
                <form action="{{url('/upload_book_template')}}" method="post" class="container-fluid" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="import_books" >
                        <a href="{{url('/books_template.xlsx')}}" class="link-info">Κατεβάστε από εδώ το πρότυπο αρχείο της εφαρμογής</a>
                        <div class="hstack">
                            <div class="px-2"> Ανεβάζω:</div>
                            <div class="vstack px-2">
                                <div class="hstack">
                                    <input  type="radio" id="itdipeach" name="template_file" value="itdipeach" checked>
                                    <label class="px-1" for="itdipeach">Πρότυπο εφαρμογής</label><br>
                                </div>
                                <div class="hstack">
                                    <input type="radio" id="myschool" name="template_file" value="myschool">
                                    <label class="px-1" for="myschool">Αρχείο myschool</label><br> 
                                </div>
                            </div>
                            <button type="submit" class="btn bi bi-filetype-xlsx btn-primary"> Αποστολή αρχείου</button>
                        </div>
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
                @foreach(session('books_array') as $book)
                    <tr>  
                        <td @if ($book['code']=="Ο κωδικός χρησιμοποιείται") style='color:red;' @endif>{{$book['code']}}</td>
                        <td @if ($book['title']=='Κενό πεδίο τίτλου') style='color:red;' @endif>{{$book['title']}}</td>
                        <td @if ($book['writer']=='Κενό πεδίο συγγραφέα') style='color:red;' @endif>{{$book['writer']}}</td>
                        <td>{{$book['publisher']}}</td>
                        <td>{{$book['publish_year']}}</td>
                        <td @if ($book['no_of_pages']==0) style='color:blue;' @endif>{{$book['no_of_pages']}}</td>
                        <td>{{$book['acquired_year']}}</td>
                    </tr>
                @endforeach
            </table>
                @if(session('asks_to')=='save')
                    Να προχωρήσει η εισαγωγή αυτών των στοιχείων;
                    <div class="row">
                        <form action="{{url('/insert_books')}}" method="post" class="col container-fluid" enctype="multipart/form-data">
                        @csrf
                            <button type="submit" class="btn btn-primary bi bi-file-arrow-up"> Εισαγωγή</button>
                        </form>
                        <a href="{{url('/book')}}" class="col">Ακύρωση</a>
                    </div>
                @else
                    <div class="row">
                        <div>
                            Διορθώστε τα σημειωμένα σφάλματα και υποβάλετε εκ νέου το αρχείο.
                        </div>
                        <a href="{{url('/book')}}" class="col">Ακύρωση</a>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
</x-layout>