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

                    // toggle section on init
                    self.conditionField(rule, key);

                    // add Event to target field
                    $('body').on('change', '[name="'+rule.fieldId+'"]', function(){
                        self.conditionField(rule, key);
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
            },

            // search control in form object by fieldName
            searchInForm(fieldName) {
                let self = this;
                let field = false;
                _.forEach(this.$parent.form.sections, function(section, key) {
                    if (section.isDynamic) { // search in Dynamic section
                        _.forEach(section.instances, function(instance) {
                             _.forEach(instance, function(row) {
                                _.forEach(row.controls, function(control) {
                                    if (control.fieldName == fieldName) {
                                        field = control;
                                    }
                                });
                            });
                        });
                    } else {
                        _.forEach(section.rows, function(row) {
                            _.forEach(row.controls, function(control) {
                                if (control.fieldName == fieldName) {
                                    field = control;
                                }
                            });
                        });
                    }
                });
                return field;
            },

            // condition Field logic
            conditionField(rule, key) {
                let self = this;
                let field = self.searchInForm(rule.fieldId); // get control from form object
                let valid = false;
                let ruleValue = rule.value;
                let numVal = parseFloat(field.value);
                let stringVal = field.value ? field.value.toString() : '';
                if(field.type == "checkbox") stringVal = field.value ? 1 : 0;

                if(field.type == "datepicker") {
                    ruleValue = parseFloat(moment(rule.value, DATE_FORMAT.toUpperCase()).valueOf());
                    numVal = parseFloat(moment(stringVal, DATE_FORMAT.toUpperCase()).valueOf());
                    stringVal = moment(stringVal, DATE_FORMAT.toUpperCase()).valueOf();
                }

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
            },

        }
    }
</script>

