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
        <title>Μαθητές</title>
    @endpush

    @php
        $all_students =  Illuminate\Support\Facades\Auth::user()->students;
    @endphp
<body>
    <div class="container">
    @include('menu')
    <div class="d-flex justify-content-end">
        <a href="{{url('/download_students')}}" class="btn btn-warning bi bi-download"> Λήψη αρχείου μαθητών </a>
    </div>
<!--tabs-->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link @isset($active_tab) @if($active_tab=='search') {{'active'}} @endif @else {{'active'}} @endisset" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Αναζήτηση Μαθητή</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link @isset($active_tab) @if($active_tab=='import') {{'active'}} @endif @endisset" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">Μαζική Εισαγωγή Μαθητών</button>
        </li>
    </ul>
<!--tab content-->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='search') {{'show active'}}  @endif @else {{'show active'}} @endisset" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <!-- 1st tab's content-->
            <div class="table-responsive">
                <table  id="dataTable" class="display table table-sm table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th id="search">Αριθμός Μητρώου</th>
                        <th id="search">Βιβλίο Μητρώου</th>
                        <th id="search">Επώνυμο</th>
                        <th id="search">Όνομα</th>
                        <th id="search">Πατρώνυμο</th>
                        <th id="search">Τάξη</th>
                        <th id="search">Δανεισμός</th>
                    </tr>
                </thead>
                    <tbody>
                        @foreach($all_students as $student)
                            <tr>  
                                <td>{{$student->am}}</td>
                                <td>{{$student->bm}}</td>
                                <td><div class="badge bg-warning text-wrap"><a href="{{url("/student_profile/$student->id")}}" style="color:black; text-decoration:none;">{{$student->surname}}</a></div></td>
                                <td>{{$student->name}}</td>
                                <td>{{$student->f_name}}</td>
                                <td>{{$student->class}}</td>
                                <form action="{{url("/search_s_loan/$student->id")}}" method="get">
                                    @csrf
                                    <td><button class="btn btn-primary bi bi-search" type="submit" data-toggle="tooltip" title = "Αναζήτηση βιβλίου για δανεισμό" style="color: white"> Δανεισμός </button></td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if(session()->has('record'))
                <div class="m-2 col-sm-2 btn btn-warning text-wrap">
                    @php $srid = session('record')->id; @endphp
                    <a href="{{url("/student_profile/$srid")}}" style="color:black; text-decoration:none;">{{session('record')->am}}, {{session('record')->surname}} {{session('record')->name}}, {{session('record')->class}}</a>
                </div>
            @endif

            <div class="container py-5">
            <div class="container px-5">
            <nav class="navbar navbar-light bg-light">
                <form action="{{url("/insert_student")}}" method="post" class="container-fluid">
                    @csrf
                    <input type="hidden" name="asks_to" value="insert">
                    <div class="input-group">
                        <span class="input-group-text w-25"></span>
                        <span class="input-group-text w-75"><strong>Εισαγωγή νέου Μαθητή</strong></span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon1">Αριθμός Μητρώου*</span>
                        <input name="student_am3" type="number" value="" class="form-control" placeholder="Αριθμός Μητρώου Μαθητή" aria-label="ΑΜ Μαθητή" aria-describedby="basic-addon1" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon0">Βιβλίο Μητρώου*</span>
                        <input name="student_bm3" type="number" value="" class="form-control" placeholder="Βιβλίο Μητρώου" aria-label="Βιβλίο Μητρώου" aria-describedby="basic-addon0" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon2">Επώνυμο*</span>
                        <input name="student_surname3" type="text" class="form-control" placeholder="Επώνυμο Μαθητή" aria-label="Επώνυμο Μαθητή" aria-describedby="basic-addon2" required value="@if(session()->has('old_data')){{session('old_data')['student_surname3']}}@endif"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon3">Όνομα*</span>
                        <input name="student_name3" type="text" class="form-control" placeholder="Όνομα Μαθητή" aria-label="Όνομα Μαθητή" aria-describedby="basic-addon3" required value="@if(session()->has('old_data')){{session('old_data')['student_name3']}}@endif"><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon4">Πατρώνυμο</span>
                        <input name="student_fname3" type="text" class="form-control" placeholder="Πατρώνυμο Μαθητή" aria-label="Πατρώνυμο Μαθητή" aria-describedby="basic-addon4" value="@if(session()->has('old_data')){{session('old_data')['student_fname3']}}@endif" ><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon5">Τάξη*</span>
                        <input name="student_class3" type="text" class="form-control" placeholder="Τάξη" aria-label="Τάξη" aria-describedby="basic-addon5" required value="@if(session()->has('old_data')){{session('old_data')['student_class3']}}@endif" ><br>
                    </div>
                    <div class="input-group">
                        <span class="w-25"></span>
                        <div class="hstack">
                            <button type="submit" class="btn btn-primary m-2 bi bi-plus-circle"> Προσθήκη</button>
                            <a href="{{url('/student')}}" class="btn btn-outline-secondary m-2 bi bi-x-circle"> Ακύρωση</a>
                        </div>
                    </div>  
                </form>
            </nav>
            </div></div>
        </div>

        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='import') {{'show active'}} @endif @endisset" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            @if(empty($asks_to))
            <nav class="navbar navbar-light bg-light">
                <div class="vstack gap-3">
                <div>Η εφαρμογή <strong class="text-primary">ανανεώνει</strong> τα στοιχεία των <strong class="text-primary">υπάρχοντων μαθητών</strong> με βάση τον Α.Μ. και τον Αριθμό Βιβλίου Μητρώου <strong>και</strong> <strong class="text-success">εισάγει</strong> τους <strong class="text-success">νέους μαθητές.</strong></div>
                <a href="{{url('/instructions.pdf')}}" target="_blank" class="link-info">Κατεβάστε από εδώ οδηγίες για την εξαγωγή της επιθυμητής αναφοράς από το myschool</a>
                
                <form action="{{url('/upload_student_template')}}" method="post" class="container-fluid" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="file" name="import_students" > 
                    <button type="submit" class="btn btn-primary bi bi-filetype-xlsx"> Αποστολή αρχείου</button>
                </form>
                </div>
            </nav>
            @else
            <div style="p-3 mb-2 bg-info text-dark">
                Διαβάστηκαν οι ακόλουθοι μαθητές από το αρχείο:
            </div>
            @php
            $no_of_students = 1;  
            @endphp
            <div class="table-responsive">
            <table class="table table-striped table-hover table-light">
                <tr>
                    <th>#</th>
                    <th>Αριθμός Μητρώου</th>
                    <th>Βιβλίο Μητρώου</th>
                    <th>Επώνυμο</th>
                    <th>Όνομα</th>
                    <th>Πατρώνυμο</th>
                    <th>Τάξη</th>
                    
                </tr>
                @foreach($students_array as $student)
                    <tr> 
                        <td>{{$no_of_students}}</td> 
                        <td @if ($student['am']=="Κενό πεδίο" or $student['am']=="Ο Α.Μ. χρησιμοποιείται") style='color:red;' @endif>{{$student['am']}}</td>
                        <td @if ($student['bm']=="Κενό πεδίο") style='color:red;' @endif>{{$student['bm']}}</td>
                        <td @if ($student['surname']=='Κενό πεδίο') style='color:red;' @endif>{{$student['surname']}}</td>
                        <td @if ($student['name']=='Κενό πεδίο') style='color:red;' @endif>{{$student['name']}}</td>
                        <td>{{$student['f_name']}}</td>
                        <td @if ($student['class']=='Κενό πεδίο') style='color:red;' @endif>{{$student['class']}}</td>
                        
                    </tr>
                @php
                    $no_of_students++;
                @endphp
                @endforeach
            </div>
            </table>
                @if($asks_to=='save')
                Να προχωρήσει η εισαγωγή αυτών των στοιχείων;
                <div class="row">
                    <form action="{{url('/insert_students')}}" method="post" class="col container-fluid" enctype="multipart/form-data">
                    @csrf
                        <button type="submit" class="btn btn-primary bi bi-file-arrow-up"> Εισαγωγή</button>
                    </form>
                    <a href="{{url('/student')}}" class="col">Ακύρωση</a>
                </div>
                @else
                <div class="row">
                    <div>
                        Διορθώστε τα σημειωμένα σφάλματα και υποβάλετε εκ νέου το αρχείο.
                    </div>
                    <a href="{{url('/student')}}" class="col">Ακύρωση</a>
                </div>
                @endif
            @endif
        </div>
    </div>
    </div>
</x-layout>