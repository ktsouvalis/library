<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Βιβλιοθήκη</title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    {{-- <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> --}}
    <link href="DataTables-1.13.4/css/dataTables.bootstrap5.css" rel="stylesheet"/>
    <link href="Responsive-2.4.1/css/responsive.bootstrap5.css" rel="stylesheet"/>
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/5083d79d45.js" crossorigin="anonymous"></script>
  
  </head> 
  @auth
  <div class="d-flex justify-content-center"><div class="h1 fa-solid fa-school text-secondary"></div></div>
    <div class="d-flex justify-content-center"> <a href='/password_reset' class="h4 text-secondary" style="text-decoration:none;" data-toggle="tooltip" title="Αλλαγή κωδικού πρόσβασης"> {{Auth::user()->display_name}}</a></div>
  @endauth
  {{$slot}}
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
        

       <!-- footer begins -->
       <footer class="border-top text-center small text-muted py-3">
      <p class="m-0">Copyright &copy; 2023 <a href="/" class="text-muted">library</a>. Διεύθυνση Π.Ε. Αχαΐας - Τμήμα Πληροφορικής & Νέων Τεχνολογιών - Ηλεκτρονικές Υπηρεσίες.</p>
    </footer>

    <script src="/bootstrap/js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script
			  src="https://code.jquery.com/jquery-3.6.4.min.js"
			  integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
			  crossorigin="anonymous">
    </script>
    {{-- <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
    <script src="DataTables-1.13.4/js/jquery.dataTables.js"></script>
    <script src="DataTables-1.13.4/js/dataTables.bootstrap5.js"></script>
    <script src="Responsive-2.4.1/js/dataTables.responsive.js"></script>
    <script src="Responsive-2.4.1/js/responsive.bootstrap5.js"></script>
    <script>
      $(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#dataTable tfoot tr #search').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" style="width:7rem;" placeholder="' + title + '" />');
    });
 
    // DataTable
    var table = $('#dataTable').DataTable({
        initComplete: function () {
            // Apply the search
            this.api()
                .columns()
                .every(function () {
                    var that = this;
 
                    $('input', this.footer()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
        },
    });
});

    </script>
    </div> <!-- container closing -->
   </body>
</html>
