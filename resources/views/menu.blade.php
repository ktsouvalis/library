<nav class="navbar navbar-light justify-content-auto py-3 p-3" style="background-color: #e3f2fd;">
    <!-- Navbar content -->
    <div class="badge bg-light text-wrap py-2 m-1" style="width: 12rem;">
        <div class="fa-solid fa-house text-dark"></div>
        <a href="/" style="color:black; text-decoration:none;" class=""> Αρχική</a>
    </div>
    <div class=" badge bg-success text-wrap py-2 m-1" style="width: 12rem; opacity: 0.9;">
        <div class="fa-solid fa-book"></div>
        <a href="{{url("/book")}}" style="color:white; text-decoration:none;" class=""> Βιβλία</a>
    </div>
    <div class=" badge bg-warning text-wrap py-2 m-1" style="width: 12rem; opacity: 0.9;">
        <div class="fa-solid fa-graduation-cap text-dark" ></div>
        <a href="/student" style="color:black; text-decoration:none;" class=""> Μαθητές</a>
    </div>
    <div class=" badge bg-danger text-wrap py-2 m-1" style="width: 12rem; opacity: 0.9;">
        <div class="fa-solid fa-book-open-reader"></div>
        <a href="/loans" style="color:white; text-decoration:none;" class=""> Ιστορικό</a>
    </div>
    @if (Illuminate\Support\Facades\Auth::id()==2 or Illuminate\Support\Facades\Auth::id()==1)
        <div class=" badge text-wrap py-2 m-1" style="width: 12rem; background-color:DarkKhaki">
            <div class="fa-solid fa-users text-dark"></div>
            <a href="/user" style="color:black; text-decoration:none;"> Σχολεία</a>
        </div>
    @endif
    <div class=" badge bg-dark text-wrap py-2 m-1" style="width: 12rem; opacity: 0.5;">
        <div class="fa-solid fa-arrow-right-from-bracket"></div>
        <a href="/logout" style="color:white; text-decoration:none;" class=""> Αποσύνδεση</a>
    </div>
</nav>