document.addEventListener('DOMContentLoaded', () => {
    if (window.AOS) {
        AOS.init({ duration: 700, once: true, offset: 60 });
    }

    // Category filter chips on the browse page just resubmit the form.
    document.querySelectorAll('[data-category-chip]').forEach((chip) => {
        chip.addEventListener('click', (e) => {
            e.preventDefault();
            const form = document.getElementById('browse-filter-form');
            if (!form) return;
            form.querySelector('[name="category"]').value = chip.dataset.categoryChip;
            form.submit();
        });
    });

    // Auto-dismiss flash alerts after a few seconds.
    document.querySelectorAll('.alert').forEach((el) => {
        setTimeout(() => { el.style.opacity = '0'; }, 6000);
    });
});
