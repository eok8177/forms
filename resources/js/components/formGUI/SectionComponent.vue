<template>
    <div class="section" v-if="show">

      <button class="btn-collapse"
          type="button"
          data-toggle="collapse"
          :data-target="'#'+section.name + '_gui_body'"
          aria-expanded="false"
          @click.stop.prevent="toggleSection()" >
        <h2 class="mb-0">{{section.label}}</h2>
      </button>

      <div :id="section.name + '_gui_body'" class="collapse">
          <row-component v-model="section" :key="section.name" :index="index"></row-component>
      </div>
    </div>
</template>

<script>
    import RowComponent from "./RowComponent";

    export default {
        name: "SectionComponent",
        components: {RowComponent},
        props: ['section', 'index'],
        data: () => ({
            show: true,
            rules: {type: Object},
        }),
        created() {
            let self = this;

            if (this.section.isConditional) {
                this.show = this.section.condition.action_type == 'show' ? false : true;
                this.section.invisible = !this.show;

                _.each(this.section.condition.rules, (rule, key) => {
                    self.rules[key] = false;

                    // add Event to target field
                    $('body').on('change', '[name="'+rule.fieldId+'"]', function(){
                        let valid = false;
                        let numVal = parseFloat($(this).val());
                        let stringVal = $(this).val().toString();
                        if($(this).attr('type') == "checkbox") stringVal = this.checked ? 1 : 0;

                        switch(rule.operator) {
                          case 'is':
                            if (stringVal == rule.value) valid = true;
                            break;
                          case 'is_not':
                            if (stringVal != rule.value) valid = true;
                            break;
                          case 'greater':
                            if (numVal > rule.value) valid = true;
                            break;
                          case 'less':
                            if (numVal < rule.value) valid = true;
                            break;
                          case 'contain':
                            if (stringVal.indexOf(rule.value) >= 0) valid = true;
                            break;
                          case 'start':
                            if (stringVal.startsWith(rule.value)) valid = true;
                            break;
                          case 'end':
                            if (stringVal.endsWith(rule.value)) valid = true;
                            break;
                          default:
                            valid = false;
                        }
                        self.toggleField(key, valid);
                    });

                });

            }
        },
        mounted() {
            // open Section
            if (this.section.expanded) {
                this.$parent.openSection(this.index);
            }
        },
        methods: {
            toggleField(key, valid) {
                this.rules[key] = valid;
                let show = this.section.condition.logic_type == 'all' ? true : false;
                _.each(this.rules, (value) => {
                    if (this.section.condition.logic_type == 'all') { // AND logic
                        if (value === false) {
                            show = false;
                            return true;
                        }
                    }
                    if (this.section.condition.logic_type == 'any') { // OR logic
                        if (value === true) {
                            show = true;
                            return true;
                        }
                    }
                });
                this.show = this.section.condition.action_type == 'show' ? show : !show;
                this.section.invisible = !this.show;
            },

            toggleSection() {
                this.$parent.toggleSection(this.index);
            }
        }
    }
</script>

