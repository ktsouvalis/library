<x-layout>
<body>
    <div class="container">
    @auth
    @include('menu')
<!--tabs-->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link @isset($active_tab) @if($active_tab=='search') {{'active'}} @endif @else {{'active'}} @endisset" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Αναζήτηση Βιβλίου με βάση τον τίτλο </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link @isset($active_tab) @if($active_tab=='import') {{'active'}} @endif @endisset" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">Μαζική Εισαγωγή Βιβλίων</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link @isset($active_tab) @if($active_tab=='insert') {{'active'}} @endif @endisset" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3" aria-selected="false">Εισαγωγή βιβλίου</button>
        </li>
    </ul>
<!--tab content-->
    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='search') {{'show active'}}  @endif @else {{'show active'}} @endisset" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <!-- 1st tab's content-->
            <nav class="navbar navbar-light bg-light">
                <form action="{{route('search_book')}}" method="post" class="container-fluid">
                    @csrf
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><strong>Εισάγετε μέρος του τίτλου</strong></span>
                    </div>
                    <div class="input-group">
                        <input name="book_title1" type="text" value="" class="form-control" placeholder="Τίτλος Βιβλίου" aria-label="Τίτλος Βιβλίου" aria-describedby="basic-addon1" required><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Αναζήτηση</button>
                </form>
            </nav>
            @isset($books)
                @if($books->isEmpty())
                    <div class="alert alert-warning" role="alert">Δε βρέθηκε βιβλίο με τα στοιχεία που εισάγατε</div>
                @else
                    @foreach($books as $book)
                        <div class="badge bg-warning text-wrap" style="width: 12rem;">
                            <a href="/book_profile/{{$book->id}}" target="_blank">{{$book->code}}, {{$book->title}}, <i>{{$book->writer}}</i>, {{$book->publisher}}</a>
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
                <form action="{{route('insert_book')}}" method="post" class="container-fluid">
                    @csrf
                    <input type="hidden" name="asks_to" value="insert">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><strong>Στοιχεία Βιβλίου</strong></span>
                    </div>
                    <div class="input-group">
                        <input name="book_code3" type="number" value="" class="form-control" placeholder="Κωδικός Βιβλίου" aria-label="Κωδικός Βιβλίου" aria-describedby="basic-addon2" required>
                    </div>
                    <div class="input-group">
                        <input name="book_writer3" type="text" value="@isset($dberror) {{ $old_data['book_writer3'] }} @endisset"  class="form-control" placeholder="Συγγραφέας" aria-label="Συγγραφέας" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="book_title3" type="text" value="@isset($dberror) {{ $old_data['book_title3'] }} @endisset" class="form-control" placeholder="Τίτλος" aria-label="Τίτλος" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="book_publisher3" type="text" value="@isset($dberror) {{ $old_data['book_publisher3'] }} @endisset" class="form-control" placeholder="Εκδόσεις" aria-label="Εκδόσεις" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="book_subject3" type="text" value="@isset($dberror) {{ $old_data['book_subject3'] }} @endisset" class="form-control" placeholder="Θεματική" aria-label="Θεματική" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="book_publish_place3" type="text" value="@isset($dberror) {{ $old_data['book_publish_place3'] }} @endisset" class="form-control" placeholder="Τόπος Έκδοσης" aria-label="Τόπος Έκδοσης" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="book_publish_year3" type="text" value="@isset($dberror) {{ $old_data['book_publish_year3'] }} @endisset" class="form-control" placeholder="Χρονολογία Έκδοσης" aria-label="Χρονολογία Έκδοσης" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="book_no_of_pages3" type="number" value="@isset($dberror) {{ $old_data['book_no_of_pages3'] }} @endisset" class="form-control" placeholder="Αρ. Σελίδων" aria-label="Αρ. Σελίδων" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="book_acquired_by3" type="text" value="@isset($dberror) {{ $old_data['book_acquired_by3'] }} @endisset" class="form-control" placeholder="Τρόπος απόκτησης" aria-label="Τρόπος απόκτησης" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="book_acquired_year3" type="text" value="@isset($dberror) {{ $old_data['book_acquired_year3'] }} @endisset" class="form-control" placeholder="Χρονολογία απόκτησης" aria-label="Χρονολογία απόκτησης" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="book_comments3" type="text" value="@isset($dberror) {{ $old_data['book_comments3'] }} @endisset" class="form-control" placeholder="Σχόλια" aria-label="Σχόλια" aria-describedby="basic-addon1" required><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Προσθήκη</button>
                </form>
            </nav>
            @isset($dberror)
                <div class="alert alert-danger" role="alert">{{$dberror}}</div>
            @else
                @isset($record)
                    <div class="alert alert-success" role="alert">Έγινε η καταχώρηση με τα εξής στοιχεία:</div>
                        <div class="badge bg-warning text-wrap" style="width: 12rem;">
                            <a href="/book_profile/{{$record->id}}" target="_blank">{{$record->code}}, {{$record->writer}}, <i>{{$record->title}}</i>, {{$record->publisher}}</a>
                        </div>
                    </div>
                @endisset
            @endisset
        </div>
    </div>
    @endauth
    </div>
</x-layout>