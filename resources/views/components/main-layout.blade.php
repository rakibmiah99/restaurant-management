
<!DOCTYPE html>
<html
    lang="{{app()->getLocale() == "en" ? 'en' : 'ar'}}"
    dir="{{app()->getLocale() == "en" ? 'ltr' : 'rtl'}}"
    class="{{session('theme') == "light" ? 'light-style' : 'dark-style'}} layout-menu-fixed"

    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template"
>
<head>
    <x-header/>
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        <x-sidebar/>

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            <x-navbar/>

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                {{$slot}}
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>
    <x-delete-modal/>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

    <x-footer-script/>
    <script>
        let timeout = null;
        function searchData(){
            clearTimeout(timeout);
            timeout = setTimeout(function (){
                $('#search-form').trigger('submit');
            }, 500)
        }


        $(document).ready(function() {
            $('.select-2').select2();
        });



        //delete modal from index list button
        $('.delete-btn').on('click', function (){
            let url = $(this).attr('url')
            $('#modal-delete-form').attr('action', url)
        })
    </script>
</body>
</html>
