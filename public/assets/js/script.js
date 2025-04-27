<script>
        // Script pour les accordéons FAQ
        document.querySelectorAll('.accordion-btn').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('svg');
                
                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                    icon.classList.remove('rotate-180');
                } else {
                    content.style.maxHeight = content.scrollHeight + 'px';
                    icon.classList.add('rotate-180');
                }
            });
        });
    </script>
