<x-layout>
    @push('title')
        <title>{{$user->display_name}}</title>
    @endpush
    <div class="p-3 container">
    @include('menu')
        <body>
        <div class="p-3 row">
            <div class="container-md">
                <div class="row rounded-top bg-gradient text-wrap" style="background-color:DarkKhaki">
                    <div class="col">ID</div>
                    <div class="col">DisplayName</div>
                    <div class="col">UserName</div>
                    <div class="col">email</div>
                    <div class="col">createdAt</div>
                    <div class="col">updatedAt</div>
                    <div class="col"># Βιβλίων</div>
                    <div class="col"># Μαθητών</div>
                    <div class="col"># Δανεισμών</div>
                </div>
                <div class="row rounded-bottom  p-1 text-wrap" style="background-color:DarkKhaki">
                    <div class="col"><strong>{{$user->id}}</strong></div>
                    <div class="col"><strong>{{$user->display_name}}</strong></div>
                    <div class="col"><strong>{{$user->name}}</strong></div>
                    <div class="col">{{$user->email}}</div>
                    <div class="col">{{$user->created_at}}</div>
                    <div class="col">{{$user->updated_at}}</div>
                    <div class="col">{{$user->books->count()}}</div>
                    <div class="col"> <b>Ενεργοί</b> {{$user->students->where('class','<>','0')->count()}} από <b>Σύνολο</b> {{$user->students->count()}}</div>
                    <div class="col">{{$user->loans->count()}}</div>
                    
                </div>
            </div>
        </div>
        <div class="p-3 row">
            <div class="col-sm-2 " >
                <a href="/edit_user/{{$user->id}}" class="btn btn-primary bi bi-journal-text" style="text-decoration:none;">  Επεξεργασία στοιχείων χρήστη</a>
            </div>
            <div class="col-sm-2">
                <form action="/reset_password" method="post">
                @csrf
                    <input type="hidden" name="user_id" value={{$user->id}}>
                    <td><button class="btn btn-warning bi bi-key-fill" type="submit" onclick="return confirm('Επιβεβαίωση επαναφοράς κωδικού')"> Reset Password </button></td>
                </form>
            </div>
            <div class="col">/all_books/{{$user->public_link}}</div>
        </div>
    </div>
</x-layout>