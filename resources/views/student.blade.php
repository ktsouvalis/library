<x-layout>
<body>
    <div class="container">
    @auth
    @include('menu')
    
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" id="home-tab" aria-current="page" href="#">Αναζήτηση μαθητή</a>
        </li>
        <li class="nav-item" id="profile">
          <a class="nav-link" href="#">Μαζική Εισαγωγή μαθητών</a>
        </li>
        <li class="nav-item" id="contact">
          <a class="nav-link" href="#">Εισαγωγή μαθητή</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">dsfsfhbhdfhdf</div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">lorem ipsum</div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">3</div>
      </div>
        <nav class="navbar navbar-light bg-light">
            <form action="" method="post" class="container-fluid">
            @csrf
            @error('student_id')
                {{$message}}
            @enderror
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">Αναζήτηση με Κωδικό ή Επώνυμο του μαθητή:</span>
            </div>
              <div class="input-group">
                
                <input name="student_id" type="number" value="{{old('student_id')}}" class="form-control" placeholder="Κωδικός Μαθητή" aria-label="Κωδικός Μαθητή" aria-describedby="basic-addon1">
              </div>
              <div class="input-group">
               
                <input name="student_surname" type="text" value="{{old('student_surname')}}" class="form-control" placeholder="Επώνυμο Μαθητή" aria-label="Επώνυμο Μαθητή" aria-describedby="basic-addon1">
              </div>
              <button type="submit" class="btn btn-primary">Αναζήτηση</button>
            </form>
          </nav>
        <br><br>
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
    @else
        <h3 style="color:red">Δεν έχετε δικαίωμα πρόσβασης στη σελίδα</h3>
        <p><a href="/">Συνδεθείτε</a></p>
    @endauth
    </div>
</x-layout>