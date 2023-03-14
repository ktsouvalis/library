

<x-layout>
    <body class="bg-light">
  
      <br><br><br><br><br><br>
    <div class="container">
       
        <p class="h3">Βιβλιοθήκη 45ου Δημοτικού Σχολείου Πάτρας</p>
    
        
        <div class="row p-2 justify-content-evenly">
            <a class="col-lg-3 card text-bg-secondary mb-3" style="max-width: 18rem; opacity: 0.7;" href="#">
           
                
                <div class="card-body" style="text-align: center; padding: 5rem">
                  <h5 class="card-title">Κατάλογος Βιβλίων</h5>
                  <p class="card-text"></p>
                </div>
            
            </a>
        @auth
            <a href='/logout'>Αποσύνδεση</a>
            <br><br><br>
            {{-- <h2><a href="#" target="_blank">Εισαγωγή βιβλίων από αρχείο</a></h2>
            <h2><a href="#" target="_blank">Εισαγωγή βιβλίων μέσω φόρμας</a></h2> --}}
            <br><br>
            <h2><a href="#" target="_blank">Αναζήτηση Βιβλίου</a></h2>
            <h2><a href="/search_student">Αναζήτηση Μαθητή με Α.Μ.</a></h2>
            <br><br>
            {{-- <h2><a href="/show_who_books_out" target="_blank">Αναζήτηση δανεισμών ανά τμήμα</a></h2>
            <h2><a href="/number_of_total_outs_per_class" target="_blank">Αριθμός συνολικών δανεισμών ανά τάξη</a></h2>
            <h2><a href="/all_books_to_xlsx" target="_blank">Εξαγωγή Βάσης σε αρχείο xlsx</a></h2> --}}
            <br><br>
            {{-- <h2><a href="#" target="_blank">Επεξεργασία βιβλίου</a></h2> --}}
        @else
    
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