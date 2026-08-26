document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newsletter-form');
    const messageContainer = document.getElementById('form-message');
    const ajaxUrl = myAjax2.ajaxurl; // Replace with the actual URL

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // 1. Validation Check
            if (!validateForm()) {
                messageContainer.textContent = 'Please fill out all required fields.';
                return;
            }

            // 2. AJAX Submission
            messageContainer.textContent = 'Submitting...';
            const formData = new FormData(form);
            
            fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
            //    console.log( data );
                if (data.success) {
                    messageContainer.textContent = data.data.message || 'Subscription successful!';
                    form.reset(); // Clear the form on success
                } else {
                    messageContainer.textContent = data.data.message || 'An error occurred during submission.';
                }
            })
            .catch(error => {
                console.log( error );
               // console.error('AJAX Error:', error);
                messageContainer.textContent = 'Network error. Please try again.';
            });
        });
    }

    // Vanilla JavaScript Validation Function
    function validateForm() {
        let isValid = true;
        const requiredFields = form.querySelectorAll('input[required]');

        requiredFields.forEach(field => {
            const errorElement = form.querySelector(`.error-message[data-field="${field.id}"]`);
            field.classList.remove('invalid-field');
            errorElement.textContent = '';

            if (field.value.trim() === '') {
                isValid = false;
                field.classList.add('invalid-field');
                errorElement.textContent = `${field.previousElementSibling.textContent} is required.`;
            }
        });

        return isValid;
    }
});    