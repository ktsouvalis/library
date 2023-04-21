

<x-layout>
    <body class="bg-light"></body>
    <br><br><br><br><br><br>
    <div class="container">
        <div class="row p-2 justify-content-evenly">
        @auth
            @push('title')
                <title>Αρχική</title>
            @endpush
            <a class="col-lg-3 card w-3 text-bg-success mb-3" data-toggle="tooltip" title="Αναζήτηση, Δανεισμός, Επιστροφή, Επεξεργασία" style="max-width: 20rem; opacity: 0.9; text-decoration:none;" href="/book">
                <div class="card-body" style="text-align: center; padding: 5rem">
                <div class=" h5 card-title fa-solid fa-book"></div>
                <div>Βιβλία</div>
                <p class="card-text"></p>
                </div> 
            </a>
            <a class="col-lg-3 card w-3 text-bg-warning mb-3" data-toggle="tooltip" title="Αναζήτηση, Δανεισμός, Επιστροφή, Επεξεργασία" style="max-width: 20rem; opacity: 0.9; text-decoration:none;" href="/student">
                <div class="card-body" style="text-align: center; padding: 5rem">
                <div class=" h5 fa-solid fa-graduation-cap card-title"></div>
                <div>Μαθητές</div>
                <p class="card-text"></p>
                </div> 
            </a>
            <a class="col-lg-3 card w-3 text-bg-danger mb-3" style="max-width: 20rem; opacity: 0.9; text-decoration:none;" href="/loans">
                <div class="card-body" style="text-align: center; padding: 5rem">
                <div class="h5 fa-solid fa-book-open-reader card-title"></div>
                <div>Ιστορικό</div>
                <p class="card-text"></p>
                </div> 
            </a>
            <a class="col-lg-3 card w-3 text-bg-primary mb-3" style="max-width: 20rem; text-decoration:none;" href="/stats">
                <div class="card-body" style="text-align: center; padding: 5rem">
                <div class=" h5 fa-solid fa-chart-simple card-title"></div>
                <div>Στατιστικά</div>
                <p class="card-text"></p>
                </div> 
            </a>
            <a class="col-lg-3 card w-3 text-bg-dark mb-3" style="max-width: 20rem; opacity: 0.9; text-decoration:none;" href="/change_year">
                <div class="card-body" style="text-align: center; padding: 5rem">
                <div class=" h5 fa-solid fa-arrow-right-arrow-left card-title"></div>
                <div>Μεταφορά Μαθητών</div>
                <p class="card-text"></p>
                </div> 
            </a>
            @if (Illuminate\Support\Facades\Auth::id()==2 or Illuminate\Support\Facades\Auth::id()==1)
                <a class="col-lg-3 card w-3 text-bg-primary mb-3" style="max-width: 20rem; opacity: 0.4; text-decoration:none;" href="/user">
                <div class="card-body" style="text-align: center; padding: 5rem">
                <div class="h5 card-title fa-solid fa-users"></div>
                <div>Διαχείριση Σχολείων</div>
                <p class="card-text"></p>
                </div> 
                </a>
            @endif
            <a class="col-lg-3 card w-3 text-bg-dark mb-3" style="max-width: 20rem; opacity: 0.5; text-decoration:none;" href="/logout">
                <div class="card-body" style="text-align: center; padding: 5rem">
                <div class="h5 card-title fa-solid fa-arrow-right-from-bracket"></div>
                <div>Αποσύνδεση</div>
                <p class="card-text"></p>
                </div> 
            </a>
        @else
        @push('title')
                <title>Σύνδεση</title>
        @endpush
        <div class="col-lg-3 p-3">
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
        </div>
        @endauth
</x-layout>