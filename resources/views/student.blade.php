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
          <button class="nav-link @isset($active_tab) @if($active_tab=='TO_BE_COMPLETED') {{'active'}} @endif @endisset" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3" aria-selected="false">Μαζική Εισαγωγή Μαθητών</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link @isset($active_tab) @if($active_tab=='TO_BE_COMPLETED') {{'active'}} @endif @endisset" id="tab4-tab" data-bs-toggle="tab" data-bs-target="#tab4" type="button" role="tab" aria-controls="tab4" aria-selected="false">Εισαγωγή μαθητή</button>
        </li>
    </ul>
<!--tab content-->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='search') {{'show active'}}  @endif @else {{'show active'}} @endisset" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <!-- 1st tab's content-->
            <nav class="navbar navbar-light bg-light">
                <form action="" method="post" class="container-fluid">
                @csrf
                @error('student_surname')
                    <div class="alert alert-danger" role="alert">Πρέπει να συμπληρώσετε ένα από τα δύο πεδία</div>
                @enderror
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
            @isset($students)
                @foreach($students as $student)
                    <div class="badge bg-warning text-wrap" style="width: 12rem;">
                       <a href="/profile/{{$student->id}}" target="_blank">{{$student->surname}} {{$student->name}}, {{$student->class}}{{$student->sec}}</a>
                    </div>
                    <br>
                @endforeach
            @endisset
        </div>

        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='TO_BE_COMPLETED') {{'show active'}} @endif @endisset" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">Εδώ θα γίνει η μαζική εισαγωγή μαθητών</div>
        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='TO_BE_COMPLETED') {{'show active'}} @endif @endisset" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">Εδώ θα γίνει η εισαγωγή ενός μαθητή</div>
    </div>
        
    @else
        <h3 style="color:red">Δεν έχετε δικαίωμα πρόσβασης στη σελίδα</h3>
        <p><a href="/">Συνδεθείτε</a></p>
    @endauth
    </div>
</x-layout>