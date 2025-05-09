jQuery(document).ready(function($) {
    console.log('SAM Newsletter script loaded'); // Should appear in console

$(document).on('submit', '.sam-newsletter-form', function(e) {


        e.preventDefault();
         console.log('Direct form binding worked');
        const $form = $(this);
        const $message = $form.find('.sam-newsletter-message');
        const $submit = $form.find('.sam-newsletter-submit');
        const $errors = $form.find('.sam-newsletter-error');
        
        // Clear previous messages and errors
        $message.removeClass('success error').text('');
        $errors.text('');
        
        // Get form data
        const formData = {
            name: $form.find('#sam-newsletter-name').val().trim(),
            email: $form.find('#sam-newsletter-email').val().trim(),
            nonce: samNewsletterFrontend.nonce,
        };
        
        // Client-side validation
        let isValid = true;
        
        if (!formData.name) {
            $form.find('[data-error="name"]').text('Please enter your name.');
            isValid = false;
        }
        
        if (!formData.email) {
            $form.find('[data-error="email"]').text('Please enter your email.');
            isValid = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
            $form.find('[data-error="email"]').text('Please enter a valid email.');
            isValid = false;
        }
        
        if (!isValid) {
            return;
        }
        
        // Disable submit button during AJAX request
        $submit.prop('disabled', true);
        
        // Send AJAX request
        $.ajax({
            url: samNewsletterFrontend.ajaxUrl,
            type: 'POST',
            data: {
                action: 'sam_newsletter_submit',
                ...formData,
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $message.addClass('success').text(response.data.message);
                    $form[0].reset();
                } else {
                    $message.addClass('error').text(response.data.message);
                }
            },
            error: function() {
                $message.addClass('error').text('An error occurred. Please try again.');
            },
            complete: function() {
                $submit.prop('disabled', false);
            },
        });
    });
});