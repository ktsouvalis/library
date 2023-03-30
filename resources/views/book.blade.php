<x-layout>
<body>
<div class="container">
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
                        <input name="book_code1" type="text" value="" class="form-control" placeholder="Κωδικός Βιβλίου" aria-label="Κωδικός Βιβλίου" aria-describedby="basic-addon1"><br>
                    </div>
                    <div class="input-group">
                        <input name="book_title1" type="text" value="" class="form-control" placeholder="Τίτλος Βιβλίου" aria-label="Τίτλος Βιβλίου" aria-describedby="basic-addon1"><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Αναζήτηση</button>
                </form>
            </nav>
            @isset($uierror)
                <div class="alert alert-danger" role="alert"> {{$uierror}}</div>
            @else
                @isset($books)
                    @if($books->isEmpty())
                        <div class="alert alert-warning" role="alert">Δε βρέθηκε βιβλίο με τα στοιχεία που εισάγατε</div>
                    @else
                        @foreach($books as $book)
                            <div class="m-3 col-sm-2 btn btn-success text-wrap">
                                <a href="/book_profile/{{$book->id}}" style="color:white">{{$book->code}}, {{$book->title}}, <i>{{$book->writer}}</i>, {{$book->publisher}}</a>
                            </div>
                        @endforeach
                    @endif
                @endisset
            @endisset
            @isset($all_books)
                <table class="table table-striped table-hover table-light" >
                    <tr>
                        <th>Κωδικός Βιβλίου</th>
                        <th>Τίτλος</th>
                        <th>Συγγραφέας</th>
                        <th>Εκδότης</th>
                        <th>Διαθέσιμο</th>
                    </tr>
                    @foreach($all_books as $book)
                        <tr>  
                            <td>{{$book->code}}</td>
                            <td><div class="badge bg-success text-wrap"><a href="/book_profile/{{$book->id}}" style="color:white">{{$book->title}}</a><div></div></td>
                            <td>{{$book->writer}}</td>
                            <td>{{$book->publisher}}</td>
                            
                            @if($book->available)
                                <td>Διαθέσιμο</td>
                            @else
                                <td>-</td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            @endisset
        </div>

        <div class="tab-pane fade @isset($active_tab) @if($active_tab=='import') {{'show active'}} @endif @endisset" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            @if(empty($asks_to))
            <nav class="navbar navbar-light bg-light">
                <a href="/books.xlsx" class="link-info">Πρότυπο αρχείο για συμπλήρωση</a>
                <form action="/book_upload" method="post" class="container-fluid" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="file" name="import_books" > 
                    <button type="submit" class="btn btn-primary">Εισαγωγή αρχείου</button>
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
                        <td @if ($book['code']=="Υπάρχει ήδη ο κωδικός") style='color:red;' @endif>{{$book['code']}}</td>
                        <td @if ($book['title']=='Κάποιο είναι κενό') style='color:red;' @endif>{{$book['title']}}</td>
                        <td @if ($book['writer']=='Κάποιο είναι κενό') style='color:red;' @endif>{{$book['writer']}}</td>
                        <td @if ($book['publisher']=='Κάποιο είναι κενό') style='color:red;' @endif>{{$book['publisher']}}</td>
                        <td @if ($book['publish_year']=='Πρέπει να είναι αριθμός') style='color:red;' @endif>{{$book['publish_year']}}</td>
                        <td @if ($book['no_of_pages']=='Πρέπει να είναι αριθμός') style='color:red;' @endif>{{$book['no_of_pages']}}</td>
                        <td @if ($book['acquired_year']=='Πρέπει να είναι αριθμός') style='color:red;' @endif>{{$book['acquired_year']}}</td>
                    </tr>
                @endforeach
            </table>
                @if($asks_to=='save')
                Να προχωρήσει η εισαγωγή αυτών των στοιχείων;
                <div class="row">
                    <form action="/books_insertion" method="post" class="col container-fluid" enctype="multipart/form-data">
                    @csrf
                        <button type="submit" class="btn btn-primary">Εισαγωγή</button>
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
                        <input name="book_writer3" type="text" class="form-control" placeholder="Συγγραφέας" aria-label="Συγγραφέας" aria-describedby="basic-addon1" required value=@isset($dberror) {{$old_data['book_writer3']}} @endisset><br>
                    </div>
                    <div class="input-group">
                        <input name="book_title3" type="text" class="form-control" placeholder="Τίτλος" aria-label="Τίτλος" aria-describedby="basic-addon1" required value=@isset($dberror) {{$old_data['book_title3']}} @endisset><br>
                    </div>
                    <div class="input-group">
                        <input name="book_publisher3" type="text" class="form-control" placeholder="Εκδόσεις" aria-label="Εκδόσεις" aria-describedby="basic-addon1" required value=@isset($dberror) {{$old_data['book_publisher3']}} @endisset><br>
                    </div>
                    <div class="input-group">
                        <input name="book_subject3" type="text" class="form-control" placeholder="Θεματική" aria-label="Θεματική" aria-describedby="basic-addon1" value=@isset($dberror) {{$old_data['book_subject3']}} @endisset><br>
                    </div>
                    <div class="input-group">
                        <input name="book_publish_place3" type="text" class="form-control" placeholder="Τόπος Έκδοσης" aria-label="Τόπος Έκδοσης" aria-describedby="basic-addon1" value=@isset($dberror) {{$old_data['book_publish_place3']}} @endisset><br>
                    </div>
                    <div class="input-group">
                        <input name="book_publish_year3" type="text" class="form-control" placeholder="Χρονολογία Έκδοσης" aria-label="Χρονολογία Έκδοσης" aria-describedby="basic-addon1" value=@isset($dberror) {{$old_data['book_publish_year3']}} @endisset><br>
                    </div>
                    <div class="input-group">
                        <input name="book_no_of_pages3" type="number"  class="form-control" placeholder="Αρ. Σελίδων" aria-label="Αρ. Σελίδων" aria-describedby="basic-addon1" value=@isset($dberror) {{$old_data['book_no_of_pages3']}} @endisset><br>
                    </div>
                    <div class="input-group">
                        <input name="book_acquired_by3" type="text" class="form-control" placeholder="Τρόπος απόκτησης" aria-label="Τρόπος απόκτησης" aria-describedby="basic-addon1" value=@isset($dberror) {{$old_data['book_acquired_by3']}} @endisset><br>
                    </div>
                    <div class="input-group">
                        <input name="book_acquired_year3" type="text" class="form-control" placeholder="Χρονολογία απόκτησης" aria-label="Χρονολογία απόκτησης" aria-describedby="basic-addon1" value=@isset($dberror) {{$old_data['book_acquired_year3']}} @endisset><br>
                    </div>
                    <div class="input-group">
                        <input name="book_comments3" type="text" class="form-control" placeholder="Σχόλια" aria-label="Σχόλια" aria-describedby="basic-addon1" value=@isset($dberror) {{$old_data['book_comments3']}} @endisset><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Προσθήκη</button>
                </form>
            </nav>
            @isset($dberror)
                <div class="alert alert-danger" role="alert">{{$dberror}}</div>
            @else
                @isset($record)
                    <div class="alert alert-success" role="alert">Έγινε η καταχώρηση με τα εξής στοιχεία:</div>
                        <div class="col-sm-2 btn btn-success text-wrap">
                            <a href="/book_profile/{{$record->id}}" style="color:white">{{$record->code}}, {{$record->writer}}, <i>{{$record->title}}</i>, {{$record->publisher}}</a>
                        </div>
                    </div>
                @endisset
            @endisset
        </div>
    </div>
</div>
</x-layout>