import serialize from './serialize';

export default (form, url = null, data = {}) => {
    const payload = data.length ? data : serialize(form);
    const endpoint = url ? url : form.action;
    const btnSubmit = form.querySelector('[type="submit"]');
    const btnDataText = btnSubmit.getAttribute('data-loading-text');
    const loadingText = btnDataText ? btnDataText : 'Processing...';

    /**
     * Reset the button submit state
     */
    const btnReset = () => {
        btnSubmit.innerHTML = btnSubmit.getAttribute('data-original-text');
        btnSubmit.removeAttribute('disabled');
    };

    /**
     * Change the button submit state when ajax request has been submitted
     */
    const btnProcessing = () => {
        btnSubmit.setAttribute('disabled', 'disabled');
        btnSubmit.setAttribute('data-original-text', btnSubmit.innerHTML);
        btnSubmit.innerHTML = loadingText;
    };

    /**
     * Sets the response message
     * @param object data
     * @param string status
     */
    const setResponseMessage = (data, status) => {
        const alert = (message, status) => {
            return `
                <div class="json-response">
                    <div class="alert alert-${status}">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        ${message}
                    </div>
                </div>
            `;
        };

        if (data.hasOwnProperty('message')) {
            const element = document.createElement('div');
            element.classList.add('json-response');
            element.innerHTML = alert(data.message, status);

            form.insertBefore(element, form.childNodes[0]);
        }
    };

    /**
     * Redirect to a specific route
     *
     * @param object data
     */
    const redirectTo = data => {
        if (! data.hasOwnProperty('redirect')) {
            return;
        }

        if (! data.hasOwnProperty('redirect_after')) {
            return window.location.href = data.redirect;
        }

        return setTimeout(() =>
            window.location.href = data.redirect,
            data.redirect_after
        );
    };

    // Remove errors
    const invalidFeedbacks = form.querySelectorAll('span.invalid-feedback');
    if (invalidFeedbacks.length) {
        invalidFeedbacks.forEach((invalid, index) => {
            invalid.parentNode.removeChild(invalid);
        });
    }

    // Remove invalid class
    const invalidFields = form.querySelectorAll('.is-invalid');
    if (invalidFields) {
        invalidFields.forEach((field, index) => {
            field.classList.remove('is-invalid');
        });
    }

    // Remove error message
    const responseMessage = form.querySelector('div.json-response');
    if (responseMessage) {
        responseMessage.parentNode.removeChild(responseMessage);
    }

    btnProcessing();

    axios.post(endpoint, payload).then(response => {
        setResponseMessage(response.data, 'success');
        btnReset();

        form.reset();

        redirectTo(response.data);

        return Promise.resolve(response);
    }).catch(error => {
        if (error.response.status === 422) {
            const errors = error.response.data.errors;

            setResponseMessage(error.response.data, 'danger');

            for (let key in errors) {
                const field = form.querySelector(`[name="${key}"]`);
                const error = document.createElement('span');
                error.classList.add('invalid-feedback');
                error.innerHTML = `<strong>${errors[key][0]}</strong>`;

                field.classList.add('is-invalid');
                field.parentNode.insertBefore(error, field.nextSibling);
            }
        }

        btnReset();

        return Promise.reject(error);
    });
}
