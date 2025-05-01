// Mobile Menu Toggle
document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
    this.classList.toggle('active');
    document.querySelector('.nav-links').classList.toggle('active');
});

// Smooth page transitions
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
        if(this.href.includes(window.location.hostname)) {
            e.preventDefault();
            document.querySelector('.loading-overlay').classList.add('active');
            setTimeout(() => window.location.href = this.href, 500);
        }
    });
});

// Scroll effect
window.addEventListener('scroll', function() {
    document.querySelector('.navbar').classList.toggle('scrolled-nav', window.scrollY > 50);
});