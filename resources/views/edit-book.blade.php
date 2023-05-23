<x-layout>
    @push('title')
        <title>Επεξεργασία "{{$book->title}}"</title>
    @endpush
    <div class="container">
        @include('menu')
        <nav class="navbar navbar-light bg-light">
            <form action="/edit_book/{{$book->id}}" method="post" class="container-fluid">
                @csrf
                <div class="input-group">
                    <span class="input-group-text w-25" id="basic-addon0">Επεξεργασία Βιβλίου</span>
                    <span class="input-group-text w-75" id="basic-addon0"><strong>{{$book->code}}, {{$book->title}}, {{$book->writer}}, Εκδόσεις {{$book->publisher}} </strong></span>
                </div>
                <div class="input-group">
                    <span class="input-group-text w-25" id="basic-addon1">Κωδικός</span>
                    <input name="book_code" type="text" value="{{$book->code}}" class="form-control" placeholder="Κωδικός Βιβλίου" aria-label="Κωδικός Βιβλίου" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group">
                    <span class="input-group-text w-25" id="basic-addon2">Συγγραφέας</span>
                    <input name="book_writer" type="text" value="{{$book->writer}}"  class="form-control" placeholder="Συγγραφέας" aria-label="Συγγραφέας" aria-describedby="basic-addon2" required><br>
                </div>
                <div class="input-group">
                    <span class="input-group-text w-25" id="basic-addon3">Τίτλος</span>
                    <input name="book_title" type="text" value="{{$book->title}}" class="form-control" placeholder="Τίτλος" aria-label="Τίτλος" aria-describedby="basic-addon3" required><br>
                </div>
                <div class="input-group">
                    <span class="input-group-text w-25" id="basic-addon4">Εκδόσεις</span>
                    <input name="book_publisher" type="text" value="{{$book->publisher}}" class="form-control" placeholder="Εκδόσεις" aria-label="Εκδόσεις" aria-describedby="basic-addon4" required><br>
                </div>
                <div class="input-group">
                    <span class="input-group-text w-25" id="basic-addon5">Θεματική</span>
                    <input name="book_subject" type="text" value="{{$book->subject}}" class="form-control" placeholder="Θεματική" aria-label="Θεματική" aria-describedby="basic-addon5" ><br>
                </div>
                <div class="input-group">
                    <span class="input-group-text w-25" id="basic-addon6">Τόπος Έκδοσης</span>
                    <input name="book_publish_place" type="text" value="{{$book->publish_place}}" class="form-control" placeholder="Τόπος Έκδοσης" aria-label="Τόπος Έκδοσης" aria-describedby="basic-addon6" ><br>
                </div>
                <div class="input-group">
                    <span class="input-group-text w-25" id="basic-addon7">Έτος Έκδοσης</span>
                    <input name="book_publish_year" type="text" value="{{$book->publish_year}}" class="form-control" placeholder="Χρονολογία Έκδοσης" aria-label="Χρονολογία Έκδοσης" aria-describedby="basic-addon7" ><br>
                </div>
                <div class="input-group">
                    <span class="input-group-text w-25" id="basic-addon8">Αρ. Σελίδων</span>
                    <input name="book_no_of_pages" type="number" value="{{$book->no_of_pages}}" class="form-control" placeholder="Αρ. Σελίδων" aria-label="Αρ. Σελίδων" aria-describedby="basic-addon8" ><br>
                </div>
                <div class="input-group">
                    <span class="input-group-text w-25" id="basic-addon9">Τρόπος Απόκτησης</span>
                    <input name="book_acquired_by" type="text" value="{{$book->acquired_by}}" class="form-control" placeholder="Τρόπος απόκτησης" aria-label="Τρόπος απόκτησης" aria-describedby="basic-addon9" ><br>
                </div>
                <div class="input-group">
                    <span class="input-group-text w-25" id="basic-addon10">Χρονολογία Απόκτησης</span>
                    <input name="book_acquired_year" type="text" value="{{$book->acquired_year}}" class="form-control" placeholder="Χρονολογία απόκτησης" aria-label="Χρονολογία απόκτησης" aria-describedby="basic-addon10" ><br>
                </div>
                <div class="input-group">
                    <span class="input-group-text w-25" id="basic-addon11">Σχόλια</span>
                    <input name="book_comments" type="text" value="{{$book->comments}}" class="form-control" placeholder="Σχόλια" aria-label="Σχόλια" aria-describedby="basic-addon11"><br>
                </div>
                <div class="input-group">
                    <span class="w-25"></span>
                    <button type="submit" class="btn btn-primary m-2 bi bi-save2"> Αποθήκευση</button>
                    <a href="/book_profile/{{$book->id}}" class="btn btn-outline-secondary m-2 bi bi-x-circle"> Ακύρωση</a>
                </div>
                
            </form>
        </nav>
    </div>
</x-layout>