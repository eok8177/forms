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
            submitData: {},
            validForm: true,
        }),
        methods: {
            updateInstances(index, instance) {
                this.formdata.sections[index].instances = instance;
            },

            toggleSection(index) {
                if (index > 0) {
                    // parse & validate previous sections
                    this.parseForm(index);

                // collapse toggle logic: open previous not-valid section
                    if (this.validForm) {
                        $('#'+this.form.sections[index - 1].name + '_gui_body').collapse('hide');
                        $('#'+this.form.sections[index].name + '_gui_body').collapse('toggle');
                    } else {
                        $('#'+this.form.sections[index].name + '_gui_body').collapse('show');
                    }
                } else {
                    $('#'+this.form.sections[index].name + '_gui_body').collapse('toggle');
                }
            },
            Submit() {
                // parse all form object
                this.parseForm(false);

                //send to server
                if (this.validForm) {
                    this.sendFrom();
                }
            },

            parseForm(index) {
                let self = this;
                self.validForm = true;
                self.submitData = {};
                _.forEach(this.formdata.sections, function(section, key) {
                    if (index && key == index) return false;
                    if (section.isDynamic) { // parse in Dynamic section
                        _.forEach(section.instances, function(instance) {
                            _.forEach(instance, function(value) {
                                self.fillSubmitData(value.controls, key);
                            });
                        });
                    } else {
                        _.forEach(section.rows, function(row) {
                            self.fillSubmitData(row.controls, key);
                        });
                    }
                });
            },

            fillSubmitData(controls, section) {
                let self = this;
                let i = Object.keys(self.submitData).length;
                _.forEach(controls, function(control) {
                    // Validate start
                    let valid = true;
                    if (control.type != 'file' && control.type != 'html') { //TODO file
                        $('body [name="'+control.name+'"]').removeClass('is-invalid');
                        if (control.required) {
                            if (control.type != 'address' && !control.value) {
                                self.validForm = false;
                                valid = false
                                $('body [name="'+control.name+'"]').addClass('is-invalid');
                            }
                            // Validate Address block
                            if (control.type == 'address') {
                                for (var j = 1; j <= 5; j++) {
                                    $('body [name="'+control.name+j+'"]').removeClass('is-invalid');
                                    if (control['show'+j] && !control['value'+j] && j != 2) {
                                        self.validForm = false;
                                        valid = false
                                        $('body [name="'+control.name+j+'"]').addClass('is-invalid');
                                    }
                                }
                            }
                        }
                    }
                    //fill from address block
                    if (control.type == 'address') {
                        for (var j = 1; j <= 5; j++) {
                            if (control['show'+j]) {
                                self.submitData = Object.assign(self.submitData, {
                                    [i]: {
                                        label: control['label' + j],
                                        value: control['value' + j],
                                        valid: valid
                                    }
                                });
                                i++;
                            }
                        }
                    } else {
                        self.submitData = Object.assign(self.submitData, {
                            [i]: {
                                label: control.label,
                                value: control.value,
                                valid: valid
                            }
                        });
                        i++;
                    }

                    if (!valid) {
                        $('#'+self.form.sections[section].name + '_gui_body').collapse('show');
                    }
                });
            },

            sendFrom() {
                console.log(this.submitData);
                return false;
                axios.post('/api/post-form', {
                    formid: this.formid,
                    data: this.submitData
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
        },
        mounted() {
            // open first Section
            $('#'+this.form.sections[0].name + '_gui_body').collapse('show');
        }
    }
</script>

<style module>
    label.required:after {
        content: "*";
        color: red;
    }
</style>
