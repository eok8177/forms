(window.webpackJsonp=window.webpackJsonp||[]).push([[1],{40:function(t,o,e){"use strict";e.r(o);function l(t,o,e,l,n,a,r,c){var i,s="function"==typeof t?t.options:t;if(o&&(s.render=o,s.staticRenderFns=e,s._compiled=!0),l&&(s.functional=!0),a&&(s._scopeId="data-v-"+a),r?(i=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),n&&n.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(r)},s._ssrRegister=i):n&&(i=c?function(){n.call(this,this.$root.$options.shadowRoot)}:n),i)if(s.functional){s._injectStyles=i;var u=s.render;s.render=function(t,o){return i.call(o),u(t,o)}}else{var d=s.beforeCreate;s.beforeCreate=d?[].concat(d,i):[i]}return{exports:t,options:s}}var n=l({name:"CheckboxControl",props:["propControl","labelPosition"],data:function(){return{control:{type:Object}}},mounted:function(){this.control=this.propControl,this.control.isChecked&&(this.control.value=!0)}},(function(){var t=this,o=t.$createElement,e=t._self._c||o;return e("div",["left"===t.labelPosition?e("div",{staticClass:"custom-control custom-switch"},[e("input",{directives:[{name:"model",rawName:"v-model",value:t.control.value,expression:"control.value"}],staticClass:"custom-control-input",attrs:{type:"checkbox",id:t.control.name+"_gui_control",readonly:this.control.readonly,name:t.control.fieldName},domProps:{checked:Array.isArray(t.control.value)?t._i(t.control.value,null)>-1:t.control.value},on:{change:function(o){var e=t.control.value,l=o.target,n=!!l.checked;if(Array.isArray(e)){var a=t._i(e,null);l.checked?a<0&&t.$set(t.control,"value",e.concat([null])):a>-1&&t.$set(t.control,"value",e.slice(0,a).concat(e.slice(a+1)))}else t.$set(t.control,"value",n)}}}),t._v(" "),e("label",{class:{bold:t.control.labelBold,italic:t.control.labelItalic,underline:t.control.labelUnderline}+" custom-control-label",attrs:{for:t.control.name+"_gui_control"}},[t._v("\n            "+t._s(t.control.label)+"\n        ")])]):e("div",{staticClass:"form-check"},[e("input",{directives:[{name:"model",rawName:"v-model",value:t.control.value,expression:"control.value"}],staticClass:"form-check-input",attrs:{type:"checkbox",id:t.control.name+"_gui_control",readonly:this.control.readonly,name:t.control.fieldName},domProps:{checked:Array.isArray(t.control.value)?t._i(t.control.value,null)>-1:t.control.value},on:{change:function(o){var e=t.control.value,l=o.target,n=!!l.checked;if(Array.isArray(e)){var a=t._i(e,null);l.checked?a<0&&t.$set(t.control,"value",e.concat([null])):a>-1&&t.$set(t.control,"value",e.slice(0,a).concat(e.slice(a+1)))}else t.$set(t.control,"value",n)}}}),t._v(" "),e("label",{class:{bold:t.control.labelBold,italic:t.control.labelItalic,underline:t.control.labelUnderline}+" form-check-label",attrs:{for:t.control.name+"_gui_control"}},[t._v("\n            "+t._s(t.control.label)+"\n        ")])])])}),[],!1,null,"642d7acc",null).exports,a={},r={};a.SectionLayout={collapse:"Collapse",tab:"Tab"},a.Section={name:"",label:"",clientKey:"",order:0,rows:[],labelPosition:"left",isDynamic:!1,minInstance:1,maxInstance:0,instances:[]},a.Row={name:"",label:"",order:0,controls:[]},a.Control={type:"",name:"",fieldName:"",label:"",order:0,defaultValue:"",value:"",className:"col-md-4",readonly:!1,labelBold:!1,labelItalic:!1,labelUnderline:!1,required:!1,isMultiLine:!1,isInteger:!1,decimalPlace:0,isTodayValue:!1,dateFormat:"dd/mm/yy",isNowTimeValue:!1,timeFormat:"HH:mm",isMultiple:!1,isAjax:!1,dataOptions:[],ajaxDataUrl:"",isChecked:!1},a.Type={text:{label:"Text Input",icon:"faEdit"},number:{label:"Number Input",icon:"faCalculator"},datepicker:{label:"Date Picker",icon:"faCalendarAlt"},timepicker:{label:"Time Picker",icon:"faClock"},select:{label:"Select Option",icon:"faDatabase"},checkbox:{label:"Checkbox",icon:"faCheck"}},a.WidthOptions={"col-md-1":"Width 1 parts","col-md-2":"Width 2 parts","col-md-3":"Width 3 parts","col-md-4":"Width 4 parts","col-md-5":"Width 5 parts","col-md-6":"Width 6 parts","col-md-7":"Width 7 parts","col-md-8":"Width 8 parts","col-md-9":"Width 9 parts","col-md-10":"Width 10 parts","col-md-11":"Width 11 parts","col-md-12":"Width 12 parts"},a.OptionDefault={id:"",text:""},r.DateFormat={"dd/mm/yy":"D/M/YYYY","dd-mm-yy":"D-M-YYYY","mm/dd/yy":"M/D/YYYY","mm-dd-yy":"M/D/YYYY","yy/mm/dd":"YYYY/M/D","yy-mm-dd":"YYYY-M-D"},r.TimeFormat={"H:m":"H:m","HH:mm":"HH:mm","h:m p":"h:m A","hh:mm p":"hh:mm A"};var c=l({name:"DatePickerControl",props:["propControl","labelPosition"],data:function(){return{control:{type:Object},options:{}}},created:function(){this.control=this.propControl,this.options.dateFormat=this.control.dateFormat,_.isEmpty(this.control.value)&&(_.isEmpty(this.control.defaultValue)?this.control.isTodayValue&&(this.control.value=moment().format(r.DateFormat[this.control.dateFormat])):this.control.value=this.control.defaultValue)},mounted:function(){this.control=this.propControl}},(function(){var t=this,o=t.$createElement,e=t._self._c||o;return e("div",["left"===t.labelPosition?e("div",{staticClass:"form-group row datePickerControl"},[e("label",{class:{bold:t.control.labelBold,italic:t.control.labelItalic,underline:t.control.labelUnderline}+" col-sm-4 col-form-label"},[t._v("\n            "+t._s(t.control.label)+"\n        ")]),t._v(" "),e("div",{staticClass:"col-sm-8"},[e("input",{directives:[{name:"model",rawName:"v-model",value:t.control.value,expression:"control.value"}],staticClass:"form-control",attrs:{type:"date",readonly:this.control.readonly,name:t.control.fieldName},domProps:{value:t.control.value},on:{input:function(o){o.target.composing||t.$set(t.control,"value",o.target.value)}}})])]):e("div",{staticClass:"form-group"},[e("label",{class:{bold:t.control.labelBold,italic:t.control.labelItalic,underline:t.control.labelUnderline}},[t._v("\n            "+t._s(t.control.label)+"\n        ")]),t._v(" "),e("input",{directives:[{name:"model",rawName:"v-model",value:t.control.value,expression:"control.value"}],staticClass:"form-control",attrs:{type:"date",readonly:this.control.readonly,name:t.control.fieldName},domProps:{value:t.control.value},on:{input:function(o){o.target.composing||t.$set(t.control,"value",o.target.value)}}})])])}),[],!1,null,"7f457222",null).exports,i=l({name:"NumberControl",props:["propControl","labelPosition"],data:function(){return{control:{type:Object}}},created:function(){this.control=this.propControl,this.control.value=0},mounted:function(){this.control=this.propControl,_.isEmpty(this.control.defaultValue)||(this.control.value=this.control.defaultValue)},methods:{numberChange:function(t){var o=t.target.value;!1===this.control.isInteger?this.control.value=parseFloat(o).toFixed(this.control.decimalPlace):this.control.value=parseInt(o)}},computed:{controlStep:function(){return 1}}},(function(){var t=this,o=t.$createElement,e=t._self._c||o;return e("div",["left"===t.labelPosition?e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-4"},[e("label",{class:{bold:t.control.labelBold,italic:t.control.labelItalic,underline:t.control.labelUnderline}},[t._v(t._s(t.control.label))])]),t._v(" "),e("div",{staticClass:"col-md-8"},[e("div",{staticClass:"input-group"},[e("input",{directives:[{name:"model",rawName:"v-model",value:t.control.value,expression:"control.value"}],staticClass:"form-control",attrs:{type:"number",readonly:this.control.readonly,name:t.control.fieldName,step:t.controlStep},domProps:{value:t.control.value},on:{change:t.numberChange,input:function(o){o.target.composing||t.$set(t.control,"value",o.target.value)}}})])])]):e("div",{staticClass:"form-group"},[e("label",{class:{bold:t.control.labelBold,italic:t.control.labelItalic,underline:t.control.labelUnderline}},[t._v("\n            "+t._s(t.control.label)+"\n        ")]),t._v(" "),e("div",{staticClass:"input-group"},[e("input",{directives:[{name:"model",rawName:"v-model",value:t.control.value,expression:"control.value"}],staticClass:"form-control",attrs:{type:"number",readonly:this.control.readonly,name:t.control.fieldName,step:t.controlStep},domProps:{value:t.control.value},on:{change:t.numberChange,input:function(o){o.target.composing||t.$set(t.control,"value",o.target.value)}}})])])])}),[],!1,null,"5f7728ae",null).exports,s=l({name:"SelectControl",props:["propControl","labelPosition"],data:function(){return{control:{type:Object},dataSource:[]}},created:function(){var t=this;if(this.control.isAjax){var o=this;$.getJSON(this.control.ajaxDataUrl).done((function(e){_.isArray(e)?o.dataSource=e:(SethPhatToaster.error("Control data error: ".concat(t.control.label,".")),console.error("Data for select control of ".concat(t.control.label," is wrong format!")))})).fail((function(o){SethPhatToaster.error("Failed to load data for control: ".concat(t.control.label,".")),console.error("Request for Select Data Source Failed: ",o)}))}else this.dataSource=this.propControl.dataOptions},mounted:function(){this.control=this.propControl,_.isEmpty(this.control.defaultValue)||(this.control.isMultiple?this.control.value=[this.control.defaultValue]:this.control.value=this.control.defaultValue)}},(function(){var t=this,o=t.$createElement,e=t._self._c||o;return e("div",["left"===t.labelPosition?e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-4"},[e("label",{class:{bold:t.control.labelBold,italic:t.control.labelItalic,underline:t.control.labelUnderline}},[t._v("\n                "+t._s(t.control.label)+"\n            ")])]),t._v(" "),e("div",{staticClass:"col-md-8"},[e("select",{directives:[{name:"model",rawName:"v-model",value:t.control.value,expression:"control.value"}],staticClass:"form-control",attrs:{multiple:t.control.isMultiple,disabled:this.control.readonly},on:{change:function(o){var e=Array.prototype.filter.call(o.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.$set(t.control,"value",o.target.multiple?e:e[0])}}},t._l(t.dataSource,(function(o){return e("option",{domProps:{value:o.id}},[t._v(t._s(o.text))])})),0)])]):e("div",{staticClass:"form-group"},[e("label",{class:{bold:t.control.labelBold,italic:t.control.labelItalic,underline:t.control.labelUnderline}},[t._v("\n            "+t._s(t.control.label)+"\n        ")]),t._v(" "),e("select",{directives:[{name:"model",rawName:"v-model",value:t.control.value,expression:"control.value"}],staticClass:"form-control",attrs:{multiple:t.control.isMultiple,disabled:this.control.readonly},on:{change:function(o){var e=Array.prototype.filter.call(o.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.$set(t.control,"value",o.target.multiple?e:e[0])}}},t._l(t.dataSource,(function(o){return e("option",{domProps:{value:o.id}},[t._v(t._s(o.text))])})),0)])])}),[],!1,null,"822bea36",null).exports,u={text:{label:"Text Input",source:l({name:"TextControl",props:["propControl","labelPosition"],data:function(){return{control:{type:Object}}},mounted:function(){this.control=this.propControl,_.isEmpty(this.control.defaultValue)||(this.control.value=this.control.defaultValue)}},(function(){var t=this,o=t.$createElement,e=t._self._c||o;return e("div",["left"===t.labelPosition?e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-4"},[e("label",{class:{bold:t.control.labelBold,italic:t.control.labelItalic,underline:t.control.labelUnderline}},[t._v("\n                "+t._s(t.control.label)+"\n            ")])]),t._v(" "),e("div",{staticClass:"col-md-8"},[t.control.isMultiLine?e("textarea",{directives:[{name:"model",rawName:"v-model",value:t.control.value,expression:"control.value"}],staticClass:"form-control",attrs:{readonly:this.control.readonly,name:t.control.fieldName},domProps:{value:t.control.value},on:{input:function(o){o.target.composing||t.$set(t.control,"value",o.target.value)}}}):e("input",{directives:[{name:"model",rawName:"v-model",value:t.control.value,expression:"control.value"}],staticClass:"form-control",attrs:{type:"text",readonly:this.control.readonly,name:t.control.fieldName},domProps:{value:t.control.value},on:{input:function(o){o.target.composing||t.$set(t.control,"value",o.target.value)}}})])]):e("div",{staticClass:"form-group"},[e("label",{class:{bold:t.control.labelBold,italic:t.control.labelItalic,underline:t.control.labelUnderline}},[t._v("\n            "+t._s(t.control.label)+"\n        ")]),t._v(" "),t.control.isMultiLine?e("textarea",{directives:[{name:"model",rawName:"v-model",value:t.control.value,expression:"control.value"}],staticClass:"form-control",attrs:{readonly:this.control.readonly,name:t.control.fieldName},domProps:{value:t.control.value},on:{input:function(o){o.target.composing||t.$set(t.control,"value",o.target.value)}}}):e("input",{directives:[{name:"model",rawName:"v-model",value:t.control.value,expression:"control.value"}],staticClass:"form-control",attrs:{type:"text",readonly:this.control.readonly,name:t.control.fieldName},domProps:{value:t.control.value},on:{input:function(o){o.target.composing||t.$set(t.control,"value",o.target.value)}}})])])}),[],!1,null,"72a00ba4",null).exports},number:{label:"Number Input",source:i},datepicker:{label:"Date Picker",source:c},timepicker:{label:"Time Picker",source:l({name:"TimePickerControl",props:["propControl","labelPosition"],data:function(){return{control:{type:Object},options:{zindex:1111}}},created:function(){this.control=this.propControl,this.options.timeFormat=this.control.timeFormat,_.isEmpty(this.control.defaultValue)||(this.control.value=this.control.defaultValue),this.control.isNowTimeValue&&(this.control.value=moment().format(r.TimeFormat[this.control.timeFormat]))}},(function(){var t=this,o=t.$createElement,e=t._self._c||o;return e("div",["left"===t.labelPosition?e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-4"},[e("label",{class:{bold:t.control.labelBold,italic:t.control.labelItalic,underline:t.control.labelUnderline}},[t._v("\n                "+t._s(t.control.label)+"\n            ")])]),t._v(" "),e("div",{staticClass:"col-md-8"},[e("input",{directives:[{name:"model",rawName:"v-model",value:t.control.value,expression:"control.value"}],staticClass:"form-control",attrs:{type:"time",readonly:this.control.readonly,name:t.control.fieldName},domProps:{value:t.control.value},on:{input:function(o){o.target.composing||t.$set(t.control,"value",o.target.value)}}})])]):e("div",{staticClass:"form-group"},[e("label",{class:{bold:t.control.labelBold,italic:t.control.labelItalic,underline:t.control.labelUnderline}},[t._v("\n            "+t._s(t.control.label)+"\n        ")]),t._v(" "),e("input",{directives:[{name:"model",rawName:"v-model",value:t.control.value,expression:"control.value"}],staticClass:"form-control",attrs:{type:"time",readonly:this.control.readonly,name:t.control.fieldName},domProps:{value:t.control.value},on:{input:function(o){o.target.composing||t.$set(t.control,"value",o.target.value)}}})])])}),[],!1,null,"55aa6192",null).exports},select:{label:"Select Option",source:s},checkbox:{label:"Checkbox",source:n}},d=l({name:"ControlComponent",props:["control","labelPosition"],data:function(){return{controlInstance:null}},created:function(){u[this.control.type]?this.controlInstance=u[this.control.type].source:console.error("Control type ".concat(this.control.type," doesn't exist to render."))}},(function(){var t=this.$createElement,o=this._self._c||t;return o("div",{staticClass:"controlItem form-group",class:this.control.className},[o(this.controlInstance,{tag:"component",attrs:{propControl:this.control,"label-position":this.labelPosition}})],1)}),[],!1,null,"051eef00",null),m=l({name:"RowComponent",components:{ControlComponent:d.exports},props:["propSection"],data:function(){return{dynamicTemplate:null,section:{type:Object}}},methods:{addDynamicObj:function(){this.section.maxInstance>0&&this.section.instances.length===this.section.maxInstance?SethPhatToaster.error("Maximum instances reached, can't create more."):this.section.instances.push(_.cloneDeep(this.dynamicTemplate))},removeDynamicObj:function(t){this.section.minInstance!==this.section.instances.length?this.section.instances.splice(t,1):SethPhatToaster.error("Minimum instances reached, can't remove more.")},generateDynamic:function(){if(this.section.isDynamic&&(this.section.instances=[],this.dynamicTemplate=_.cloneDeep(this.section.rows),this.section.minInstance>0))for(var t=0;t<this.section.minInstance;t++)this.addDynamicObj()}},mounted:function(){this.section=this.propSection,this.generateDynamic()}},(function(){var t=this,o=t.$createElement,e=t._self._c||o;return e("div",{staticClass:"mt-2"},[t.section.isDynamic?e("div",{staticClass:"col-md-12 rowItem"},[e("div",{staticClass:"float-right"},[e("span",{staticClass:"add text-success",on:{click:t.addDynamicObj}},[e("i",{staticClass:"fa fa-plus-circle"})])]),t._v(" "),t._l(t.section.instances,(function(o,l){return e("div",{key:l,staticClass:"rowDynamicItem",class:"rowDynamic_"+l},[e("div",{staticClass:"float-right"},[e("span",{staticClass:"remove text-danger",on:{click:function(o){return t.removeDynamicObj(l)}}},[e("i",{staticClass:"fa fa-times-circle"})])]),t._v(" "),t._l(o,(function(o){return e("div",{staticClass:"row"},t._l(o.controls,(function(o){return e("control-component",{key:o.name+l,attrs:{control:o,"label-position":t.section.labelPosition}})})),1)}))],2)}))],2):t._e(),t._v(" "),t._l(t.section.rows,(function(o){return t.section.isDynamic?t._e():e("div",{staticClass:"row rowItem"},t._l(o.controls,(function(o){return e("control-component",{key:o.name,attrs:{control:o,"label-position":t.section.labelPosition}})})),1)}))],2)}),[],!1,null,"24501d0a",null).exports,p=l({props:{form:{type:Object}},components:{RowComponent:m}},(function(){var t=this,o=t.$createElement,e=t._self._c||o;return null!==t.form?e("div",["collapse"===t.form.layout?e("div",{staticClass:"accordion"},t._l(t.form.sections,(function(o,l){return e("div",{},[e("button",{staticClass:"btn btn-link w-100 text-left bg-light",attrs:{type:"button","data-toggle":"collapse","data-target":"#"+o.name+"_gui_body","aria-expanded":"true"}},[e("h2",{staticClass:"mb-0"},[t._v(t._s(o.label))])]),t._v(" "),e("div",{staticClass:"collapse show",attrs:{id:o.name+"_gui_body"}},[e("row-component",{key:o.name,attrs:{propSection:o}})],1)])})),0):t._e()]):t._e()}),[],!1,null,null,null);o.default=p.exports}}]);