<template>
    <div class="builder">
        <h4>Form config</h4>
        <form-builder type="template" v-model="form"></form-builder>

        <div v-if="status" class="text-success">Config updated</div>
        <button class="btn btn-secondary mt-5" @click="saveConfig()">Save form config</button>
    </div>
    
</template>

<script>
    import FormBuilder from 'v-form-builder';
    import axios from 'axios';

    export default {
        components: {FormBuilder},
        props: ['formdata', 'formid'],
        data() {
            return {
                form: '',
                status: false
            }
        },
        mounted() {
            this.form = this.formdata;
        },
        methods: {
            saveConfig: function() {
                this.status = false;
                axios.post('/admin/ajax/form/'+this.formid, {data: this.form})
                  .then(
                    (response) => {
                        console.log(response);
                        this.status = true;
                    }
                  )
                  .catch(
                    (error) => console.log(error)
                  );
            }
        }
    }
</script>
