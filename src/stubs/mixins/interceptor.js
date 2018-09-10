export default {
    store: [
        'response',
        'form'
    ],

    mounted() {
        axios.interceptors.request.use(config => {
            this.response.validation.errors = [];
            this.response.message = null;
            this.response.status = null;

            return config;
        });

        axios.interceptors.response.use(response => {
            this.response.status = 'success';

            if (response.data.hasOwnProperty('message')) {
                this.response.message = response.data.message;
            }

            if (! response.data.hasOwnProperty('clear') || response.data.clear === true) {
                this.form = {};
            }

            return Promise.resolve(response);
        }, error => {
            this.response.status = 'error';

            if (error.response.status === 422) {
                this.response.validation.errors = error.response.data.errors;
            }

            if (error.response.data.hasOwnProperty('message')) {
                this.response.message = error.response.data.message;
            }

            return Promise.reject(error);
        });
    }
}
