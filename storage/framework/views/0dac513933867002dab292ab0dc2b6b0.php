<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow" id="navbarMember">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-itemLogo" id="logoNav">
                    <div class="navbar-brand ms-2" href="#">
                        <img src="<?php echo e(asset('img/FTI_logo_color_horizontal_with_member_of_Astra.png')); ?>" id="gambarFTI" alt="">
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto d-flex align-items-end" id="kanan">
                <h5 class="mt-1 tes"><i><b><?php echo e(Auth::user()->name); ?></b></i></h5>
                <div id="jamNavbar"></div>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-solid fa-user-circle fa-2x"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-3" aria-labelledby="navbarDropdown">
                        <li class="dropdown-item">
                            <form id="logoutForm" action="<?php echo e(route('logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <a class="nav-link" href="#" id="logoutAlert">
                                    <i class="fas fa-sign-out-alt" style="font-size: 16px"></i>
                                    <span style="font-size: 16px">LOGOUT</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            <?php if(Session::has('login') && Session::get('login') === true): ?>
            <script>
                $(document).ready(function() {
                    var user = <?php echo json_encode(Auth::user()); ?>;
                    var Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
        
                    Toast.fire({
                        title: 'Welcome, ' + '<i><b>' + user.name + '</b></i>',
                        iconHtml: "👋",
                        customClass:{
                            icon: 'icon',
                            title: 'text'
                        }
                    });
                });
            </script>
            <?php endif; ?>
        </div>
    </div>
</nav>

<style>
    #kanan{
        display: flex;
        flex-direction: column;
        font-size: 13px;
    }
    .tes{
        font-size: 15px;
        color: black;
    }
    .icon{
        border: 0;
        filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.5));
    }
    .text{
        font-size: 20px;
    }
</style>
    
<script>
    function updateClock() {
        var now = new Date();
        var day = now.toLocaleDateString('en-US', { weekday: 'long' });
        var date = now.getDate();
        var month = now.toLocaleDateString('en-US', { month: 'long' });
        var year = now.getFullYear();
        var hours = now.getHours().toString().padStart(2, '0');
        var minutes = now.getMinutes().toString().padStart(2, '0');
        var seconds = now.getSeconds().toString().padStart(2, '0');
        var time = hours + ':' + minutes + ':' + seconds;
        var fullDate = day + ', ' + date + ' ' + month + ' ' + year + ' | ' + time;

        document.getElementById('jamNavbar').textContent = fullDate;
    }

    // Panggil fungsi updateClock setiap detik (1000 ms)
    setInterval(updateClock, 1000);
    
    $(document).ready(function () {
        updateClock();

        $('#logoutAlert').on('click', function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Logout',
                text: 'Are you sure you want to logout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, logout',
                confirmButtonColor: '#ff0000',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#logoutForm').submit();
                }
            });
        });

    });
</script>
<?php /**PATH C:\projek\resources\views/member/navbar.blade.php ENDPATH**/ ?>