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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!-- Core CSS -->
<link rel="stylesheet" href="{{asset("assets/vendor/css/core.css")}}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{asset("assets/vendor/css/theme-default.css")}}" class="template-customizer-theme-css" />
@if(session('theme') == "dark")
    <link rel="stylesheet" href="{{asset("assets/vendor/css/core.dark.css")}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset("assets/vendor/css/theme-default.dark.css")}}" class="template-customizer-theme-css" />
@endif
<link rel="stylesheet" href="{{asset("assets/vendor/css/api.css")}}" class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{asset("assets/css/demo.css")}}" />
<link rel="stylesheet" href="{{asset("assets/css/style.css")}}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{asset("assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css")}}" />

<link rel="stylesheet" href="{{asset("assets/vendor/libs/apex-charts/apex-charts.css")}}" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js'></script>
@if(session('theme') == \App\Enums\Theme::DARK->value)
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #2b2c40;
            border: 1px solid #444564;

        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            color: #a3a4cc;
        }
        .select2-dropdown{
            background-color: #2b2c40;
        }
    </style>
@endif

<script>

    function convertTo12HourFormat(time24) {
        // Split the time string into hours and minutes
        let [hours, minutes] = time24.split(':').map(Number);

        // Determine the period (AM or PM)
        let period = hours >= 12 ? 'PM' : 'AM';

        // Adjust hours to 12-hour format
        hours = hours % 12 || 12; // Converts '0' hours to '12'

        // Format the result as a string
        let time12 = `${hours}:${minutes.toString().padStart(2, '0')} ${period}`;
        return time12;
    }


    function dateDiff(from_date, to_date){
        // Define the two dates
        const date1 = new Date(from_date);
        const date2 = new Date(to_date);

        // Calculate the difference in milliseconds
        const diffInMilliseconds = date2 - date1;

        // Convert the difference from milliseconds to days
        const diffInDays = diffInMilliseconds / (1000 * 60 * 60 * 24);

        return diffInDays+1;
        // console.log(diffInDays); // Output: 2
    }




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


    function modalLoaderON(){
        $('#modal-loader').removeClass('d-none')
    }

    function modalLoaderOFF(){
        $('#modal-loader').addClass('d-none')
    }


    function datePicker(id){
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $(id).html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $(id).daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

        });
    }
</script>
