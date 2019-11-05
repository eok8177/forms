<template>
    <div>
        <div class="row" v-if="labelPosition === 'left'">
            <div class="col-md-4">
                <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}">
                    {{value.label}}
                </label>
            </div>
            <div class="col-md-8">
                <input type="text"
                       class="form-control"
                       :readonly="value.readonly"
                       v-if="!value.isMultiLine"
                       :name="value.fieldName"
                       v-model="value.value" />
                <textarea v-else class="form-control"
                          v-model="value.value"
                          :readonly="value.readonly"
                          :name="value.fieldName"></textarea>
            </div>
        </div>
        <div v-else class="form-group">
            <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}">
                {{value.label}}
            </label>

            <input type="text"
                   class="form-control"
                   :readonly="value.readonly"
                   v-if="!value.isMultiLine"
                   :name="value.fieldName"
                   v-model="value.value" />
            <textarea v-else class="form-control"
                      v-model="value.value"
                      :readonly="value.readonly"
                      :name="value.fieldName"></textarea>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TextControl",
        props: ['value', 'labelPosition'],
        mounted() {
            if (!_.isEmpty(this.value.defaultValue)) {
                this.value.value = this.value.defaultValue;
            }
        }
    }
</script>

<style scoped>

</style>
