<x-layout>
@php
    $user = Illuminate\Support\Facades\Auth::user();
@endphp
@push('title')
    <title>Διαγραφή Βάσης Σχολείου</title>
@endpush
<body>
    <div class="container">
        @include('menu')
        <hr>
        <div class='vstack gap-4'> 
            <form action='{{url("/reset_books/$user->id")}}' method="post">
            @csrf
                <button class="btn btn-danger bi bi-book " onclick="return confirm('Με τη διαγραφή των βιβλίων θα διαγραφεί και το ιστορικό των δανεισμών. Είστε βέβαιοι;')" style="width:100%; height:100%;"> Διαγραφή Βιβλίων και Δανεισμών</button>
            </form>

            <form action='{{url("/reset_students/$user->id")}}' method="post">
            @csrf
                <button class="btn btn-danger bi bi-person " onclick="return confirm('Με τη διαγραφή των μαθητών θα διαγραφεί και το ιστορικό των δανεισμών. Είστε βέβαιοι;')" style="width:100%; height:100%;"> Διαγραφή Μαθητών και Δανεισμών</button>
            </form>

            <form action='{{url("/reset_loans/$user->id")}}' method="post">
            @csrf
                <button class="btn btn-danger bi bi-journal-arrow-up " onclick="return confirm('Θα διαγραφεί και το ιστορικό των δανεισμών. Είστε βέβαιοι;')" style="width:100%; height:100%;"> Διαγραφή Δανεισμών</button>
            </form>
        </div>
    </div>
</x-layout>