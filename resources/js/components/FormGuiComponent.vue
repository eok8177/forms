<template>
    <div v-if="form !== null">

        <!-- collapse layout -->
        <div class="accordion" v-if="form.layout === 'collapse'">

            <section-component v-for="(section, index) in form.sections"
                               :key="section.name" :index="index"
                               :section="section">
            </section-component>
        </div>

        <button @click="Submit()" class="btn btn-outline-secondary">Submit</button>


    </div>
</template>

<script>
    import axios from 'axios';
    import SectionComponent from "./formGUI/SectionComponent";

    export default {
        components: {SectionComponent},
        props: {
            form: {type: Object},
            formid: {type: Number},
        },
        data: () => ({
            formdata: {type: Object},
        }),
        methods: {
            updateInstances(index, instance) {
                this.formdata.sections[index].instances = instance;
            },
            Submit() {
                // parse form object
                let submitData = {};
                let i = 0;
                _.forEach(this.formdata.sections, function(value) {
                    if (value.isDynamic) { // parse sections
                        _.forEach(value.instances, function(value) {
                            _.forEach(value, function(value) {
                                _.forEach(value.controls, function(value) {
                                    submitData[i] = {
                                        label: value.label,
                                        value: value.value
                                    };
                                    i++;
                                });
                            });
                        });
                    } else {
                        _.forEach(value.rows, function(value) {
                            _.forEach(value.controls, function(value) {
                                submitData[i] = {
                                    label: value.label,
                                    value: value.value
                                };
                                i++;
                            });
                        });
                    }
                });
                //send to server
                console.log(submitData);
                axios.post('/api/post-form', {
                    formid: this.formid,
                    data: submitData
                  })
                  .then(
                    (response) => {
                      console.log(response);
                      window.location.href = '/success';
                    }
                  )
                  .catch(
                    (error) => console.log(error)
                  );
            }
        },
        created() {
            this.formdata = this.form;
        }
    }
</script>

<style module>
    label.required:after {
        content: "*";
        color: red;
    }
</style>
