<!DOCTYPE html>
<html lang="pt-br">

<head>

    @include('layouts.partials.head')
    
    @yield('styles')

    @yield('scripts')

</head>

<body id="page-top" class="text-light">

	@include('layouts.partials.nav')

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-xl mb-5 pb-5">

                    @yield('page-content')

                </div>
                <!-- /.container -->


                @yield('scripts-js')

            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->


    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    @stack('footer-scripts')

</body>
</html>