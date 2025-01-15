<!DOCTYPE html>
<html lang="en">

@include('layouts.head')

<body id="page-top" style="background-color: whitesmoke">  
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
    <!-- Topbar -->
    @include('member.navbar')
    <!-- End of Topbar -->

    <!-- Main Content -->
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid mb-3 mt-4 pt-5 index-content">
            @yield('member-content')
        </div>
    </div>
    <!-- End of Main Content -->
    
    <!-- Footer -->
    @include('member.footer')
    <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
    
    @include('layouts.script')
</body>
</html>