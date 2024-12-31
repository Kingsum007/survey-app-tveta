<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session('direction', 'ltr') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Normal Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- RTL Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous" >
        <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
                <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.css') }}">
                <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.css') }}">
                <link rel="stylesheet" href="{{ asset('admin/plugins/chart.js/Chart.css') }}">
                <link rel="stylesheet" href="{{ asset('admin/plugins/chart.js/Chart.min.css') }}">

        <title>TVETA Survey Collection System</title>
   <style>
    .charts-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 800px;
    margin: 0 auto;
}

.chart-block {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
.chart-block h3 {
    text-align: center;
    font-size: 18px;
    margin-bottom: 15px;
}

  /* Card Styling */
.card {
    position: relative;
    margin: 20px 0;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Image Styling */
.card-img-top {
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

/* Hover effects */
.card:hover {
    transform: translateY(-10px);  /* Lift the card */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);  /* Enhance the shadow */
}

.card:hover .card-img-top {
    transform: scale(1.05);  /* Slight zoom on image */
}

/* Button Hover Effects */
.btn {
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.btn:hover {
    background-color: #007bff;
    transform: scale(1.1);  /* Slight grow effect */
}

/* Fade-In Effect on Card Load */
.card {
    opacity: 0;
    animation: fadeIn 0.5s forwards;
}

@keyframes fadeIn {
    to {
        opacity: 1;
    }
}

/* Smooth transition for pagination */
.d-flex.justify-content-center {
    transition: opacity 0.5s ease;
}

/* Additional styling for the delete and edit buttons */
.btn-sm {
    margin-right: 5px;
}

.card-body {
    padding: 20px;
}

.card-title {
    font-size: 1.2rem;
    font-weight: bold;
}

.card-text {
    font-size: 0.95rem;
    color: #555;
    margin-bottom: 15px;
}

/* General Survey Container */
.survey-container {
    padding: 40px 0;
}

.survey-title {
    text-align: center;
    margin-bottom: 30px;
    font-size: 2rem;
    font-weight: bold;
}

/* Question Card Styles */
.card-question {
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background-color: #fff;
    padding: 20px;
    opacity: 0;
    animation: fadeIn 0.5s forwards;
}

.card-question:hover {
    transform: translateY(-5px); /* Lift the card */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Enhance shadow */
}

/* Fade-in animation */
@keyframes fadeIn {
    to {
        opacity: 1;
    }
}

/* Question Text */
.card-question h5 {
    font-size: 1.5rem;
    margin-bottom: 15px;
}

/* Options Layout (for multiple choice, checkboxes) */
.options-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.options-container label {
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.options-container input {
    margin-right: 10px;
}

/* Input Styling */
textarea, input[type="text"], input[type="file"] {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ddd;
    margin-bottom: 15px;
}

textarea {
    height: 120px;
    resize: vertical;
}

/* Submit Button */
.submit-btn {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

.submit-btn:hover {
    background-color: #0056b3;
}

/* Loading Spinner */
.spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #3498db;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
/* Survey Container */
.container {
    padding: 40px 15px;
}

h1 {
    font-size: 2.5rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
}

p {
    font-size: 1.2rem;
    text-align: center;
    margin-bottom: 30px;
}

/* Question Card Styles */
.card-question {
    background-color: #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.card-question:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Question Text */
.card-question h5 {
    font-size: 1.6rem;
    margin-bottom: 15px;
    color: #333;
}

/* Button Styles */
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

/* Progress Bar */
.progress-bar-container {
    height: 10px;
    background-color: #ddd;
    margin-bottom: 20px;
}

.progress-bar {
    height: 100%;
    background-color: #007bff;
    width: 0;
    transition: width 0.4s ease;
}

/* File Upload Preview */
.file-preview {
    display: flex;
    align-items: center;
    gap: 15px;
}

.file-preview img {
    width: 50px;
    height: 50px;
    border-radius: 8px;
}

.file-preview span {
    font-size: 1rem;
}

/* Loading Spinner */
.spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #007bff;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

</style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">TVETA Survey</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">{{__('message.home')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">{{__('message.about_us')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('survey-list') }}">{{__('message.survey')}}</a></li>
                @auth
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">{{__('message.logout')}}</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{__('message.login')}}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{__('message.register')}}</a></li>
                @endauth


            </ul>
            <!-- Language Dropdown -->
            <div class="dropdown ml-auto">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="languageDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
    {{-- <script src="{{ asset('admin/plugins/chart.js/Chart.bundle.js')}}"></script>
    <script src="{{ asset('admin/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/chart.js/Chart.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <script>
          $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
        // JavaScript to switch styles based on the selected language
        document.addEventListener('DOMContentLoaded', function () {
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
                item.addEventListener('click', function () {
                    const selectedLang = this.getAttribute('href').split('lang=')[1];
                    switchStyles(selectedLang);
                });
            });
        });
    </script>

</body>

</html>