<!DOCTYPE html>
<html lang="en">

@include('layouts.head')
  
<body id="page-top" style="background-color: whitesmoke">  
  <div id="wrapper">
    <!-- Sidebar -->
    @include('layouts.sidebar')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Topbar -->
      @include('layouts.navbar')
      <!-- End of Topbar -->

      <!-- Main Content -->
      <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid index-content mb-3 position-relative">
          @yield('contents')
        </div>
      </div>
      <!-- End of Main Content -->
      
      <!-- Footer -->
      @include('layouts.footer')
      <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  
  @include('layouts.script')
</body>
</html>