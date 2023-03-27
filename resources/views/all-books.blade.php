<x-layout>
<div class="container">
@auth
    @include('menu')
@endauth
@isset($books)
    
    <table class="table table-striped table-hover table-light" >
        <tr>
            <th>Κωδικός Βιβλίου</th>
            <th>Τίτλος</th>
            <th>Συγγραφέας</th>
            <th>Εκδότης</th>
            <th>Διαθέσιμο</th>
        </tr>
    @foreach($books as $book)
        <tr>  
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
    </table>
@endisset
</div>
</x-layout>