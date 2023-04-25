<x-layout>
    @push('title')
        <title>{{$user->display_name}}</title>
    @endpush
    <div class="p-3 container">
    @include('menu')
        <body>
        <div class="p-3 row">
            <div class="container-md">
                <div class="row rounded-top bg-primary bg-gradient text-wrap">
                    <div class="col">ID</div>
                    <div class="col">DisplayName</div>
                    <div class="col">UserName</div>
                    <div class="col">email</div>
                    <div class="col">createdAt</div>
                    <div class="col">updatedAt</div>
                </div>
                <div class="row rounded-bottom bg-primary p-3 text-wrap" style="">
                    <div class="col"><strong>{{$user->id}}</strong></div>
                    <div class="col"><strong>{{$user->display_name}}</strong></div>
                    <div class="col"><strong>{{$user->name}}</strong></div>
                    <div class="col">{{$user->email}}</div>
                    <div class="col">{{$user->created_at}}</div>
                    <div class="col">{{$user->updated_at}}</div>
                    
                </div>
            </div>
        </div>
        <div class="p-3 row">
            <div class="col-sm-2 " >
                <a href="/edit_user/{{$user->id}}" class="btn btn-primary bi bi-journal-text" style="text-decoration:none;">  Επεξεργασία στοιχείων χρήστη</a>
            </div>
            <div class="col-sm-2">
                <form action="/password_reset" method="post">
                @csrf
                    <input type="hidden" name="user_id" value={{$user->id}}>
                    <td><button class="btn btn-warning bi bi-key-fill" type="submit" onclick="return confirm('Επιβεβαίωση επαναφοράς κωδικού')"> Reset Password </button></td>
                </form>
            </div>
        </div>
    </div>
</x-layout>