@include('backend.layouts.header')
@include('backend.layouts.leftsidebar')


        <!-- Sidebar -->
        @yield('leftsidebar')
        <!-- End of Sidebar -->

        <!-- Main Content -->
        @yield('content')
        <!-- End of Main Content -->

            <!-- Footer -->
            
@include('backend.layouts.footer')