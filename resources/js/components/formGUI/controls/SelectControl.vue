<template>
    <div>
        <div class="row" v-if="labelPosition === 'left'">
            <div class="col-md-4">
                <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}">
                    {{control.label}}
                </label>
            </div>
            <div class="col-md-8">
                <select class="form-control" 
                    v-model="control.value"
                    :multiple="control.isMultiple"
                    :disabled="this.control.readonly">
                  <option v-for="option in dataSource" v-bind:value="option.id">{{option.text}}</option>
                </select>
            </div>
        </div>

        <div class="form-group" v-else>
            <label :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline}">
                {{control.label}}
            </label>
            <select class="form-control" 
                v-model="control.value"
                :multiple="control.isMultiple"
                :disabled="this.control.readonly">
              <option v-for="option in dataSource" v-bind:value="option.id">{{option.text}}</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SelectControl",
        props:['propControl', 'labelPosition'],
        data: () => ({
            control: {type: Object},
            dataSource: [],
        }),
        created() {
            // request for ajax source
            if (this.control.isAjax) {
                let self = this;
                $.getJSON(this.control.ajaxDataUrl)
                    .done(data => {
                        if (_.isArray(data)) {
                            self.dataSource = data;
                        } else {
                            SethPhatToaster.error(`Control data error: ${this.control.label}.`);
                            console.error(`Data for select control of ${this.control.label} is wrong format!`);
                        }
                    })
                    .fail(err => {
                        SethPhatToaster.error(`Failed to load data for control: ${this.control.label}.`);
                        console.error("Request for Select Data Source Failed: ", err);
                    });
            } else {
                this.dataSource = this.propControl.dataOptions;
            }
        },
        mounted() {
            this.control= this.propControl;
            if (!_.isEmpty(this.control.defaultValue)) {
                if (this.control.isMultiple) {
                    this.control.value = [this.control.defaultValue];
                } else {
                    this.control.value = this.control.defaultValue;
                }
            }
        }
    }
</script>

<style scoped>

</style>
