<x-layout>
    <div class="container">
    @include('menu')
    @isset($loans)
        <table class="table table-striped table-hover table-light">
            <tr>
                <th>Κωδικός Βιβλίου</th>
                <th>Τίτλος</th>
                <th>Συγγραφέας</th>
                <th>Εκδότης</th>
                <th>Επίθετο μαθητή</th>
                <th>Όνομα μαθητή</th>
                <th>Τάξη μαθητή</th>
                <th>Ημερομηνία Δανεισμού</th>
                <th>Ημερομηνία Επιστροφής</th>
            </tr>
            @foreach($loans as $loan)
            <form action="/loans/return" method="post">
                @csrf
                <input type="hidden" name="loan_id" value={{$loan->id}}>
                <tr >  
                    <td>{{$loan->book->code}}</td>
                    <td><a href="/book_profile/{{$loan->book->id}}">{{$loan->book->title}}</a></td>
                    <td>{{$loan->book->writer}}</td>
                    <td>{{$loan->book->publisher}}</td>
                    <td><a href="/profile/{{$loan->student->id}}">{{$loan->student->surname}}</a></td>
                    <td>{{$loan->student->name}}</td>
                    <td><strong>{{$loan->student->class}}</strong></td>
                    <td>{{$loan->date_out}}</td>
                    @if($loan->date_in==null)
                        <td><input type="submit" value="Επιστροφή"></td>
                    @else
                        <td>{{$loan->date_in}}</td>
                    @endif
                </tr>
            </form>
            @endforeach
        </table>
        <br>
    σύνολο ενεργών δανεισμών: <strong>{{$loans->whereNull('date_in')->count()}}</strong> από <strong>{{$loans->count()}}</strong>
    @endisset
    </div>
</x-layout>