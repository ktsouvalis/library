
<div class="d-flex justify-content-center"> <div class="h4 bi bi-book text-black-50"> <a href='/password_reset'>{{Auth::user()->display_name}}</a></div></div>
<nav class="navbar navbar-light justify-content-auto py-3 p-3" style="background-color: #e3f2fd;">
    <!-- Navbar content -->
    <div class="badge bg-light text-wrap py-2 m-1" style="width: 12rem;">
        <a href="/" style="color:black;">Αρχική</a>
    </div>
    <div class="badge bg-success text-wrap py-2 m-1" style="width: 12rem; opacity: 0.9;">
        <a href="/book" style="color:white;">Βιβλία</a>
    </div>
    <div class="badge bg-warning text-wrap py-2 m-1" style="width: 12rem; opacity: 0.9;">
        <a href="/student" style="color:black;">Μαθητές</a>
    </div>
    <div class="badge bg-danger text-wrap py-2 m-1" style="width: 12rem; opacity: 0.9;">
        <a href="/loans" style="color:white;">Δανεισμοί</a>
    </div>
    <div class="badge bg-dark text-wrap py-2 m-1" style="width: 12rem; opacity: 0.5;">
        <a href="/logout" style="color:white;">Αποσύνδεση</a>
    </div>
  </nav>