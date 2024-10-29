<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session('direction', 'ltr') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Normal Bootstrap -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- RTL Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
    <title>TVETA Survey Collection System</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">TVETA Survey</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('survey-list') }}">Surveys</a></li>
                @auth
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @endauth
           

            </ul>
                 <!-- Language Dropdown -->
<div class="dropdown ml-auto">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ strtoupper(app()->getLocale()) }} <!-- Show current language -->
    </button>
    <div class="dropdown-menu" aria-labelledby="languageDropdown">
        <a class="dropdown-item" href="{{ route('home', ['lang' => 'en']) }}">English</a>
        <a class="dropdown-item" href="{{ route('home', ['lang' => 'fa']) }}">فارسی</a>
        <a class="dropdown-item" href="{{ route('home', ['lang' => 'ps']) }}">پښتو</a>
    </div>
</div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        // JavaScript to switch styles based on the selected language
        document.addEventListener('DOMContentLoaded', function() {
            const currentLang = "{{ app()->getLocale() }}";
            const bootstrapCSS = document.getElementById('bootstrap-css');
            const bootstrapRTLCSS = document.getElementById('bootstrap-rtl-css');

            // Function to switch styles
            function switchStyles(lang) {
                if (lang === 'fa' || lang === 'ps') { // RTL languages
                    bootstrapCSS.disabled = true;
                    bootstrapRTLCSS.disabled = false;
                } else { // LTR languages
                    bootstrapCSS.disabled = false;
                    bootstrapRTLCSS.disabled = true;
                }
            }

            // Initial load
            switchStyles(currentLang);

            // Language change listener (You can also do this on page load if necessary)
            document.querySelectorAll('.dropdown-item').forEach(item => {
                item.addEventListener('click', function() {
                    const selectedLang = this.getAttribute('href').split('lang=')[1];
                    switchStyles(selectedLang);
                });
            });
        });
    </script>

</body>
</html>
