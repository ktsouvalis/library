

<x-layout>
    <body class="bg-light"></body>
    <div class="container">
        <div class="row p-2 justify-content-evenly">
        @auth
            @push('title')
                <title>Αρχική</title>
            @endpush
            <div class="col-md-4 py-2" style="max-width:15rem; opacity: 0.9">
                <div class="card py-5 text-bg-success"  style="text-align:center;">
                    <a class="" style="text-decoration:none;" href="{{url("/book")}}">
                    <div class="h5 card-title fa-solid fa-book text-white"></div>
                    <div class="text-white">Βιβλία</div>
                    </a> 
                </div>
            </div>

            <div class="col-md-4 py-2" style="max-width:15rem; opacity: 0.9">
                <div class="card py-5 text-bg-warning"  style="text-align:center;">
                    <a class="" style="text-decoration:none;" href="{{url('/student')}}">
                    <div class="h5 card-title fa-solid fa-graduation-cap text-dark"></div>
                    <div class="text-dark">Μαθητές</div>
                    </a> 
                </div>
            </div>

            <div class="col-md-4 py-2" style="max-width:15rem; opacity: 0.9">
                <div class="card py-5 text-bg-danger"  style="text-align:center;">
                    <a class="" style="text-decoration:none;" href="{{url('/loans')}}">
                    <div class="h5 card-title fa-solid fa-book-open-reader text-white"></div>
                    <div class="text-white">Ιστορικό</div>
                    </a> 
                </div>
            </div>

            <div class="col-md-4 py-2" style="max-width:15rem;">
                <div class="card py-5 text-bg-primary"  style="text-align:center;  ">
                    <a class="" style="text-decoration:none;" href="{{url('/stats')}}">
                    <div class="h5 card-title fa-solid fa-chart-simple text-white"></div>
                    <div class="text-white">Στατιστικά</div>
                    </a> 
                </div>
            </div>

            <div class="col-md-4 py-2" style="max-width:15rem;">
                <div class="card py-5 text-bg-dark"  style="text-align:center; opacity: 0.9">
                    <a class="" style="text-decoration:none;" href="{{url('/change_year')}}">
                    <div class="h5 card-title bi bi-arrow-down-up text-white"></div>
                    <div class="text-white">Μεταφορά μαθητών</div>
                    </a> 
                </div>
            </div>
            
            @if (Illuminate\Support\Facades\Auth::id()==2 or Illuminate\Support\Facades\Auth::id()==1)

                <div class="col-md-4 py-2" style="max-width:15rem;">
                    <div class="card py-5 "  style="text-align:center; background-color:DarkKhaki">
                        <a class="" style="text-decoration:none;" href="{{url('/user')}}">
                        <div class="h5 card-title fa-solid fa-users text-dark"></div>
                        <div class="text-dark">Σχολεία</div>
                        </a> 
                    </div>
                </div>

            @endif

            <div class="col-md-4 py-2" style="max-width:15rem;">
                <div class="card py-5 text-bg-dark"  style="text-align:center; opacity: 0.5; ">
                    <a class="" style="text-decoration:none;" href="{{url('/logout')}}">
                    <div class="h5 card-title fa-solid fa-arrow-right-from-bracket text-white"></div>
                    <div class="text-white">Αποσύνδεση</div>
                    </a> 
                </div>
            </div>
        
        @else
        @push('title')
                <title>Σύνδεση</title>
        @endpush
        <div class="row justify-content-md-center">
        <div class="col">
                
        </div>
        <div class="col p-3">
                <img src="{{url('/favicon/index.png')}}" width="200" height="131" alt="books">
        </div>
        <div class="col p-3">
            <form action="{{url('/login')}}" method="post">
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
        <div class="col">
                
        </div>
    </div>
        @endauth
</x-layout>