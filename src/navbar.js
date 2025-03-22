document.getElementById('navbar-toggle').addEventListener('click', function() {
    const navbar = document.getElementById('navbar');
    const button = document.getElementById('navbar-toggle');

    navbar.classList.toggle('-translate-x-full');
    
    if (navbar.classList.contains('-translate-x-full')) {
        button.classList.add('bg-darker-500');
    } else {
        button.classList.remove('bg-darker-500');
    }
});