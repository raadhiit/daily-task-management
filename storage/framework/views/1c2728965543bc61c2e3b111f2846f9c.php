<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" id="navbar">
  <!-- MCH SECTION -->
  <ul class="navbar-nav">
    <div id="jamNavbar" style="font-size: 18px"></div>
  </ul>

  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto text-dark">
    <h5 class="mt-1"><i>Welcome, <b><?php echo e(Auth::user()->name); ?></b></i> | </h5>
    <i class="fa-solid fa-circle-user fa-2x ml-1"></i>
  </ul>

</nav>

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

  // Panggil fungsi updateClock sekali ketika halaman selesai dimuat
  $(document).ready(function () {
      updateClock();
  });
</script>
<?php /**PATH C:\projek\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>