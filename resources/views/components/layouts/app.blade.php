@php
    $x=App\Models\App::first();

    use Illuminate\Support\Facades\Vite;

@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? $x->name }}</title>
        <link href="https://cdn.jsdelivr.net/npm/fastbootstrap@2.2.0/dist/css/fastbootstrap.min.css" rel="stylesheet" integrity="sha256-V6lu+OdYNKTKTsVFBuQsyIlDiRWiOmtC8VQ8Lzdm2i4=" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        {{-- <script src="{{ mix('resources/js/app.js') }}"></script> --}}
        <link
        rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <style>
          {!! Vite::content('resources/css/app.css') !!}
      </style>
        <script>
          {!! Vite::content('resources/js/app.js') !!}
      </script>

    </head>
    <body class="poppins-bold">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
              <a class="navbar-brand" href="#"><img src="{{ asset('storage/'.$x->logo) }}" width="36" /> {{ $x->name.' - '.$x->institution }}</a>
              {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button> --}}
              {{-- <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav mx-auto">
                  <a class="nav-link active {{ Request::is('get_antrian')?'':'d-none' }}" aria-current="page" href="/display">Home</a>
                  <a class="nav-link {{ Request::is('get_antrian')?'':'d-none' }}" href="/caller">Caller</a>
                  <a class="nav-link {{ Request::is('get_antrian')?'':'d-none' }}" href="/layanan">Layanan</a>
                  <a class="nav-link {{ Request::is('get_antrian')?'':'d-none' }}" href="/loket">Loket</a>
                </div>
              </div> --}}
              <button id="toggleFS" class="btn btn-default"><i class="fa-solid fa-expand"></i></button>
    
              <script>
                  var toggleFS = document.getElementById("toggleFS");
          
                  toggleFS.addEventListener("click", function() {
                      if (!document.fullscreenElement) {
                          // Masuk ke mode fullscreen
                          document.body.requestFullscreen().then(() => {
                              toggleFS.innerHTML = '<i class="fa-solid fa-compress"></i>'; // Ubah teks tombol
                          }).catch(err => {
                              console.error(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
                          });
                      } else {
                          // Keluar dari mode fullscreen
                          document.exitFullscreen().then(() => {
                              toggleFS.innerHTML = '<i class="fa-solid fa-expand"></i>'; // Ubah teks tombol kembali
                          }).catch(err => {
                              console.error(`Error attempting to exit full-screen mode: ${err.message} (${err.name})`);
                          });
                      }
                  });
              </script>
            </div>
          </nav>
        
        <div class="container-fluid pt-3 h-100" style="background-color: #F3F4F6;">
            {{ $slot }}
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>
