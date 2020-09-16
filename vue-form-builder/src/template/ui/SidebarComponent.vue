<template>
    <div class="card">
        <div class="controlSidebar list-group" v-show="!isConfig">
            <a href="#" class="list-group-item active">
                Supported Controls
            </a>
            <div id="sidebarControls">
                <a href="javascript:void(0)" class="list-group-item list-group-item-action control-wrapper"
                   v-for="(obj, value) in controls" :data-control-type="value">
                    <font-awesome-icon :icon="obj.icon"></font-awesome-icon> {{obj.label}}
                </a>
            </div>
        </div>
        <div class="settingSidebar card" v-if="isConfig">
            <div class="card-body">

                <h4 class="pb-1 border-bottom" v-html="controlInfo.label"></h4>


                <base-config-component :control="controlInfo"></base-config-component>

                <component v-if="configComponent != null"
                           :is="configComponent"
                           :control="controlInfo">
                </component>

                <base-style-component :control="controlInfo"></base-style-component>

                <div class="d-flex mb-2" :class="message.type" v-if="message.show">{{message.text}}</div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-outline-info" @click="applyEditSidebar">Apply</button>
                    <button class="btn btn-outline-secondary" @click="closeEditSidebar">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {CONTROL_TYPES} from "sethFormBuilder/config/control_constant";
    import {eventBus, EventHandlerConstant} from 'sethFormBuilder/template/handler/event_handler';
    import {ControlHandler} from 'sethFormBuilder/template/handler/control_handler';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import {Hooks} from 'sethFormBuilder/template/components/hook_lists';
    import BaseConfigComponent from "./sidebar_items/BaseConfigComponent";
    import BaseStyleComponent from "./sidebar_items/BaseStyleComponent";

    export default {
        components: {BaseStyleComponent, BaseConfigComponent, FontAwesomeIcon},
        name: "sidebar-component",
        data: () => ({
            controls: CONTROL_TYPES,
            isConfig: false,
            controlInfo: null,
            configComponent: null,
            message: {
                show: false,
                text: '',
                type: ''
            },
        }),
        methods: {
            closeEditSidebar() {
                this.isConfig = false;
                this.controlInfo = null;
                ControlHandler.clearSelect();
            },
            applyEditSidebar() {
                let self = this;
                if (this.controlInfo.name !== ControlHandler.getSelectedItem()) {
                    return;
                }

                // pre apply
                this.controlInfo.decimalPlace = parseInt(this.controlInfo.decimalPlace);

                // before hook here
                let b4Run = Hooks.Sidebar.beforeApplyConfig.runSequence(this.controlInfo);
                if (b4Run === false) {
                    return;
                }

                eventBus.$emit(EventHandlerConstant.ON_APPLY_EDITOR_SIDEBAR, this.controlInfo);

                // after hook here
                Hooks.Sidebar.afterApplyConfig.run(this.controlInfo);

                // show message under button Apply
                this.message.text = 'Settings updated successfully';
                this.message.type = 'text-success';
                this.message.show = true;
                setInterval(() => {
                        self.message.show = false;
                        self.message.text = '';
                }, 3000);
            }
        },
        created() {
            // catch event activate sidebar here
            eventBus.$on(EventHandlerConstant.ACTIVATE_EDITOR_SIDEBAR, controlInfo => {
                // before hook here
                let b4Run = Hooks.Sidebar.beforeOpenConfig.runSequence(controlInfo);
                if (b4Run === false) {
                    return;
                }

                // open config
                this.isConfig = true;
                this.controlInfo = controlInfo;
                this.configComponent = null;

                // retrieve config component
                if (_.accessStr(this.controls[controlInfo.type], 'source.config')){
                    this.configComponent = this.controls[controlInfo.type].source.config;
                }

                // after hook here
                Hooks.Sidebar.afterOpenConfig.run(this.controlInfo);
            });

            //close Sidebar config on delete control item
            eventBus.$on(EventHandlerConstant.REMOVE_CONTROL, name => {
                this.closeEditSidebar();
            });
            eventBus.$on(EventHandlerConstant.REMOVE_CONTROL_ITEM, name => {
                this.closeEditSidebar();
            });
        },
        mounted() {
            // insert controls
            $(".list-group-item", $("#sidebarControls")).draggable({
                appendTo: 'body',
                containment: '',
                scroll: false,
                helper: 'clone',
                revert: true,
                zIndex: 9999,
                cancel: ".list-group-item-success",
                start: function(event, ui){
                    $(ui.helper).css('width', `${ $(event.target).width() }px`);
                }
            });

            $(this.$el).find('.controlSidebar').droppable({
                accept: ".controlItemWrapper",
                drop: function (event, ui){
                    // remove control
                    eventBus.$emit(EventHandlerConstant.REMOVE_CONTROL, ui);
                },
                over: function( event, ui ) {
                    ui.helper.css('border', '1px solid red');
                },
            });
        }
    }
</script>

<style scoped>

</style>
