
document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('.main-header');

    function onScroll() {
        if (window.scrollY > 10) {
            navbar.classList.add('navbar-scrolled');
            navbar.classList.remove('navbar-blue');
        } else {
            navbar.classList.add('navbar-blue');
            navbar.classList.remove('navbar-scrolled');
        }
    }

    onScroll(); // Saat load halaman
    window.addEventListener('scroll', onScroll);
});



