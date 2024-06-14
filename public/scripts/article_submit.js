{
    document.addEventListener('DOMContentLoaded', () => {
        document.addEventListener('click', (e) => {
            document.getElementById('articleForm').action = e.target.getAttribute('data-action');
        });

        document.addEventListener('click', (e) => {
            const form = document.forms.namedItem('articleForm');
            if (e.target.id === 'draft-submit-button') {
                for (const input of form.querySelectorAll('input, textarea')) {
                    input.required = false;
                }
            } else {
                for (const input of form.querySelectorAll('input, textarea')) {
                    input.required = true;
                }
                form.querySelector('#thumbnail').required = false;
                form.querySelector('#images').required = false;
            }
        });
    })
}
