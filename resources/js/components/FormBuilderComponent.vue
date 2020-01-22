<template>
    <div class="builder">
        <form-builder type="template" v-model="form"></form-builder>
        <div class="mt-5">
            <div v-if="status" class="text-success mb-1">Config updated</div>
            <button class="btn btn-secondary" @click="saveConfig()">Save Form Settings</button>
        </div>
    </div>
    
</template>

<script>
    import FormBuilder from 'v-form-builder-m';
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
                let self = this;
                // Collapse form for next editing
                _.forEach(this.form.sections, function(section, key) {
                    self.form.sections[key].expanded = false;
                });
                axios.post('/admin/ajax/form/'+this.formid, {data: this.form})
                  .then(
                    (response) => {
                        // console.log(response);
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
