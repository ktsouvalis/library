<x-layout>
<body>
    <div class="container">
    @auth
    @include('menu')
<!--tabs-->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link @isset($active_tab) @if($active_tab=='search') {{'active'}} @endif @else {{'active'}} @endisset" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Αναζήτηση Μαθητή με ΑΜ ή Επώνυμο </button>
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
                <form action="" method="post" class="container-fluid">
                    @csrf
                    <input type="hidden" name="asks_to" value="search">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Εισάγετε Αριθμό Μητρώου ή μέρος του Επωνύμου</span>
                    </div>
                    <div class="input-group">
                        <input name="student_am1" type="number" value="{{old('student_am1')}}" class="form-control" placeholder="Αριθμός Μητρώου Μαθητή" aria-label="ΑΜ Μαθητή" aria-describedby="basic-addon2">
                    </div>
                    <div class="input-group">
                        <input name="student_surname1" type="text" value="{{old('student_surname1')}}" class="form-control" placeholder="Επώνυμο Μαθητή" aria-label="Επώνυμο Μαθητή" aria-describedby="basic-addon1"><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Αναζήτηση</button>
                </form>
            </nav>
            {{-- @error('student_surname1')
                <div class="alert alert-danger" role="alert">Πρέπει να συμπληρώσετε ένα από τα δύο πεδία</div>
            @enderror --}}
            @isset($students)
                @if($students->isEmpty())
                    <div class="alert alert-warning" role="alert">Δε βρέθηκε μαθητής με τα στοιχεία που εισάγατε</div>
                @else
                    @foreach($students as $student)
                        <div class="badge bg-warning text-wrap" style="width: 12rem;">
                            <a href="/profile/{{$student->id}}" target="_blank">{{$student->surname}} {{$student->name}}, {{$student->class}}{{$student->sec}}</a>
                        </div>
                        <br>
                    @endforeach
                @endif
            @endisset
        </div>

        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='import') {{'show active'}} @endif @endisset" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            <nav class="navbar navbar-light bg-light">
                <form action="" method="post" class="container-fluid">
                    @csrf
                    <input type="hidden" name="asks_to" value="import">
                    <button type="submit" class="btn btn-primary">tab2</button>
                </form>
            </nav>
            @isset($result2)
                {{$result2}}
            @endisset
        </div>

        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='insert') {{'show active'}} @endif @endisset" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
            <nav class="navbar navbar-light bg-light">
                <form action="" method="post" class="container-fluid">
                    @csrf
                    <input type="hidden" name="asks_to" value="insert">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Εισαγωγή Μαθητή</span>
                    </div>
                    <div class="input-group">
                        <input name="student_am3" type="number" value="" class="form-control" placeholder="Αριθμός Μητρώου Μαθητή" aria-label="ΑΜ Μαθητή" aria-describedby="basic-addon2" required>
                    </div>
                    <div class="input-group">
                        <input name="student_surname3" type="text" value=""  class="form-control" placeholder="Επώνυμο Μαθητή" aria-label="Επώνυμο Μαθητή" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="student_name3" type="text" value="" class="form-control" placeholder="Όνομα Μαθητή" aria-label="Όνομα Μαθητή" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="student_fname3" type="text" value="" class="form-control" placeholder="Πατρώνυμο Μαθητή" aria-label="Πατρώνυμο Μαθητή" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="student_class3" type="text" value="" class="form-control" placeholder="Τάξη" aria-label="Τάξη" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="student_sec3" type="number" value="}" class="form-control" placeholder="Τμήμα" aria-label="Τμήμα" aria-describedby="basic-addon1" required><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Προσθήκη</button>
                </form>
            </nav>
            @isset($constraint_error)
                <div class="alert alert-danger" role="alert">Υπάρχει ήδη μαθητής με τον Α.Μ. {{$given_am3}} </div>
            @else
                @isset($record)
                    <div class="alert alert-success" role="alert">Έγινε η καταχώρηση με τα εξής στοιχεία:</div></div>
                    {{$record->am}} <br>
                    {{$record->surname}} <br>
                    {{$record->name}}<br>
                    {{$record->f_name}}<br>
                    {{$record->class}}<br>
                    {{$record->sec}}<br>
                @endisset
            @endisset
        </div>
    </div>
    @endauth
    </div>
</x-layout>