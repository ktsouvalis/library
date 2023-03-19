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
                        <input name="student_id" type="number" value="{{old('student_id')}}" class="form-control" placeholder="Κωδικός Μαθητή" aria-label="ΑΜ Μαθητή" aria-describedby="basic-addon2">
                    </div>
                    <div class="input-group">
                        <input name="student_surname" type="text" value="{{old('student_surname')}}" class="form-control" placeholder="Επώνυμο Μαθητή" aria-label="Επώνυμο Μαθητή" aria-describedby="basic-addon1"><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Αναζήτηση</button>
                </form>
            </nav>
            @error('student_surname')
                <div class="alert alert-danger" role="alert">Πρέπει να συμπληρώσετε ένα από τα δύο πεδία</div>
            @enderror
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
                    <button type="submit" class="btn btn-primary">tab3</button>
                </form>
            </nav>
            @isset($result3)
                {{$result3}}
            @endisset
        </div>

    </div>
        
    @else
        <h3 style="color:red">Δεν έχετε δικαίωμα πρόσβασης στη σελίδα</h3>
        <p><a href="/">Συνδεθείτε</a></p>
    @endauth
    </div>
</x-layout>