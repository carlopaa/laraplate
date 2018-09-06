export default {
    store: [
        'validation'
    ],

    mounted() {
        axios.interceptors.request.use(config => {
            this.validation.errors = [];

            return config;
        });

        axios.interceptors.response.use(response => {
            if (response.data.data.hasOwnProperty('message')) {
                this.validation.message = response.data.data.message;
            }

            return response;
        }, error => {
            if (error.response.status === 422) {
                this.validation.errors = error.response.data.errors;
            }

            if (error.response.data.hasOwnProperty('message')) {
                this.validation.message = error.response.data.message;
            }

            return Promise.reject(error);
        });
    }
}
