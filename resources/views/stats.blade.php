<x-layout>
    @push('title')
        <title>Στατιστικά</title>
    @endpush
    <div class="container" >
        @include('menu')
        <br><br>
        <div class="row">
        <div class="col">
        <div class="text-primary" style="text-align:center;"><strong>Αγαπημένα Βιβλία</strong></div><br>
        <table class="display table table-sm table-striped table-hover table-bordered">
                <tr>
                    <th>Κωδικός</th>
                    <th>Τίτλος</th>
                    <th>Συγγραφέας</th>
                    <th>Εκδότης</th>
                    <th>Δανεισμοί</th>
                </tr>
                @foreach ($to_show['top5books'] as $key=>$value)
                    @php
                        $book_id = $key;
                        $book = App\Models\Book::find($book_id);
                    @endphp
                    <tr>
                        <td>{{$book->code}}</td>
                        <td><div class="badge bg-success text-wrap"><a href="/book_profile/{{$book->id}}" style="color:white;text-decoration:none;">{{$book->title}}</a><div></div></td>
                        <td>{{$book->writer}}</td>
                        <td>{{$book->publisher}}</td>
                        <td><strong>{{$value}}</strong></td>
                    </tr>
                @endforeach
        </table>
        <br><br>
        </div>
        <div class="col">
        <div class="text-primary" style="text-align:center;"><strong>Βιβλιοφάγοι</strong></div><br>
        <table class="display table table-sm table-striped table-hover table-bordered">
                <tr>
                    <th>Α.Μ.</th>
                    <th>Eπώνυμο</th>
                    <th>Όνομα</th>
                    <th>Τάξη</th>
                    <th>Δανεισμοί</th>
                </tr>
                @foreach ($to_show['top5students'] as $key=>$value)
                    @php
                        $student_id = $key;
                        $student = App\Models\Student::find($student_id);
                    @endphp
                    <tr>
                        <td>{{$student->am}}</td>
                        <td><div class="badge bg-warning text-wrap"><a href="/student_profile/{{$student->id}}" style="color:black; text-decoration:none;">{{$student->surname}}</a></div></td>
                        <td>{{$student->name}}</td>
                        <td>{{$student->class}}</td>
                        <td><strong>{{$value}}</strong></td>
                    </tr>
                @endforeach
        </table>
        </div>
        </div>
    </div>

</x-layout>