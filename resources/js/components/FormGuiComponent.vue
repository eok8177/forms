<!--
/**
* Description:
* VueJS "Form GUI" Component (frontend)
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/
-->
<template>
    <div v-if="form !== null">

        <div class="d-flex justify-content-end mb-2">
            <a class="btn-expand" @click="expandAllSections()">expand all</a>
            <a class="btn-expand open" @click="collapseAllSections()">collapse all</a>
        </div>

        <!-- collapse layout -->
        <div class="accordion" v-if="form.layout === 'collapse'">

            <section-component v-for="(section, index) in form.sections"
                               :key="section.name" :index="index"
                               :section="section">
            </section-component>
        </div>

        <div class="d-flex justify-content-end mb-2 text-danger">{{errorMsg}}</div>

        <div class="d-flex justify-content-end mb-2 btns-right">
            <button v-if="userid > 0" @click="SaveApps()" class="save" :disabled="disabledBtn">Save</button>
            <button @click="Submit()" class="submit" :disabled="disabledBtn">Submit</button>
        </div>

        <div class="d-flex justify-content-end mb-2">
            <a class="btn-expand" @click="expandAllSections()">expand all</a>
            <a class="btn-expand open" @click="collapseAllSections()">collapse all</a>
        </div>

        <div v-if="msg">{{msg}}</div>

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
            status: 'draft',
            redirect_url: '/',
            appID: '',
            admin: false,
            msg: '',
            errorMsg: '',
            disabledBtn: false,
            redirect: true,
            regEmail: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
        }),
        methods: {
            updateInstances(index, instance) {
                this.formdata.sections[index].instances = instance;
            },

            toggleSection(index) {
                // parse & validate previous sections

                if ($('#'+this.formdata.sections[index].name + '_gui_body').hasClass('show')) {
                    this.parseForm(index);
                } else {
                    $('#'+this.formdata.sections[index].name + '_gui_body').collapse('toggle');
                }

                if (this.formdata.sections[index].valid) {
                    $('#'+this.formdata.sections[index].name + '_gui_body').collapse('toggle');
                }

                // hide prev Valid section
                if (index > 0 && this.formdata.sections[index-1].valid)
                    $('#'+this.formdata.sections[index-1].name + '_gui_body').collapse('hide');

            },
            openSection(index) {
                $('#'+this.form.sections[index].name + '_gui_body').collapse('show');
            },
            expandAllSections() {
                _.forEach(this.form.sections, function(section, key) {
                    $('#'+section.name + '_gui_body').collapse('show');
                });
            },
            collapseAllSections() {
                _.forEach(this.form.sections, function(section, key) {
                    $('#'+section.name + '_gui_body').collapse('hide');
                });
            },
            // Submti Form
            Submit() {
                // parse all form object
                this.parseForm(-1);

                //send to server
                if (this.validForm) {
                    this.status = 'submitted';
                    this.SaveApps();
                } else {
                    this.errorMsg = 'Please address issues highlighted and try again';
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
                    // disable validation on condition Section
                    if (section.invisible) self.validSection = true;

                    self.formdata.sections[key]['valid'] = self.validSection;
                    if (!self.validSection) self.validForm = false;
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
                        $('body .error-msg.'+control.name).hide();
                        if (control.required) {
                            if (control.type != 'address' && !control.value) {
                                valid = false;
                                $('body [name="'+control.name+'"]').addClass('is-invalid');
                            }
                            // Validate Address block
                            if (control.type == 'address') {
                                for (var j = 1; j <= 5; j++) {
                                    $('body [name="'+control.name+j+'"]').removeClass('is-invalid');
                                    if (control['show'+j] && !control['value'+j] && j != 2) {
                                        valid = false;
                                        $('body [name="'+control.name+j+'"]').addClass('is-invalid');
                                    }
                                }
                            }
                            if (control.isEmail) {
                                if (!self.regEmail.test(control.value)) {
                                    valid = false;
                                    $('body [name="'+control.name+'"]').addClass('is-invalid');
                                }
                            }
                            if (control.invisible) valid = true; // disable validation on condition field
                        }
                    }
                    if (control.type == 'file') {
                        $('body [name="'+control.name+'"]').removeClass('is-invalid');
                        $('body .error-msg.'+control.name).hide();
                        if (control.required) {
                            if (!control.value) {
                                valid = false;
                                $('body [name="'+control.name+'"]').addClass('is-invalid');
                                if (control.invisible) valid = true; // disable validation on condition field
                            } else {
                                if (!(control.value instanceof File) ) {
                                    // if empty string
                                    // when file not saved in last session
                                    if (control.value.length == 0) {
                                        valid = false;
                                        $('body [name="'+control.name+'"]').addClass('is-invalid');
                                    }
                                }
                            }
                        }
                    }
                    if (control.type == 'file' && control.value instanceof File) { // save files
                        self.files[control.name] = {
                            name: control.label,
                            data: control.value,
                            fieldId: control.fieldName,
                        };
                    }
                    if (!valid) {
                        self.validSection = false;
                        $('body .error-msg.'+control.name).show(); //show error message
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
                        console.log('not valid: '+control.label);
                        $('#'+self.form.sections[section].name + '_gui_body').collapse('show');
                    }
                });
            },

            async uploadFiles() {
                let self = this;
                let errorFile = [];
                let done = Object.keys(self.files).length;

                for (const key of Object.keys(self.files)) {
                    let file = self.files[key];
                    //if file already uploaded & input.value not has File object
                    if (typeof file.data === 'string' || !(file.data instanceof File) ) {
                        done = done - 1;
                        return true;
                    }

                    // upload File
                    let response = await self.httpUploadFile(file);

                    if (response.status == 'error') errorFile.push(key); // if error upload

                    done = done - 1;
                }

                if (errorFile.length > 0) {
                    errorFile.forEach(item => {
                        $('body .error-msg.'+item).show(); //show error message
                        $('body .error-msg.'+item).closest('.collapse').collapse('show');
                    });
                    this.disabledBtn = false;
                    return false;
                }

                if (done == 0 && self.status === 'submitted') {
                  self.postForm(); // submit form
                } else if (self.status != 'submitted') { // only save Draft application
                    if (self.redirect) {
                        window.location.href = '/user/draft-saved/'+self.formid;
                    } else {
                        self.msg = 'You draft is updated.';
                        this.disabledBtn = false;
                    }
                }
                return true;
            },

            // Save Draft
            SaveApps(notRedirect) {
                if (notRedirect) {
                    //send App to server without page redirect
                    this.redirect = false;
                } else {
                    this.redirect = true;
                }
                this.parseForm(-1);
                this.disabledBtn = true;
                let self = this;
                axios.post('/api/save-apps', {
                    userid: this.userid,
                    formid: this.formid,
                    appid:  this.appID,
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
            },

            // http method for upload file to server
            async httpUploadFile(file) {
                //change FileName if has restricted symbols
                let fileName = file.data.name.replace(/[/\?%*:|"<>#]/g, '-');

                var formData = new FormData();
                formData.append('appid', this.appID);
                formData.append('userid', this.userid);
                formData.append('formId', this.formid);
                formData.append('fieldName', file.name);
                formData.append('fieldId', file.fieldId);
                formData.append('file', file.data, fileName);
                try {
                    return await axios.post('/api/upload-file', formData, {
                        headers: {
                          'Content-Type': 'multipart/form-data'
                        }
                      });
                } catch (error) {
                    let msg = {};
                    if (error.response) {
                      msg = {
                        'fileName': fileName,
                        'type': 'Request made and server responded',
                        'data': error.response.data,
                        'status': error.response.status,
                        'headers': error.response.headers
                      };
                    } else {
                      msg = {
                        'fileName': fileName,
                        'type': 'Something happened in setting up the request that triggered an Error',
                        'request': error.message
                      };
                    }
                    // post error to Log
                    axios.post('/api/log', {
                        'type': 'Error upload file',
                        'error': error,
                        'appid': this.appID,
                        'msg': msg
                    });
                    this.errorMsg = 'Failed to upload file, please try again';

                    return {
                        status: 'error',
                        msg: msg
                    };
                }
            },
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
