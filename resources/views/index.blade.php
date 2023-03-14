<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Βιβιλιοθήκη</title>
</head>
<body>
    <h1 style="text-align:center;">Βιβλιοθήκη 45ου Δημοτικού Σχολείου Πάτρας</h1>
    <h2><a href="/show_all_books" target="_blank">Κατάλογος Βιβλίων</a></h2><br>
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
        <h2>Login</h2>
        <form action="/login" method="post" >
            @csrf
            <div>
                <label for="name">Όνομα Χρήστη: </label>
                <input type="text" value="{{old('name')}}" name="name">
                @error('name')
                   {{$message}}
                @enderror
                <br><br>
            </div>
            <div>
                <label for="password">Κωδικός Πρόσβασης: </label>
                <input type="password" name="password">
                @error('password')
                    {{$message}}
                @enderror
                <br><br>
            </div>
            <div>
                <input type="submit" value="Είσοδος">
            </div>
        </form>
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
</body>
</html>