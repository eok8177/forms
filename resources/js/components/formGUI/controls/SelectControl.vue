<!--
/**
* Description:
* VueJS Select Control (frontend)
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/
-->
<template>
    <div>
        <div class="row" v-if="labelPosition === 'left'" :class="value.cssClass">
            <div class="col-md-4">
                <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>
            </div>
            <div class="col-md-8">
                <select class="form-control" 
                    v-model="value.value"
                    :multiple="value.isMultiple"
                    :name="value.fieldName"
                    :required="value.required"
                    :disabled="value.readonly">
                  <option v-for="option in dataSource" v-bind:value="option.id">{{option.text}}</option>
                </select>
            </div>
        </div>

        <div class="form-group" v-else :class="value.cssClass">
            <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>
            <select class="form-control" 
                v-model="value.value"
                :multiple="value.isMultiple"
                :name="value.fieldName"
                :required="value.required"
                :disabled="value.readonly">
              <option v-for="option in dataSource" v-bind:value="option.id">{{option.text}}</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SelectControl",
        props:['value', 'labelPosition'],
        data: () => ({
            dataSource: [],
        }),
        created() {
            // request for ajax source
            if (this.value.isAjax) {
                let self = this;
                $.getJSON(this.value.ajaxDataUrl)
                    .done(data => {
                        if (_.isArray(data)) {
                            self.dataSource = data;
                        } else {
                            SethPhatToaster.error(`Control data error: ${this.value.label}.`);
                            console.error(`Data for select control of ${this.value.label} is wrong format!`);
                        }
                    })
                    .fail(err => {
                        SethPhatToaster.error(`Failed to load data for control: ${this.value.label}.`);
                        console.error("Request for Select Data Source Failed: ", err);
                    });
            } else {
                this.dataSource = this.value.dataOptions;
            }
        },
        mounted() {
            if (!_.isEmpty(this.value.defaultValue)) {
                if (this.value.isMultiple) {
                    this.value.value = [this.value.defaultValue];
                } else {
                    this.value.value = this.value.defaultValue;
                }
            }
            this.value.readonly = this.$parent.$parent.$parent.$parent.admin;
        }
    }
</script>

<style scoped>

</style>
