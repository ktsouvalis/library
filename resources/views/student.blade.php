<x-layout>
<body>
    <div class="container">
    @auth
    @include('menu')
<!--tabs-->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link @isset($active_tab) @if($active_tab=='surname') {{'active'}} @endif @else {{'active'}} @endisset" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Αναζήτηση Μαθητή με Επώνυμο</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link @isset($active_tab) @if($active_tab=='id') {{'active'}} @endif @endisset" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="true">Αναζήτηση Μαθητή με Α.Μ.</button>
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
        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='surname') {{'show active'}}  @endif @else {{'show active'}} @endisset" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <!-- 1st tab's content-->
            <nav class="navbar navbar-light bg-light">
                <form action="" method="post" class="container-fluid">
                @csrf
                @error('student_surname')
                    {{$message}}
                @enderror
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">Αναζήτηση με Επώνυμο:</span>
                </div>
                <div class="input-group">
                <input name="student_surname" type="text" value="{{old('student_surname')}}" class="form-control" placeholder="Επώνυμο Μαθητή" aria-label="Επώνυμο Μαθητή" aria-describedby="basic-addon1">
                </div>
                <button type="submit" class="btn btn-primary">Αναζήτηση</button>
                </form>
              </nav>
              @isset($student)
              {{-- <div class="badge bg-success text-wrap" style="width: 8rem;">
                  <p>{{$student->surname}}</p>
                  <p>{{$student->name}}</p>
                  {{$student->class}}{{$student->sec}}
              </div> --}}
              {{-- <div class="badge bg-warning text-wrap" style="width: 8rem;">
                  {{$student->surname}} {{$student->name}}, {{$student->class}}{{$student->sec}}
              </div> --}}
              <div class="badge bg-warning text-wrap" style="width: 12rem;">
                  <a href="/profile/{{$student->id}}" target="_blank">{{$student->surname}} {{$student->name}}, {{$student->class}}{{$student->sec}}</a>
              </div>
                 {{-- <br> <a href="/profile/{{$student->id}}" target="_blank">{{$student->surname}} {{$student->name}}, {{$student->class}}{{$student->sec}}</a> --}}
              @endisset
        </div>

        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='id') {{'show active'}} @endif @endisset" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            <!-- 2nd tab's content-->
            <nav class="navbar navbar-light bg-light">
                <form action="" method="post" class="container-fluid">
                @csrf
                @error('student_id')
                    {{$message}}
                @enderror
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon2">Αναζήτηση με Αριθμό Μητρώου:</span>
                </div>
                  <div class="input-group">
                    
                    <input name="student_id" type="number" value="{{old('student_id')}}" class="form-control" placeholder="Κωδικός Μαθητή" aria-label="Κωδικός Μαθητή" aria-describedby="basic-addon2">
                  </div>
                  
                  <button type="submit" class="btn btn-primary">Αναζήτηση</button>
                </form>
              </nav>
              @isset($student)
              {{-- <div class="badge bg-success text-wrap" style="width: 8rem;">
                  <p>{{$student->surname}}</p>
                  <p>{{$student->name}}</p>
                  {{$student->class}}{{$student->sec}}
              </div> --}}
              {{-- <div class="badge bg-warning text-wrap" style="width: 8rem;">
                  {{$student->surname}} {{$student->name}}, {{$student->class}}{{$student->sec}}
              </div> --}}
              <div class="badge bg-warning text-wrap" style="width: 12rem;">
                  <a href="/profile/{{$student->id}}" target="_blank">{{$student->surname}} {{$student->name}}, {{$student->class}}{{$student->sec}}</a>
              </div>
                 {{-- <br> <a href="/profile/{{$student->id}}" target="_blank">{{$student->surname}} {{$student->name}}, {{$student->class}}{{$student->sec}}</a> --}}
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