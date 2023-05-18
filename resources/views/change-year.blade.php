<x-layout>
    @push('title')
        <title>Μεταφορά Μαθητών</title>
    @endpush
    <div class="container py-3">
       
        @include('menu')
        @if(App\Models\Student::where('user_id', Illuminate\Support\Facades\Auth::id())->count())
            Για τη μεταφορά μαθητών <strong>σε επόμενη τάξη</strong> πρέπει να τα γνωρίζετε τα εξής:<br><br>
            <ul>
                <li> Στο πεδίο <i>Τάξη</i> οι μαθητές πρέπει να έχουν μία τιμή της μορφής <i><Τάξη><Τμήμα></i> π.χ. ΣΤ2, Α1 κ.ο.κ. </li>
                <li> Όλοι οι μαθητές της ΣΤ' τάξης παίρνουν την τιμή <strong>ΑΠΟΦΟΙΤΟΣ</strong> στο πεδίο ΤΑΞΗ. </li>
                <li> <strong>ΔΕΝ</strong> μπορεί να γίνει αναζήτηση απόφοιτου μαθητή</li>
                <li> <strong class= "text-success">Διατηρείται</strong> ιστορικό των δανεισμών των αποφοίτων</li>
                <li> Οι μαθητές όλων των υπόλοιπων τάξεων μεταφέρονται στην επόμενη τάξη και <strong>ΔΕΝ</strong> αλλάζουν τμήμα</li>
                <li> Οι μαθητές της Α' τάξης θα πρέπει να εισαχθούν <strong>μαζικά</strong> από την καρτέλα "Μαζική Εισαγωγή Μαθητών" <br>ή <strong>μεμονωμένα</strong> από την καρτέλα "Εισαγωγή Μαθητή" </li>
                <li ><strong class="text-danger">Η ενέργεια δεν είναι αναιρέσιμη </strong> </li>
            </ul>
            <form action="/subm_change_year" method="GET">
                Είστε βέβαιοι ότι θέλετε να προχωρήσετε σε αλλαγή έτους;
                <div class="input-group">
                        <span class="w-25"></span>
                        <div class="hstack">
                        <button type="submit" class="btn btn-dark m-2 bi bi-arrow-down-up" onclick="return confirm('Επιβεβαίωση μεταφοράς μαθητών!')"> Μεταφορά μαθητών</button>
                        <a href="/" class="btn btn-outline-secondary m-2 bi bi-x-circle"> Ακύρωση</a>
                        </div>
                </div>
            </form>
        @else
            <div class="bg-danger rounded text-light" style="text-align:center;">
                Δεν υπάρχουν μαθητές για μεταφορά σε επόμενη τάξη
            </div>
        @endif
    </div>
</x-layout>