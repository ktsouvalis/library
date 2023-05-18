<x-layout>
    @push('title')
        <title>Επεξεργασία {{$student->surname}} {{$student->name}}</title>
    @endpush
    <div class="container">
        @include('menu')
        <nav class="navbar navbar-light bg-light">
                <form action="/edit_student/{{$student->id}}" method="post" class="container-fluid">
                    @csrf
                    <input type="hidden" name="asks_to" value="insert">
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon0">Επεξεργασία Μαθητή</span>
                        <span class="input-group-text w-75" id="basic-addon0"><strong>{{$student->am}} {{$student->surname}} {{$student->name}} {{$student->class}}</strong></span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon1">Αριθμός Μητρώου</span>
                        <input name="student_am" type="number" value="{{$student->am}}" class="form-control" placeholder="Αριθμός Μητρώου Μαθητή" aria-label="ΑΜ Μαθητή" aria-describedby="basic-addon1" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon2">Επώνυμο</span>
                        <input name="student_surname" type="text" value="{{$student->surname}}"  class="form-control" placeholder="Επώνυμο Μαθητή" aria-label="Επώνυμο Μαθητή" aria-describedby="basic-addon2" required><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon3">Όνομα</span>
                        <input name="student_name" type="text" value="{{$student->name}}" class="form-control" placeholder="Όνομα Μαθητή" aria-label="Όνομα Μαθητή" aria-describedby="basic-addon3" required><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon4">Πατρώνυμο</span>
                        <input name="student_fname" type="text" value="{{$student->f_name}}" class="form-control" placeholder="Πατρώνυμο Μαθητή" aria-label="Πατρώνυμο Μαθητή" aria-describedby="basic-addon4" required><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon5">Τάξη</span>
                        <input name="student_class" type="text" value="{{$student->class}}" class="form-control" placeholder="Τάξη" aria-label="Τάξη" aria-describedby="basic-addon5" required><br>
                    </div>
                    <div class="input-group">
                        <span class="w-25"></span>
                        <button type="submit" class="btn btn-primary m-2 bi bi-save2"> Αποθήκευση</button>
                        <a href="/student_profile/{{$student->id}}" class="btn btn-outline-secondary m-2 bi bi-x-circle"> Ακύρωση</a>
                </form>
            </nav>
            @isset($dberror)
                <div class="alert alert-danger" role="alert">{{$dberror}}</div>
            @endisset
    </div>
</x-layout>