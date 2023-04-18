<x-layout>
    
    <div class="container py-3">
        @include('menu')
        Κατά την αλλαγή σχολικής χρονιάς συμβαίνουν τα εξής που πρέπει να τα γνωρίζετε:
        <ul>
            <li> Όλοι οι μαθητές της ΣΤ' τάξης παίρνουν την τιμή <strong>ΑΠΟΦΟΙΤΟΣ</strong> στο πεδίο ΤΑΞΗ. </li>
            <li> <strong>ΔΕΝ</strong> μπορεί να γίνει αναζήτηση απόφοιτου μαθητή</li>
            <li> <strong class= "text-success">Διατηρείται</strong> ιστορικό των δανεισμών των αποφοίτων</li>
            <li> Οι μαθητές όλων των υπόλοιπων τάξεων μεταφέρονται στην επόμενη τάξη και <strong>ΔΕΝ</strong> αλλάζουν τμήμα</li>
            <li> Οι μαθητές της Α' τάξης θα πρέπει να εισαχθούν <strong>μαζικά</strong> από την καρτέλα "Μαζική εισαγωγή μαθητών" <br>ή <strong>μεμονωμένα</strong> από την καρτέλα "Εισαγωγή μαθητή" </li>
            <li ><strong class="text-danger">Η ενέργεια δεν είναι αναιρέσιμη </strong> </li>
        </ul>
        <form action="/subm_change_year" method="GET">
            Είστε βέβαιοι ότι θέλετε να προχωρήσετε σε αλλαγή έτους;
            <div class="input-group">
                    <span class="w-25"></span>
                    <button type="submit" class="btn btn-primary m-2">Αλλαγή Έτους</button>
                    <a href="/" class="btn btn-outline-secondary m-2">Ακύρωση</a>
            </div>
        </form>
    </div>
</x-layout>