<template>
    <div class="controlItemWrapper" :class="control.className" :data-control-name="control.name">
        <div class="tools" @click="removeItem(control.name)"><span class="clickable fa fa-times"></span></div>

        <div :class="control.cssClass" class="controlItem pl-3" :id="control.name">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="agree">
              <label class="form-check-label" for="agree" 
                :class="{'bold': control.labelBold, 'italic': control.labelItalic, 'underline': control.labelUnderline, 'required': control.required}"
                v-html="control.label"></label>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "AllFieldsControl",
        props: ['control', 'labelPosition'],
        methods: {
            removeItem: function(name) {
                this.$emit('removeItem', name);
            }
        }
    }
</script>

<style scoped>

</style>
