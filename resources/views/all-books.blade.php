<x-layout>
<div class="container">
@auth
    @include('menu')
@endauth
@isset($books)
    
    <table class="table table-striped table-hover table-light" >
        <tr>
            <th>Βιβλιοθήκη</th>
            <th>Κωδικός Βιβλίου</th>
            <th>Τίτλος</th>
            <th>Συγγραφέας</th>
            <th>Εκδότης</th>
            <th>Διαθέσιμο</th>
        </tr>
    @foreach($books as $book)
        <tr>
            <td>{{$book->user->email}}</td> 
            <td>{{$book->code}}</td>
            <td>{{$book->title}}</td>
            <td>{{$book->writer}}</td>
            <td>{{$book->publisher}}</td>
            
            @if($book->available)
                <td>Διαθέσιμο</td>
            @else
                <td>-</td>
            @endif
        </tr>
    @endforeach
    <tfoot>
        <tr>
            <th id="search">Κωδικός Βιβλίου</th>
            <th id="search">Τίτλος</th>
            <th id="search">Συγγραφέας</th>
            <th id="search">Εκδότης</th>
            <th id="search">Θεματική</th>
            <th id="search">Δανεισμός / Επιστροφή</th>
        </tr>
    </tfoot>
    </table>
@endisset
</div>
</x-layout>