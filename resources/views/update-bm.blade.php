<x-layout>
    @push('scripts')
    <script>
        // JavaScript code to select all checkboxes
        function selectAllCheckboxes() {
            let checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (let checkbox of checkboxes) {
                checkbox.checked = true;
            }
        }
    
        // JavaScript code to revert selection
        function revertSelection() {
            let checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (let checkbox of checkboxes) {
                checkbox.checked = !checkbox.checked;
            }
        }
    </script>
    @endpush
    @php
        $user = Auth::user();    
    @endphp
    <div class="container">
    <nav class="navbar navbar-light bg-light">
    <form action="/update_bm/{{$user->id}}" method="post">
        @csrf
        
            <b>Αριθμός Βιβλίου Μητρώου</b>
            <input name="bm" type="number" class="m-2"required><br>
            <b>Μαθητές σχολείου</b>
            <div class="vstack gap-1"> 
            @foreach($user->students->whereNull('bm') as $student)
                <div class="hstack gap-1">
                <input type="checkbox" name="student{{$student->id}}" value="{{$student->id}}" id="student{{$student->id}}">
                <label for="student{{$student->id}}"> {{$student->surname}} {{$student->name}} {{$student->class}}</label>
                </div>
            @endforeach
            </div>
            <button type="button" onclick="selectAllCheckboxes()" class="btn btn-secondary m-2">Επιλογή όλων</button>
            <button type="button" onclick="revertSelection()" class="btn btn-secondary m-2">Αντιστροφή επιλογής</button>
        </div>
        <div class="input-group">
            <span class="w-25"></span>
            <button type="submit" class="btn btn-primary m-2 bi bi-save2"> Αποθήκευση</button>
            <a href="{{url("/student_profile/$student->id")}}" class="btn btn-outline-secondary m-2 bi bi-x-circle"> Ακύρωση</a>
        </div>
    </form>
    </nav>
</div>
</x-layout>