<x-layout>
<body>
<div class="container bg-light xxl">
    <p class="h3">Βιβλιοθήκη 45ου Δημοτικού Σχολείου Πάτρας</p>
    <div class="d-flex flex row p-2 justify-content-around">
    <div><h2><a href="/show_all_books" target="_blank">Κατάλογος Βιβλίων</a></h2></div>
    @auth
        <a href='/logout'>Αποσύνδεση</a>
        <br><br><br>
        {{-- <h2><a href="#" target="_blank">Εισαγωγή βιβλίων από αρχείο</a></h2>
        <h2><a href="#" target="_blank">Εισαγωγή βιβλίων μέσω φόρμας</a></h2> --}}
        <br><br>
        <h2><a href="#" target="_blank">Αναζήτηση Βιβλίου</a></h2>
        <h2><a href="/search_student">Αναζήτηση Μαθητή</a></h2>
        <br><br>
        {{-- <h2><a href="/show_who_books_out" target="_blank">Αναζήτηση δανεισμών ανά τμήμα</a></h2>
        <h2><a href="/number_of_total_outs_per_class" target="_blank">Αριθμός συνολικών δανεισμών ανά τάξη</a></h2>
        <h2><a href="/all_books_to_xlsx" target="_blank">Εξαγωγή Βάσης σε αρχείο xlsx</a></h2> --}}
        <br><br>
        {{-- <h2><a href="#" target="_blank">Επεξεργασία βιβλίου</a></h2> --}}
    @else
        <form action="/login" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Όνομα Χρήστη</label>
                <div class="">
                    <input type="text" value="{{old('name')}}" name="name" class="form-control">
                    @error('name')
                        {{$message}}
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Κωδικός</label>
                <div class="">
                    <input type="password" name="password" class="form-control">
                    @error('password')
                        {{$message}}
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Είσοδος</button>
        </form>

    @endauth
    </div>

    @if (session()->has('success'))
    <div class='container container--narrow'>
      <div class='alert alert-success text-center'>
        {{session('success')}}
      </div>
    </div>
    @endif

    @if(session()->has('failure'))
    <div class='container container--narrow'>
    <div class='alert alert-danger text-center'>
        {{session('failure')}}
    </div>
    </div>
    @endif    
    
</x-layout>