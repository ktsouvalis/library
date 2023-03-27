<x-layout>
    <div class="container">
        @include('menu')
        <nav class="navbar navbar-light bg-light">
            <form action="/edit_book/{{$book->id}}" method="post" class="container-fluid">
                @csrf
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><strong>Στοιχεία Βιβλίου</strong></span>
                </div>
                <div class="input-group">
                    <input name="book_code" type="number" value="{{$book->code}}" class="form-control" placeholder="Κωδικός Βιβλίου" aria-label="Κωδικός Βιβλίου" aria-describedby="basic-addon2" required>
                </div>
                <div class="input-group">
                    <input name="book_writer" type="text" value="{{$book->writer}}"  class="form-control" placeholder="Συγγραφέας" aria-label="Συγγραφέας" aria-describedby="basic-addon1" required><br>
                </div>
                <div class="input-group">
                    <input name="book_title" type="text" value="{{$book->title}}" class="form-control" placeholder="Τίτλος" aria-label="Τίτλος" aria-describedby="basic-addon1" required><br>
                </div>
                <div class="input-group">
                    <input name="book_publisher" type="text" value="{{$book->publisher}}" class="form-control" placeholder="Εκδόσεις" aria-label="Εκδόσεις" aria-describedby="basic-addon1" required><br>
                </div>
                <div class="input-group">
                    <input name="book_subject" type="text" value="{{$book->subject}}" class="form-control" placeholder="Θεματική" aria-label="Θεματική" aria-describedby="basic-addon1" ><br>
                </div>
                <div class="input-group">
                    <input name="book_publish_place" type="text" value="{{$book->publish_place}}" class="form-control" placeholder="Τόπος Έκδοσης" aria-label="Τόπος Έκδοσης" aria-describedby="basic-addon1" ><br>
                </div>
                <div class="input-group">
                    <input name="book_publish_year" type="text" value="{{$book->publish_year}}" class="form-control" placeholder="Χρονολογία Έκδοσης" aria-label="Χρονολογία Έκδοσης" aria-describedby="basic-addon1" ><br>
                </div>
                <div class="input-group">
                    <input name="book_no_of_pages" type="number" value="{{$book->no_of_pages}}" class="form-control" placeholder="Αρ. Σελίδων" aria-label="Αρ. Σελίδων" aria-describedby="basic-addon1" ><br>
                </div>
                <div class="input-group">
                    <input name="book_acquired_by" type="text" value="{{$book->acquired_by}}" class="form-control" placeholder="Τρόπος απόκτησης" aria-label="Τρόπος απόκτησης" aria-describedby="basic-addon1" ><br>
                </div>
                <div class="input-group">
                    <input name="book_acquired_year" type="text" value="{{$book->acquired_year}}" class="form-control" placeholder="Χρονολογία απόκτησης" aria-label="Χρονολογία απόκτησης" aria-describedby="basic-addon1" ><br>
                </div>
                <div class="input-group">
                    <input name="book_comments" type="text" value="{{$book->comments}}" class="form-control" placeholder="Σχόλια" aria-label="Σχόλια" aria-describedby="basic-addon1"><br>
                </div>
                <button type="submit" class="btn btn-primary">Αποθήκευση</button>
                <a href="/edit_book/{{$book->id}}">Ακύρωση αλλαγών</a>
            </form>
        </nav>
        @isset($dberror)
            <div class="alert alert-danger" role="alert">{{$dberror}}</div>
        @endisset
    </div>
</x-layout>