<template>
    <form-builder type="gui" :form="form"></form-builder>
</template>

<script>
    import FormBuilder from 'v-form-builder-m';

    export default {
        components: {FormBuilder},
        props: ['formdata'],
        data() {
            return {
                form: ''
            }
        },
        mounted() {
            this.form = this.formdata;
        }
    }
</script>
