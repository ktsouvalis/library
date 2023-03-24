<x-layout>
    <div class="container">
        @include('menu')
        <nav class="navbar navbar-light bg-light">
                <form action="/edit_student/{{$student->id}}" method="post" class="container-fluid">
                    @csrf
                    <input type="hidden" name="asks_to" value="insert">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><strong>{{$student->am}} {{$student->surname}} {{$student->name}} {{$student->class}}</strong></span>
                    </div>
                    <div class="input-group">
                        <input name="student_am" type="number" value="{{$student->am}}" class="form-control" placeholder="Αριθμός Μητρώου Μαθητή" aria-label="ΑΜ Μαθητή" aria-describedby="basic-addon2" required>
                    </div>
                    <div class="input-group">
                        <input name="student_surname" type="text" value="{{$student->surname}}"  class="form-control" placeholder="Επώνυμο Μαθητή" aria-label="Επώνυμο Μαθητή" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="student_name" type="text" value="{{$student->name}}" class="form-control" placeholder="Όνομα Μαθητή" aria-label="Όνομα Μαθητή" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="student_fname" type="text" value="{{$student->f_name}}" class="form-control" placeholder="Πατρώνυμο Μαθητή" aria-label="Πατρώνυμο Μαθητή" aria-describedby="basic-addon1" required><br>
                    </div>
                    <div class="input-group">
                        <input name="student_class" type="text" value="{{$student->class}}" class="form-control" placeholder="Τάξη" aria-label="Τάξη" aria-describedby="basic-addon1" required><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Αποθήκευση</button>
                    <a href="/edit_student/{{$student->id}}">Ακύρωση αλλαγών</a>
                </form>
            </nav>
            @isset($dberror)
                <div class="alert alert-danger" role="alert">{{$dberror}}</div>
            @else
                @isset($saved)
                    @if($saved)
                        <div class="alert alert-success" role="alert">Επιτυχής αποθήκευση. Μπορείτε να κλείσετε το παράθυρο</div>
                    @else
                        <div class="alert alert-warning" role="alert">Δεν υπάρχουν αλλαγές προς αποθήκευση</div>
                    @endif
                @endisset
            @endisset
    </div>
</x-layout>