<template>
    <div class="controlItem form-group" :class="control.className" v-if="show">
        <component :is="controlInstance" v-model="control" :label-position="labelPosition"></component>
    </div>
</template>

<script>
    import {CONTROL_TYPES} from "./config/control_constant";

    export default {
        name: "ControlComponent",
        props: ['control', 'labelPosition'],
        data: () => ({
            controlInstance: null,
            show: true,
        }),
        created() {
            let self = this;
            if (!CONTROL_TYPES[this.control.type]) {
                console.error(`Control type ${this.control.type} doesn't exist to render.`);
                return;
            }
            // set control
            this.controlInstance = CONTROL_TYPES[this.control.type].source;

            if (this.control.isCalculated) {
                console.log(this.control);
                this.show = this.control.condition.action_type == 'show' ? false : true;

                _.each(this.control.condition.rules, (rule) => {

                    // add Event to target field
                    $('body').on('change', 'input[name="'+rule.fieldId+'"]', function(){
                        let valid = false;
                        switch(rule.operator) {
                          case 'is':
                            if (parseInt($(this).val()) == rule.value) valid = true;
                            break;
                          case 'is_not':
                            if (parseInt($(this).val()) != rule.value) valid = true;
                            break;
                          case 'greater':
                            if (parseInt($(this).val()) > rule.value) valid = true;
                            break;
                          case 'less':
                            if (parseInt($(this).val()) < rule.value) valid = true;
                            break;
                          default:
                            valid = false;
                        }
                        self.toggleField(valid);
                    });

                });

            }
        },
        methods: {
            toggleField(valid) {
                //TODO: add login on this.control.condition.logic_type AND many rules
                this.show = this.control.condition.action_type == 'show' ? valid : !valid;
            }
        }
    }
</script>

<style scoped>

</style>
