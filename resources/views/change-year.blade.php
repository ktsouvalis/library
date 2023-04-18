<x-layout>
    <div class="container py-3">
        Για να γίνει αλλαγή σχολικής χρονιάς πρέπει να γνωρίζετε τα εξής:
        <ul>
            <li> Όλοι οι μαθητές της ΣΤ' τάξης θα πάρουν την τιμή <strong>ΑΠΟΦΟΙΤΟΣ</strong> στο πεδίο ΤΑΞΗ. </li>
            <li> <strong>ΔΕ</strong> θα μπορεί να γίνει αναζήτηση απόφοιτου μαθητή</li>
            <li> <strong>ΔΕ</strong> θα διαγραφεί το ιστορικό των δανεισμών των αποφοίτων</li>
            <li> Οι μαθητές όλων των υπόλοιπων τάξεων θα μεταφερθούν στην επόμενη τάξη και <strong>ΔΕ</strong> θα αλλάξουν τμήμα</li>
            <li> Οι μαθητές της Α' τάξης θα πρέπει να εισαχθούν <strong>μαζικά</strong> από την καρτέλα "Μαζική εισαγωγή μαθητών" <br>ή <strong>μεμονωμένα</strong> από την καρτέλα "Εισαγωγή μαθητή" </li>
            <li><strong>Η ενέργεια δεν είναι αναιρέσιμη!</strong> </li>
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