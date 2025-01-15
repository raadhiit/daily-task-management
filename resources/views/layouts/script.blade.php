<!-- Bootstrap core JavaScript-->
<script src="{{ asset('bootstrap-5.3.3/dist/js/bootstrap.min.js') }}"></script>
<!-- Core plugin JavaScript-->
<script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<!-- Custom scripts for all pages-->
<script src="{{ asset('admin_assets/js/sb-admin-2.min.js') }}"></script>
<!-- Page level plugins -->
<script src="{{ asset('admin_assets/vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('js/toastify.js') }}"></script>
<script>
    function notif(data) {
        Toastify({
        text: data.message,
        newWindow: true,
        duration: 5000,
        className: "bootsrap-warning",
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: false, // Prevents dismissing of toast on hover
        style: {
            background: "yellow",
            color: "black"
        },
        onClick: function(){} // Callback after click
        }).showToast();
    }
</script>
<script>
    $(document).ready(function(){
        $('#sidebarToggle').on('click', function(e){
            e.preventDefault();
            $('.sidebar').toggleClass('collapsed')

            // Ganti gambar sesuai dengan kondisi sidebar
            if ($('.sidebar').hasClass('collapsed')) {
                $('#imgNonCollapsed').addClass('d-none');
                $('#imgCollapsed').removeClass('d-none');
            } else {
                $('#imgNonCollapsed').removeClass('d-none');
                $('#imgCollapsed').addClass('d-none');
            }
        });
    });
</script>