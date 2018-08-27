<template>
    <div>
        <div v-if="avatar" class="card-img-container">
            <img :src="avatar" alt="Avatar" class="card-img-top" :class="{'is-uploading' : uploading}">

            <div v-if="uploading" class="uploading-text">
                <svg class="lds-spin" width="80px"  height="80px"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" style="background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%;"><g transform="translate(80,50)">
                    <g transform="rotate(0)">
                    <circle cx="0" cy="0" r="10" fill="#1d3f72" fill-opacity="1">
                    <animateTransform attributeName="transform" type="scale" begin="-0.875s" values="1.1 1.1;1 1" keyTimes="0;1" dur="1s" repeatCount="indefinite"></animateTransform>
                    <animate attributeName="fill-opacity" keyTimes="0;1" dur="1s" repeatCount="indefinite" values="1;0" begin="-0.875s"></animate>
                    </circle>
                    </g>
                    </g><g transform="translate(71.21320343559643,71.21320343559643)">
                    <g transform="rotate(45)">
                    <circle cx="0" cy="0" r="10" fill="#1d3f72" fill-opacity="0.875">
                    <animateTransform attributeName="transform" type="scale" begin="-0.75s" values="1.1 1.1;1 1" keyTimes="0;1" dur="1s" repeatCount="indefinite"></animateTransform>
                    <animate attributeName="fill-opacity" keyTimes="0;1" dur="1s" repeatCount="indefinite" values="1;0" begin="-0.75s"></animate>
                    </circle>
                    </g>
                    </g><g transform="translate(50,80)">
                    <g transform="rotate(90)">
                    <circle cx="0" cy="0" r="10" fill="#1d3f72" fill-opacity="0.75">
                    <animateTransform attributeName="transform" type="scale" begin="-0.625s" values="1.1 1.1;1 1" keyTimes="0;1" dur="1s" repeatCount="indefinite"></animateTransform>
                    <animate attributeName="fill-opacity" keyTimes="0;1" dur="1s" repeatCount="indefinite" values="1;0" begin="-0.625s"></animate>
                    </circle>
                    </g>
                    </g><g transform="translate(28.786796564403577,71.21320343559643)">
                    <g transform="rotate(135)">
                    <circle cx="0" cy="0" r="10" fill="#1d3f72" fill-opacity="0.625">
                    <animateTransform attributeName="transform" type="scale" begin="-0.5s" values="1.1 1.1;1 1" keyTimes="0;1" dur="1s" repeatCount="indefinite"></animateTransform>
                    <animate attributeName="fill-opacity" keyTimes="0;1" dur="1s" repeatCount="indefinite" values="1;0" begin="-0.5s"></animate>
                    </circle>
                    </g>
                    </g><g transform="translate(20,50.00000000000001)">
                    <g transform="rotate(180)">
                    <circle cx="0" cy="0" r="10" fill="#1d3f72" fill-opacity="0.5">
                    <animateTransform attributeName="transform" type="scale" begin="-0.375s" values="1.1 1.1;1 1" keyTimes="0;1" dur="1s" repeatCount="indefinite"></animateTransform>
                    <animate attributeName="fill-opacity" keyTimes="0;1" dur="1s" repeatCount="indefinite" values="1;0" begin="-0.375s"></animate>
                    </circle>
                    </g>
                    </g><g transform="translate(28.78679656440357,28.786796564403577)">
                    <g transform="rotate(225)">
                    <circle cx="0" cy="0" r="10" fill="#1d3f72" fill-opacity="0.375">
                    <animateTransform attributeName="transform" type="scale" begin="-0.25s" values="1.1 1.1;1 1" keyTimes="0;1" dur="1s" repeatCount="indefinite"></animateTransform>
                    <animate attributeName="fill-opacity" keyTimes="0;1" dur="1s" repeatCount="indefinite" values="1;0" begin="-0.25s"></animate>
                    </circle>
                    </g>
                    </g><g transform="translate(49.99999999999999,20)">
                    <g transform="rotate(270)">
                    <circle cx="0" cy="0" r="10" fill="#1d3f72" fill-opacity="0.25">
                    <animateTransform attributeName="transform" type="scale" begin="-0.125s" values="1.1 1.1;1 1" keyTimes="0;1" dur="1s" repeatCount="indefinite"></animateTransform>
                    <animate attributeName="fill-opacity" keyTimes="0;1" dur="1s" repeatCount="indefinite" values="1;0" begin="-0.125s"></animate>
                    </circle>
                    </g>
                    </g><g transform="translate(71.21320343559643,28.78679656440357)">
                    <g transform="rotate(315)">
                    <circle cx="0" cy="0" r="10" fill="#1d3f72" fill-opacity="0.125">
                    <animateTransform attributeName="transform" type="scale" begin="0s" values="1.1 1.1;1 1" keyTimes="0;1" dur="1s" repeatCount="indefinite"></animateTransform>
                    <animate attributeName="fill-opacity" keyTimes="0;1" dur="1s" repeatCount="indefinite" values="1;0" begin="0s"></animate>
                    </circle>
                    </g>
                    </g>
                </svg>
            </div>

            <a v-else href="#" class="btn btn-primary px-4" @click.prevent="fileOpen">
                Upload new image
            </a>
        </div>

        <div class="form-group mb-0">

            <input
                type="file"
                :id="sendAs"
                @change="fileChange"
                :class="{'is-invalid' : errors[this.sendAs]}"
                class="form-control d-none">

            <span class="invalid-feedback text-center" v-if="errors[this.sendAs]">
                <strong>{{ errors[this.sendAs][0] }}</strong>
            </span>
        </div>
    </div>
</template>

<script>
    import upload from 'scripts/mixins/upload';

    export default {
        props: {
            currentAvatar: {
                type: String
            }
        },

        data() {
            return {
                errors: [],
                avatar: this.currentAvatar
            }
        },

        mixins: [
            upload
        ],

        methods: {
            fileChange(e) {
                this.errors = [];

                this.upload(e).then(response => {
                    this.avatar = response.data.data.avatar_path;
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;

                        return;
                    }

                    this.errors = 'Something went wrong, please try again.';
                });
            },

            fileOpen() {
                document.getElementById(this.sendAs).click();
            }
        }
    }
</script>

<style lang="scss" scoped>
    .card-img-container {
        position: relative;
        overflow: hidden;

        &:hover {
            .btn {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }
    }

    .card-img-top {
        transition: opacity ease-in-out 200ms;

        &.is-uploading {
            opacity: .5;
        }
    }

    .uploading-text {
        color: #fff;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .btn {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translate(-50%, 50px);
        opacity: 0;
        transition: all ease-in-out 200ms;
    }
</style>
