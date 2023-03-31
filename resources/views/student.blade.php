<x-layout>
<body>
    <div class="container">
    @include('menu')
<!--tabs-->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link @isset($active_tab) @if($active_tab=='search') {{'active'}} @endif @else {{'active'}} @endisset" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Αναζήτηση Μαθητή με βάση το επώνυμο </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link @isset($active_tab) @if($active_tab=='import') {{'active'}} @endif @endisset" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">Μαζική Εισαγωγή Μαθητών</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link @isset($active_tab) @if($active_tab=='insert') {{'active'}} @endif @endisset" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3" aria-selected="false">Εισαγωγή μαθητή</button>
        </li>
    </ul>
<!--tab content-->
    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='search') {{'show active'}}  @endif @else {{'show active'}} @endisset" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <!-- 1st tab's content-->
            <nav class="navbar navbar-light bg-light">
                <form action="{{route('search_student')}}" method="post" class="container-fluid">
                    @csrf
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><strong>Εισάγετε μέρος του Επωνύμου</strong></span>
                    </div>
                    <div class="input-group">
                        <input name="student_surname1" type="text" value="" class="form-control" placeholder="Επώνυμο Μαθητή" aria-label="Επώνυμο Μαθητή" aria-describedby="basic-addon1" required><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Αναζήτηση</button>
                </form>
            </nav>
            @isset($students)
                @if($students->isEmpty())
                    <div class="alert alert-warning" role="alert">Δε βρέθηκε μαθητής με τα στοιχεία που εισάγατε</div>
                @else
                    @foreach($students as $student)
                        <div class="m-2 col-sm-2 btn btn-warning text-wrap">
                            <a href="/student_profile/{{$student->id}}" style="color:black">{{$student->am}}, {{$student->surname}} {{$student->name}}, {{$student->class}}</a>
                        </div>
                    @endforeach
                @endif
            @endisset
            @isset($all_students)
                <table class="table table-striped table-hover table-light" >
                    <tr>
                        <th>Αριθμός Μητρώου</th>
                        <th>Επώνυμο</th>
                        <th>Όνομα</th>
                        <th>Πατρώνυμο</th>
                        <th>Τάξη</th>
                    </tr>
                    @foreach($all_students as $student)
                        <tr>  
                            <td>{{$student->am}}</td>
                            <td><div class="badge bg-warning text-wrap"><a href="/student_profile/{{$student->id}}" style="color:black">{{$student->surname}}</a></div></td>
                            <td>{{$student->name}}</td>
                            <td>{{$student->f_name}}</td>
                            <td>{{$student->class}}</td>
                        </tr>
                    @endforeach
                </table>
            @endisset
        </div>

        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='import') {{'show active'}} @endif @endisset" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            @if(empty($asks_to))
            <nav class="navbar navbar-light bg-light">
                <a href="/students.xlsx" class="link-info">Πρότυπο αρχείο για συμπλήρωση</a>
                <form action="{{route('student_template_upload')}}" method="post" class="container-fluid" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="file" name="import_students" > 
                    <button type="submit" class="btn btn-primary">Εισαγωγή αρχείου</button>
                </form>
            </nav>
            @else
            <div style="p-3 mb-2 bg-info text-dark">
                Διαβάστηκαν οι ακόλουθοι μαθητές από το αρχείο:
            </div>
            
            <table class="table table-striped table-hover table-light">
                <tr>
                    <th>Αριθμός Μητρώου</th>
                    <th>Επίθετο</th>
                    <th>Όνομα</th>
                    <th>Πατρώυνμο</th>
                    <th>Τάξη</th>
                    
                </tr>
                @foreach($students_array as $student)
                    <tr>  
                        <td @if ($student['am']=="Κενό πεδίο") style='color:red;' @endif>{{$student['am']}}</td>
                        <td @if ($student['surname']=='Κενό πεδίο') style='color:red;' @endif>{{$student['surname']}}</td>
                        <td @if ($student['name']=='Κενό πεδίο') style='color:red;' @endif>{{$student['name']}}</td>
                        <td @if ($student['f_name']=='Κενό πεδίο') style='color:red;' @endif>{{$student['f_name']}}</td>
                        <td @if ($student['class']=='Κενό πεδίο') style='color:red;' @endif>{{$student['class']}}</td>
                        
                    </tr>
                @endforeach
            </table>
                @if($asks_to=='save')
                Να προχωρήσει η εισαγωγή αυτών των στοιχείων;
                <div class="row">
                    <form action="/students_insertion" method="post" class="col container-fluid" enctype="multipart/form-data">
                    @csrf
                        <button type="submit" class="btn btn-primary">Εισαγωγή</button>
                    </form>
                    <a href="/student" class="col">Ακύρωση</a>
                </div>
                @else
                <div class="row">
                    <div>
                        Διορθώστε τα σημειωμένα σφάλματα και υποβάλετε εκ νέου το αρχείο.
                    </div>
                    <a href="/student" class="col">Ακύρωση</a>
                </div>
                @endif
            @endif
        </div>

        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='insert') {{'show active'}} @endif @endisset" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
            <nav class="navbar navbar-light bg-light">
                <form action="{{route('insert_student')}}" method="post" class="container-fluid">
                    @csrf
                    <input type="hidden" name="asks_to" value="insert">
                    <div class="input-group">
                        <span class="input-group-text w-25"></span>
                        <span class="input-group-text w-75"><strong>Εισαγωγή νέου Μαθητή</strong></span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon1">Αριθμός Μητρώου</span>
                        <input name="student_am3" type="number" value="" class="form-control" placeholder="Αριθμός Μητρώου Μαθητή" aria-label="ΑΜ Μαθητή" aria-describedby="basic-addon1" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon2">Επώνυμο</span>
                        <input name="student_surname3" type="text" class="form-control" placeholder="Επώνυμο Μαθητή" aria-label="Επώνυμο Μαθητή" aria-describedby="basic-addon2" required value=@isset($dberror) {{$old_data['student_surname3']}} @endisset><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon3">Όνομα</span>
                        <input name="student_name3" type="text" class="form-control" placeholder="Όνομα Μαθητή" aria-label="Όνομα Μαθητή" aria-describedby="basic-addon3" required value=@isset($dberror) {{$old_data['student_name3']}} @endisset><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon4">Πατρώνυμο</span>
                        <input name="student_fname3" type="text" class="form-control" placeholder="Πατρώνυμο Μαθητή" aria-label="Πατρώνυμο Μαθητή" aria-describedby="basic-addon4" required value=@isset($dberror) {{$old_data['student_fname3']}} @endisset ><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon5">Τάξη</span>
                        <input name="student_class3" type="text" class="form-control" placeholder="Τάξη" aria-label="Τάξη" aria-describedby="basic-addon5" required value=@isset($dberror) {{$old_data['student_class3']}} @endisset ><br>
                    </div>
                    <div class="input-group">
                        <span class="w-25"></span>
                        <button type="submit" class="btn btn-primary m-2">Προσθήκη</button>
                        <a href="/student" class="btn btn-outline-secondary m-2">Ακύρωση</a>
                    
                </form>
            </nav>
            @isset($dberror)
                <div class="alert alert-danger" role="alert">{{$dberror}}</div>
            @else
                @isset($record)
                    <div class="alert alert-success" role="alert">Έγινε η καταχώρηση με τα εξής στοιχεία:</div>
                    <div class="m-2 col-sm-2 btn btn-warning text-wrap">
                        <a href="/student_profile/{{$record->id}}" style="color:black">{{$record->am}}, {{$record->surname}} {{$record->name}}, {{$record->class}}</a>
                    </div>
                @endisset
            @endisset
        </div>
    </div>
    </div>
</x-layout>