document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const topbar = document.querySelector('.topbar');
    const toggleBtn = document.querySelector('.sidebartoggler');

    if (!topbar) return; // safety check

    // Fungsi update posisi topbar sesuai sidebar
    function updateTopbar() {
        if (body.classList.contains('mini-sidebar')) {
            topbar.style.left = '70px';
        } else {
            topbar.style.left = '250px';
        }
    }

    // Load sidebar state dari localStorage
    if (localStorage.getItem('sidebar') === 'mini') {
        body.classList.add('mini-sidebar');
    } else {
        body.classList.remove('mini-sidebar');
    }

    // Apply posisi topbar awal
    updateTopbar();

    // Toggle mini-sidebar
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            body.classList.toggle('mini-sidebar');
            localStorage.setItem('sidebar', body.classList.contains('mini-sidebar') ? 'mini' : 'full');
            updateTopbar();
        });
    }

    // -------------------------------
    // Dropdown Bootstrap 5 fix
    // -------------------------------
    // Ganti semua a[data-toggle] ke data-bs-toggle
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(function(toggle) {
        toggle.setAttribute('data-bs-toggle', 'dropdown');
    });
});
