<template>
    <div class="controlItem form-group" :class="control.className">
        <component :is="controlInstance" :propControl="control" :label-position="labelPosition"></component>
    </div>
</template>

<script>
    import {CONTROL_TYPES} from "./config/control_constant";

    export default {
        name: "ControlComponent",
        props: ['control', 'labelPosition'],
        data: () => ({
            controlInstance: null,
        }),
        created() {
            if (!CONTROL_TYPES[this.control.type]) {
                console.error(`Control type ${this.control.type} doesn't exist to render.`);
                return;
            }
            // set control
            this.controlInstance = CONTROL_TYPES[this.control.type].source;
        }
    }
</script>

<style scoped>

</style>
