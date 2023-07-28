<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @stack('title')
    
    <link rel="stylesheet" href="{{url('/bootstrap/css/bootstrap.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="icon" href="{!! asset(url('/favicon/favicon.ico')) !!}"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{url('/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{url('/favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{url('/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#b91d47">
    <meta name="theme-color" content="#ffffff">

    @stack('links')
    
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/5083d79d45.js" crossorigin="anonymous"></script>
  
  </head> 
  @auth
  
  @php
    $user = Illuminate\Support\Facades\Auth::user();
    $link = $user->public_link;
  @endphp     
   
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col p-4">
        <div class="d-flex justify-content-center"><img src="{{url('/favicon/index.png')}}" width="100" height="65" alt="books"></div>
        <div class=" d-flex justify-content-center"><a href="{{url('/change_password')}}" class="h4 text-dark" style="text-decoration:none; " data-toggle="tooltip" title="Αλλαγή κωδικού πρόσβασης"> {{Auth::user()->display_name}}</a></div>
      </div>
    </div>
  </div>
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
        
         @if(session()->has('warning'))
        <div class='container container--narrow'>
        <div class='alert alert-warning text-center'>
            {{session('warning')}}
        </div>
        </div>
        @endif    
  {{$slot}}
        
        

       <!-- footer begins -->
       <footer class="border-top text-center small text-muted py-3">
      @if(Illuminate\Support\Facades\Request::path()=='/')
        <p class="m-0">Copyright &copy; 2023 <a href="{{url('/')}}" class="text-muted">library</a>. Διεύθυνση Π.Ε. Αχαΐας - Τμήμα Πληροφορικής & Νέων Τεχνολογιών</p>
        <p class="m-0">
          <tag data-toggle="tooltip" title="konstantinostef@yahoo.gr">Κωνσταντίνος Στεφανόπουλος</tag>, <tag data-toggle="tooltip" title="ktsouvalis@sch.gr">Κωνσταντίνος Τσούβαλης</tag>
        </p>
      @endif
    </footer>
    <script src="{{url('/bootstrap/js/bootstrap.js')}}"></script>
    <script
                src="https://code.jquery.com/jquery-3.6.4.min.js"
                integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
                crossorigin="anonymous">
    </script>
    @stack('scripts')

    <script>
$(document).ready(function () {
    // Setup - add a text input for inclusion and exclusion to each header cell
    $('#dataTable thead tr #search').each(function () {
        var title = $(this).text();
        $(this).html(`
            <div class="vstack gap-1">
                <input type="text" class="include-search" style=" font-size:small;" placeholder="${title} +" />
                <input type="text" class="exclude-search" style=" font-size:small;" placeholder="${title} - " />
            </div>
        `);
    });

    // DataTable
    var table = $('#dataTable').DataTable({
        lengthMenu: [10, 25, 50, 100, -1], // Add -1 for "All"
        pageLength: 10, // Set the initial page length
        initComplete: function () {
            // Apply the search
            this.api().columns().every(function () {
                var that = this;
                var includeColumn = $('input.include-search', this.header());
                var excludeColumn = $('input.exclude-search', this.header());

                includeColumn.on('keyup change clear', function () {
                    var includeValue = this.value;
                    var excludeValue = excludeColumn.val();
                    var regex;

                    if (includeValue) {
                        if (excludeValue) {
                            regex = `^(?=.*${includeValue})(?!.*${excludeValue})`;
                        } else {
                            regex = `.*${includeValue}`;
                        }
                    } else {
                        regex = excludeValue ? `^(?!.*${excludeValue}).*` : '';
                    }

                    that.search(regex, true, false).draw();
                }).on('click', function (e) {
                    e.stopPropagation();
                    column.search($(this).val()).draw();
                });

                excludeColumn.on('keyup change clear', function () {
                    var excludeValue = this.value;
                    var includeValue = includeColumn.val();
                    var regex;

                    if (excludeValue) {
                        if (includeValue) {
                            regex = `^(?=.*${includeValue})(?!.*${excludeValue})`;
                        } else {
                            regex = `^(?!.*${excludeValue}).*`;
                        }
                    } else {
                        regex = includeValue ? `.*${includeValue}` : '';
                    }

                    that.search(regex, true, false).draw();
                }).on('click', function (e) {
                    e.stopPropagation();
                    column.search($(this).val()).draw();
                });
            });
        },
    });
});

</script>

    
    </div> <!-- container closing -->
   
    <div class="d-flex justify-content-center"><p class="h3" style="color:black"> {{env('APP_NAME')}}</p></div>
    @stack('copy_script')
   </body>
</html>
