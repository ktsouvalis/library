<x-layout>
    <div class="container">
        <nav class="navbar navbar-light bg-light">
                <form action="/edit_user/{{$user->id}}" method="post" class="container-fluid">
                    @csrf
                    <input type="hidden" name="asks_to" value="insert">
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon0">Επεξεργασία Χρήστη</span>
                        <span class="input-group-text w-75" id="basic-addon0"><strong>{{$user->id}} {{$user->name}} {{$user->display_name}}</strong></span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon2">Username</span>
                        <input name="user_name" type="text" value="{{$user->name}}"  class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon2" required><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon3">DisplayName</span>
                        <input name="user_display_name" type="text" value="{{$user->display_name}}" class="form-control" placeholder="DisplayName" aria-label="DisplayName" aria-describedby="basic-addon3" required><br>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text w-25" id="basic-addon4">email</span>
                        <input name="user_email" type="text" value="{{$user->email}}" class="form-control" placeholder="email" aria-label="email" aria-describedby="basic-addon4" required><br>
                    </div>
                    <div class="input-group">
                        <span class="w-25"></span>
                        <button type="submit" class="btn btn-primary m-2">Αποθήκευση</button>
                        <a href="/user_profile/{{$user->id}}" class="btn btn-outline-secondary m-2">Ακύρωση</a>
                </form>
            </nav>
            @isset($dberror)
                <div class="alert alert-danger" role="alert">{{$dberror}}</div>
            @endisset
    </div>
</x-layout>