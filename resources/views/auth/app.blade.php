<!DOCTYPE html>
<html lang="en">

    @include('layouts.head')
    
<body>

    <div class="container-fluid">
        @yield('content')
    </div>

    @include('layouts.footer')

    {{-- js --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>