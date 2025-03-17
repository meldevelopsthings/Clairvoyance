document.getElementById('navbar-toggle').addEventListener('click', function() {
    const navbar = document.getElementById('navbar');
    const button = document.getElementById('navbar-toggle');
    
    navbar.classList.toggle('-translate-x-full');
    navbar.classList.toggle('translate-x-0');

    if (navbar.classList.contains('translate-x-0')) {
        button.classList.remove('lest-2');
        button.classList.add('left-[calc(20%-1rem)]');
    } else {
        button.classList.remove('left-[calc(20%-1rem)]');
    }
});