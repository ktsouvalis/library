<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @stack('title')
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="icon" href="{!! asset('favicon.ico') !!}"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#b91d47">
    <meta name="theme-color" content="#ffffff">

    @stack('links')
    
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/5083d79d45.js" crossorigin="anonymous"></script>
  
  </head> 
  @auth
  <div class="d-flex justify-content-center"><div class="h1 fa-solid fa-school text-dark" style="text-decoration:none; "></div></div>
    <div class="d-flex justify-content-center"> <a href='/password_reset' class="h4 text-dark" style="text-decoration:none; " data-toggle="tooltip" title="Αλλαγή κωδικού πρόσβασης"> {{Auth::user()->display_name}}</a></div>
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
    <script
                src="https://code.jquery.com/jquery-3.6.4.min.js"
                integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
                crossorigin="anonymous">
    </script>
    @stack('scripts')

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

    <div class="d-flex justify-content-center"><p class="h3" style="color:black"> {{env('APP_NAME')}}</p></div>
   </body>
</html>
