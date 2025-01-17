document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.admin-mobile-toggle');
    const sidebar = document.querySelector('.admin-sidebar');
    
    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }
}); 