<meta charset="utf-8" />
<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
/>

<title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

<meta name="description" content="" />

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="{{asset("assets/img/favicon/favicon.ico")}}" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet"
/>

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="{{asset("assets/vendor/fonts/boxicons.css")}}" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<!-- Core CSS -->
<link rel="stylesheet" href="{{asset("assets/vendor/css/core.css")}}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{asset("assets/vendor/css/theme-default.css")}}" class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{asset("assets/css/demo.css")}}" />
<link rel="stylesheet" href="{{asset("assets/css/style.css")}}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{asset("assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css")}}" />

<link rel="stylesheet" href="{{asset("assets/vendor/libs/apex-charts/apex-charts.css")}}" />

<!-- Page CSS -->

<!-- Helpers -->
<script src="{{asset("assets/vendor/js/helpers.js")}}"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{asset("assets/js/config.js")}}"></script>

<!-- build:js assets/vendor/js/core.js -->
<script src="{{asset("assets/vendor/libs/jquery/jquery.js")}}"></script>
<script src="{{asset("assets/vendor/libs/popper/popper.js")}}"></script>
<script src="{{asset("assets/vendor/js/bootstrap.js")}}"></script>
<script src="{{asset("assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js")}}"></script>

<!-- Vendors JS -->
<script src="{{asset("assets/vendor/libs/apex-charts/apexcharts.js")}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    function Toast(message, type = 'success'){
        let options = {
            text: message,
            className: "info",
            style: {
                color: 'white'
            },
            gravity: 'bottom'
        }


        if(type == "success"){
            options.style.background = "#2D9596";
        }
        else if(type == "error"){
            options.style.background = "#EE4E4E";
        }

        Toastify(options).showToast();
    }


    $(document).ready(function (){
        @if(session('success'))
        var toastMessage =" @php echo session('success'); @endphp";
        Toast(toastMessage);
        @elseif(session('error'))
        var toastMessage =" @php echo session('error'); @endphp";
        Toast(toastMessage, 'error');
        @endif
    })
</script>
