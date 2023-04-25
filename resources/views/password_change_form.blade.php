<x-layout>
    @push('title')
        <title>Αλλαγή Κωδικού Πρόσβασης</title>
    @endpush
    <div class="container">
    @include('menu')
    <form action='/password_change' method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="pass1">Νέος Κωδικός</label>
            <input type="password" class="form-control" name="pass1" required>
        </div>
        <div class="form-group">
            <label for="pass2">Επιβεβαίωση Κωδικού</label>
            <input type="password" class="form-control"  name="pass1_confirmation" required>
            <small class="form-text text-muted">Ο νέος σας κωδικός πρέπει να αποτελείται από τουλάχιστον 6 χαρακτήρες</small>  
        </div>
  <button type="submit" class="btn btn-primary">Αλλαγή Κωδικού</button>
</form>
</div>
</x-layout>