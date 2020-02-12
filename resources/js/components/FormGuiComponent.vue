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
        <button v-if="userid > 0" @click="SaveApps()" class="btn btn-outline-secondary">Save & fill later</button>


        <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">My data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row border-bottom">
                    <div class="col"><b>Field Name</b></div>
                    <div class="col"><b>Value</b></div>
                </div>
                <div class="row" v-for="item in submitData">
                    <div class="col">{{item.label}}</div>
                    <div class="col">{{item.value}}</div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>


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
            appid: {type: Number},
            userid: {type: Number},
        },
        data: () => ({
            formdata: {type: Object},
            submitData: {},
            validForm: true,
            validSection: true,
            files: {},
            entryid: '',
            status: 'draft',
            redirect_url: '/',
            appID: ''
        }),
        methods: {
            updateInstances(index, instance) {
                this.formdata.sections[index].instances = instance;
            },

            toggleSection(index) {
                // parse & validate previous sections
                this.parseForm(index);

                if (this.formdata.sections[index].valid) {
                    $('#'+this.formdata.sections[index].name + '_gui_body').collapse('toggle');
                }

                // hide prev Valid section
                if (index > 0 && this.formdata.sections[index-1].valid)
                    $('#'+this.formdata.sections[index-1].name + '_gui_body').collapse('hide');

            },
            Submit() {
                // parse all form object
                this.parseForm(-1);

                //send to server
                if (this.validForm) {
                    this.status = 'submitted';
                    this.SaveApps();
                }
            },

            parseForm(index) {
                let self = this;
                self.validForm = true;
                self.submitData = {};
                _.forEach(this.formdata.sections, function(section, key) {
                    self.validSection = true;
                    if (index >= 0 && key > index) return false;
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
                    self.formdata.sections[key]['valid'] = self.validSection;
                });
            },

            fillSubmitData(controls, section) {
                let self = this;
                let i = Object.keys(self.submitData).length;
                _.forEach(controls, function(control) {
                    // Validate start
                    let valid = true;
                    if (control.type != 'file' && control.type != 'html') {
                        $('body [name="'+control.name+'"]').removeClass('is-invalid');
                        if (control.required) {
                            if (control.type != 'address' && !control.value) {
                                self.validForm = false;
                                self.validSection = false;
                                valid = false
                                $('body [name="'+control.name+'"]').addClass('is-invalid');
                            }
                            // Validate Address block
                            if (control.type == 'address') {
                                for (var j = 1; j <= 5; j++) {
                                    $('body [name="'+control.name+j+'"]').removeClass('is-invalid');
                                    if (control['show'+j] && !control['value'+j] && j != 2) {
                                        self.validForm = false;
                                        self.validSection = false;
                                        valid = false
                                        $('body [name="'+control.name+j+'"]').addClass('is-invalid');
                                    }
                                }
                            }
                        }
                    }
                    if (control.type == 'file' && control.value) { // save files
                        self.files[control.name] = {
                            name: control.label,
                            data: control.value,
                            fieldId: control.fieldName,
                        };
                    }
                    //fill from address block
                    if (control.type == 'address') {
                        for (var j = 1; j <= 5; j++) {
                            if (control['show'+j] && control['value' + j]) {
                                self.submitData = Object.assign(self.submitData, {
                                    [i]: {
                                        label: control['label' + j],
                                        value: control['value' + j],
                                        valid: valid,
                                        field_id: control['label' + j]
                                    }
                                });
                                i++;
                            }
                        }
                    } else if (control.type != 'file' && control.type != 'html' && control.value) {
                        self.submitData = Object.assign(self.submitData, {
                            [i]: {
                                label: control.label,
                                value: control.value,
                                valid: valid,
                                field_id: control.fieldName
                            }
                        });
                        i++;
                    }

                    if (!valid) {
                        $('#'+self.form.sections[section].name + '_gui_body').collapse('show');
                    }
                });
            },

            uploadFiles() {
                let self = this;
                let done = Object.keys(self.files).length;
                console.log(done);
                _.forEach(self.files, function(file,key) {
                    var formData = new FormData();
                    formData.append('appid', self.appID);
                    formData.append('entryId', self.entryid);
                    formData.append('userid', self.userid);
                    formData.append('formId', self.formid);
                    formData.append('fieldName', file.name);
                    formData.append('fieldId', file.fieldId);
                    formData.append('file', file.data);
                    axios.post('/api/upload-file', formData, {
                        headers: {
                          'Content-Type': 'multipart/form-data'
                        }
                      }).then(
                        (response) => {
                          done = done - 1;
                          if (done == 0 && self.status == 'submitted') {
                            self.postForm();
                          }
                        }
                      ).catch((error) => console.log(error));
                });
            },

            SaveApps() {
                this.parseForm(-1);
                let self = this;
                axios.post('/api/save-apps', {
                    userid: this.userid,
                    formid: this.formid,
                    appid:  this.appID,
                    entryid: this.entryid,
                    status: this.status,
                    data: this.form
                  })
                  .then(
                    (response) => {
                      self.appID = response.data.appid;
                      self.redirect_url = response.data.redirect_url;
                      this.uploadFiles();
                    }
                  )
                  .catch(
                    (error) => console.log(error)
                  );
            },
            postForm()
            {
                let self = this;
                axios.post('/api/post-form', {
                    appid:  this.appID,
                  })
                  .then(
                    (response) => {
                      window.location.href = self.redirect_url;
                    }
                  )
                  .catch((error) => console.log(error));
            }
        },
        created() {
            this.formdata = this.form;
            this.appID = this.appid;
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
