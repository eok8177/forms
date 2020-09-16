<template>
    <div class="row">
        <div class="col-md-8">
            <section-component :form="form" ref="SectionComponent"></section-component>
        </div>
        <div class="col-md-4 sticky-block">
            <sidebar-component></sidebar-component>

            <div class="my-3 text-right">
                <div v-if="$parent.$parent.status" class="text-success mb-1">Config updated</div>
                <button class="btn btn-secondary" @click="saveConfig()">Save Form Settings</button>
            </div>
        </div>
    </div>
</template>

<script>
    import SectionComponent from "./ui/SectionComponent";
    import { dom } from '@fortawesome/fontawesome-svg-core'
    import SidebarComponent from "./ui/SidebarComponent";
    dom.watch();

    var default_form_value = () => ({
        sections: [],
        layout: "",
        _uniqueId: Math.random()
    });

    export default {
        name: "form-builder-template",
        components: {
            SidebarComponent,
            SectionComponent
        },
        props: {
            form: {
                type: Object
            }
        },
        methods: {
            getValue() {
                return this.form;
            },
            setValue(val) {
                this.form = val;
            },
            saveConfig() {
                this.$parent.$parent.saveConfig();
            }
        }
    }
</script>

<style scoped>

</style>
