<x-layout>
    @push('title')
        <title>Αλλαγή Κωδικού Πρόσβασης</title>
    @endpush
    @php
        $user= Auth::user();
        $link = $user->public_link;
    @endphp
    @push('copy_script')
        @auth
            <p class="text-muted text-center">
                Αυτόν τον σύνδεσμο μπορείτε να τον διαμοιραστείτε για να δώσετε πρόσβαση στον κατάλογο των βιβλίων σας
            </p>
            @php $path = env('APP_URL')."/all_books/".$link; @endphp
            <div class="d-flex justify-content-center"><input type="text" style="width: 500px" id="public_link" value="{{$path}}"></div>
            <div class="d-flex justify-content-center"> <button value="copy" class="btn btn-primary bi bi-clipboard" onClick="copyToClipboard('public_link')"> Copy</button></div>  
            <p>
            <div class="d-flex justify-content-center" >
                <div class="card py-2 px-2"  style="text-align:center; background-color:gainsboro">
                    <div class="h3 card-title fa-regular fa-eye"></div>
                    <div class="h3">{{$user->public_visit_counter->public_visits}}</div>
                    <div class="text-muted">Επισκέψεις</div>
                </div>
            </div>
            </p>
            {{-- <div class="d-flex justify-content-center">Αριθμός επισκεπτών: {{$user->public_visit_counter->public_visits}}</div> --}}
            @endauth
            <script>
                function copyToClipboard(id) {
                    document.getElementById(id).select();
                    document.execCommand('copy');
                    alert('Link copied');
                }
            </script>
    @endpush
    <div class="container">
    @include('menu')
    <form action="{{url('/change_password')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="pass1">Νέος Κωδικός</label>
            <input type="password" class="form-control" name="pass1" required>
        </div>
        <div class="form-group">
            <label for="pass2">Επιβεβαίωση Κωδικού</label>
            <input type="password" class="form-control"  name="pass2" required>
            <small class="form-text text-muted">Ο νέος σας κωδικός πρέπει να αποτελείται από τουλάχιστον 6 χαρακτήρες</small>  
        </div>
  <button type="submit" class="bi bi-key-fill btn btn-primary"> Αλλαγή Κωδικού</button>
</form>
</div>
</x-layout>