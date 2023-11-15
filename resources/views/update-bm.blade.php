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
        <div class="alert alert-info text-center">
            <u>Μετά την ενημέρωση που έγινε στις 14/11/2023</u> για την εφαρμογή διαχείρισης σχολικής βιβλιοθήκης και τις επισημάνσεις αρκετών σχολείων που την έχουν χρησιμοποιήσει,
            <b>κρίνεται απαραίτητο να προστεθεί ο Αριθμός Βιβλίου Μητρώου σαν στοιχείο κάθε μαθητή </b>καθώς εντοπίζονται μαθητές με τον ίδιο Αριθμό Μητρώου σε διαφορετικά Βιβλία Μητρώου.
            Στην παρούσα φάση, <b>πριν από κάθε άλλη ενέργεια</b>, θα πρέπει να προστεθεί ο Αριθμός Βιβλίου Μητρώου <u>στους μαθητές που έχουν ήδη εισαχθεί στην εφαρμογή</u>, ώστε σε επόμενη μαζική 
            ανανέωση των μαθητών να μην υπάρχουν διπλοεγγραφές. <br>
        </div>  
        <div class="alert alert-success text-center">
            <strong>ΟΔΗΓΙΕΣ</strong>
            <p>Στο πεδίο <b>Αριθμός Βιβλίου Μητρώου</b> θα εισάγετε τον αριθμό του βιβλίου και έπειτα θα επιλέξετε τους μαθητές στους οποίους θα καταχωριστεί αυτός ο αριθμός. <br>
            Αν έχετε παραπάνω από ένα βιβλία μητρώου, θα πρέπει να επαναλάβετε τη διαδικασία. <br></p>
        </div>
    <nav class="navbar navbar-light bg-light">
    <form action="/update_bm/{{$user->id}}" method="post">
        @csrf
        <div class="vstack gap-2">
            <div>
                <b>Αριθμός Βιβλίου Μητρώου</b>
                <input name="bm" type="number" class="m-2"required>
            </div>
            <div>
                <button type="button" onclick="selectAllCheckboxes()" class="btn btn-secondary m-2">Επιλογή όλων</button>
                <button type="button" onclick="revertSelection()" class="btn btn-secondary m-2">Αντιστροφή επιλογής</button><br>
            </div>
            <b>Μαθητές σχολείου</b>
            <div class="vstack gap-1"> 
            @foreach($user->students->whereNull('bm') as $student)
                <div class="hstack gap-1">
                <input type="checkbox" name="student{{$student->id}}" value="{{$student->id}}" id="student{{$student->id}}">
                <label for="student{{$student->id}}"> {{$student->surname}} {{$student->name}} {{$student->class}}</label>
                </div>
            @endforeach
            </div>
        </div>
            
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