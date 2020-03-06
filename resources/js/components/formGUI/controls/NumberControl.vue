<template>
    <div>
        <div class="row" v-if="labelPosition === 'left'" :class="value.cssClass">
            <div class="col-md-4">
                <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>
            </div>
            <div class="col-md-8">
                <div class="input-group">
                    <input type="number"
                       class="form-control"
                       :readonly="value.readonly"
                       :name="value.fieldName"
                       :step="controlStep"
                       :required="value.required"
                       :min="value.minValue"
                       :max="value.maxValue"
                       @change="numberChange"
                       v-model="value.value" />
                </div>
            </div>
        </div>
        <div class="form-group" v-else :class="value.cssClass">
            <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline, 'required': value.required}" v-html="value.label"></label>

            <div class="input-group">
                <input type="number"
                   class="form-control"
                   :readonly="value.readonly"
                   :name="value.fieldName"
                   :step="controlStep"
                   :required="value.required"
                   :min="value.minValue"
                   :max="value.maxValue"
                   @change="numberChange"
                   v-model="value.value" />
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NumberControl",
        props: ['value', 'labelPosition'],
        created() {
            // this.value.value = 0;
        },
        mounted() {
            // if (!_.isEmpty(this.value.value)) {
            //     this.value.value = this.value.value;
            // }
            this.value.readonly = this.$parent.$parent.$parent.$parent.admin;
        },
        methods: {
            numberChange(e) {
                let val = e.target.value;

                if (this.value.isInteger === false) {
                    this.value.value = parseFloat(val).toFixed(this.value.decimalPlace);
                } else {
                    this.value.value = parseInt(val);
                }
            }
        },
        computed: {
            controlStep() {
                return 1;
            }
        }
    }
</script>

<style scoped>

</style>
