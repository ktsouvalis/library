

<x-layout>
    <body class="bg-light">
  
      <br><br><br><br><br><br>
    <div class="container">
       <div class="d-flex justify-content-center"><p class="h3"> {{env('APP_NAME')}}</p></div>

        {{-- <div class="d-flex justify-content-center"><div class="h1 fa-solid fa-school text-secondary"></div></div> --}}
        {{-- <i class="fa-solid fa-circle-l">L</i> <i class="fa-solid fa-circle-i">I</i> <i class="fa-solid fa-circle-b">B</i> <i class="fa-solid fa-circle-r">R</i> <i class="fa-solid fa-circle-a">A</i> <i class="fa-solid fa-circle-r">R</i><i class="fa-solid fa-circle-y">Y</i> --}}
        {{-- <div class="h2 fa-solid fa-circle-l" style="color: #419c4d;"></div> --}}
        <div class="row p-2 justify-content-evenly">
            
        @auth
            <a class="col-lg-3 card text-bg-success mb-3" style="max-width: 20rem; opacity: 0.9;" href="/book">
                <div class="card-body" style="text-align: center; padding: 5rem">
                <h5 class=" card-title fa-solid fa-book"> Βιβλία</h5>
                <p class="card-text"></p>
                </div> 
            </a>
            <a class="col-lg-3 card text-bg-warning mb-3" style="max-width: 20rem; opacity: 0.9;" href="/student">
                <div class="card-body" style="text-align: center; padding: 5rem">
                <h5 class=" fa-solid fa-graduation-cap card-title"> Μαθητές</h5>
                <p class="card-text"></p>
                </div> 
            </a>
            <a class="col-lg-3 card text-bg-danger mb-3" style="max-width: 20rem; opacity: 0.9;" href="/loans">
                <div class="card-body" style="text-align: center; padding: 5rem">
                <h5 class=" fa-solid fa-book-open-reader card-title"> Δανεισμοί</h5>
                <p class="card-text"></p>
                </div> 
            </a>
            <a class="col-lg-3 card w-3 text-bg-dark mb-3" style="max-width: 20rem; opacity: 0.5;" href="/logout">
                <div class="card-body" style="text-align: center; padding: 5rem">
                <h5 class="card-title fa-solid fa-arrow-right-from-bracket"> Αποσύνδεση</h5>
                <p class="card-text"></p>
                </div> 
            </a>
        @else
        {{-- <a class="col-lg-3 card text-bg-primary mb-3" style="max-width: 20rem; opacity: 0.9;" href="/all-books">
                <div class="card-body" style="text-align: center; padding: 5rem">
                  <h5 class="card-title">Κατάλογος Βιβλίων</h5>
                  <p class="card-text"></p>
                </div> 
        </a> --}}
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