(window.webpackJsonp=window.webpackJsonp||[]).push([[1],{40:function(e,a,l){"use strict";l.r(a);var t=l(13),n=l.n(t);function o(e,a,l,t,n,o,i,s){var u,r="function"==typeof e?e.options:e;if(a&&(r.render=a,r.staticRenderFns=l,r._compiled=!0),t&&(r.functional=!0),o&&(r._scopeId="data-v-"+o),i?(u=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),n&&n.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(i)},r._ssrRegister=u):n&&(u=s?function(){n.call(this,this.$root.$options.shadowRoot)}:n),u)if(r.functional){r._injectStyles=u;var c=r.render;r.render=function(e,a){return u.call(a),c(e,a)}}else{var v=r.beforeCreate;r.beforeCreate=v?[].concat(v,u):[u]}return{exports:e,options:r}}var i=o({name:"CheckboxControl",props:["value","labelPosition"],mounted:function(){this.value.isChecked&&(this.value.value=!0)}},(function(){var e=this,a=e.$createElement,l=e._self._c||a;return l("div",["left"===e.labelPosition?l("div",{staticClass:"custom-control custom-switch"},[l("input",{directives:[{name:"model",rawName:"v-model",value:e.value.value,expression:"value.value"}],staticClass:"custom-control-input",attrs:{type:"checkbox",id:e.value.name+"_gui_control",readonly:e.value.readonly,name:e.value.fieldName},domProps:{checked:Array.isArray(e.value.value)?e._i(e.value.value,null)>-1:e.value.value},on:{change:function(a){var l=e.value.value,t=a.target,n=!!t.checked;if(Array.isArray(l)){var o=e._i(l,null);t.checked?o<0&&e.$set(e.value,"value",l.concat([null])):o>-1&&e.$set(e.value,"value",l.slice(0,o).concat(l.slice(o+1)))}else e.$set(e.value,"value",n)}}}),e._v(" "),l("label",{staticClass:"custom-control-label",class:{bold:e.value.labelBold,italic:e.value.labelItalic,underline:e.value.labelUnderline},attrs:{for:e.value.name+"_gui_control"}},[e._v("\n            "+e._s(e.value.label)+"\n        ")])]):l("div",{staticClass:"form-check"},[l("input",{directives:[{name:"model",rawName:"v-model",value:e.value.value,expression:"value.value"}],staticClass:"form-check-input",attrs:{type:"checkbox",id:e.value.name+"_gui_control",readonly:e.value.readonly,name:e.value.fieldName},domProps:{checked:Array.isArray(e.value.value)?e._i(e.value.value,null)>-1:e.value.value},on:{change:function(a){var l=e.value.value,t=a.target,n=!!t.checked;if(Array.isArray(l)){var o=e._i(l,null);t.checked?o<0&&e.$set(e.value,"value",l.concat([null])):o>-1&&e.$set(e.value,"value",l.slice(0,o).concat(l.slice(o+1)))}else e.$set(e.value,"value",n)}}}),e._v(" "),l("label",{staticClass:"custom-control-label",class:{bold:e.value.labelBold,italic:e.value.labelItalic,underline:e.value.labelUnderline},attrs:{for:e.value.name+"_gui_control"}},[e._v("\n            "+e._s(e.value.label)+"\n        ")])])])}),[],!1,null,"94042da2",null).exports,s={},u={};s.SectionLayout={collapse:"Collapse",tab:"Tab"},s.Section={name:"",label:"",clientKey:"",order:0,rows:[],labelPosition:"left",isDynamic:!1,minInstance:1,maxInstance:0,instances:[]},s.Row={name:"",label:"",order:0,controls:[]},s.Control={type:"",name:"",fieldName:"",label:"",order:0,defaultValue:"",value:"",className:"col-md-4",readonly:!1,labelBold:!1,labelItalic:!1,labelUnderline:!1,required:!1,isMultiLine:!1,isInteger:!1,decimalPlace:0,isTodayValue:!1,dateFormat:"dd/mm/yy",isNowTimeValue:!1,timeFormat:"HH:mm",isMultiple:!1,isAjax:!1,dataOptions:[],ajaxDataUrl:"",isChecked:!1},s.Type={text:{label:"Text Input",icon:"faEdit"},number:{label:"Number Input",icon:"faCalculator"},datepicker:{label:"Date Picker",icon:"faCalendarAlt"},timepicker:{label:"Time Picker",icon:"faClock"},select:{label:"Select Option",icon:"faDatabase"},checkbox:{label:"Checkbox",icon:"faCheck"}},s.WidthOptions={"col-md-1":"Width 1 parts","col-md-2":"Width 2 parts","col-md-3":"Width 3 parts","col-md-4":"Width 4 parts","col-md-5":"Width 5 parts","col-md-6":"Width 6 parts","col-md-7":"Width 7 parts","col-md-8":"Width 8 parts","col-md-9":"Width 9 parts","col-md-10":"Width 10 parts","col-md-11":"Width 11 parts","col-md-12":"Width 12 parts"},s.OptionDefault={id:"",text:""},u.DateFormat={"dd/mm/yy":"D/M/YYYY","dd-mm-yy":"D-M-YYYY","mm/dd/yy":"M/D/YYYY","mm-dd-yy":"M/D/YYYY","yy/mm/dd":"YYYY/M/D","yy-mm-dd":"YYYY-M-D"},u.TimeFormat={"H:m":"H:m","HH:mm":"HH:mm","h:m p":"h:m A","hh:mm p":"hh:mm A"};var r=o({name:"DatePickerControl",props:["value","labelPosition"],data:function(){return{options:{}}},created:function(){this.options.dateFormat=this.value.dateFormat,_.isEmpty(this.value.value)&&(_.isEmpty(this.value.defaultValue)?this.value.isTodayValue&&(this.value.value=moment().format(u.DateFormat[this.value.dateFormat])):this.value.value=this.value.defaultValue)}},(function(){var e=this,a=e.$createElement,l=e._self._c||a;return l("div",["left"===e.labelPosition?l("div",{staticClass:"form-group row datePickerControl"},[l("label",{class:{bold:e.value.labelBold,italic:e.value.labelItalic,underline:e.value.labelUnderline}+" col-sm-4 col-form-label"},[e._v("\n            "+e._s(e.value.label)+"\n        ")]),e._v(" "),l("div",{staticClass:"col-sm-8"},[l("input",{directives:[{name:"model",rawName:"v-model",value:e.value.value,expression:"value.value"}],staticClass:"form-control",attrs:{type:"date",readonly:e.value.readonly,name:e.value.fieldName},domProps:{value:e.value.value},on:{input:function(a){a.target.composing||e.$set(e.value,"value",a.target.value)}}})])]):l("div",{staticClass:"form-group"},[l("label",{class:{bold:e.value.labelBold,italic:e.value.labelItalic,underline:e.value.labelUnderline}},[e._v("\n            "+e._s(e.value.label)+"\n        ")]),e._v(" "),l("input",{directives:[{name:"model",rawName:"v-model",value:e.value.value,expression:"value.value"}],staticClass:"form-control",attrs:{type:"date",readonly:e.value.readonly,name:e.value.fieldName},domProps:{value:e.value.value},on:{input:function(a){a.target.composing||e.$set(e.value,"value",a.target.value)}}})])])}),[],!1,null,"49b77393",null).exports,c=o({name:"NumberControl",props:["value","labelPosition"],created:function(){this.value.value=0},mounted:function(){_.isEmpty(this.value.defaultValue)||(this.value.value=this.value.defaultValue)},methods:{numberChange:function(e){var a=e.target.value;!1===this.value.isInteger?this.value.value=parseFloat(a).toFixed(this.value.decimalPlace):this.value.value=parseInt(a)}},computed:{controlStep:function(){return 1}}},(function(){var e=this,a=e.$createElement,l=e._self._c||a;return l("div",["left"===e.labelPosition?l("div",{staticClass:"row"},[l("div",{staticClass:"col-md-4"},[l("label",{class:{bold:e.value.labelBold,italic:e.value.labelItalic,underline:e.value.labelUnderline}},[e._v(e._s(e.value.label))])]),e._v(" "),l("div",{staticClass:"col-md-8"},[l("div",{staticClass:"input-group"},[l("input",{directives:[{name:"model",rawName:"v-model",value:e.value.value,expression:"value.value"}],staticClass:"form-control",attrs:{type:"number",readonly:e.value.readonly,name:e.value.fieldName,step:e.controlStep},domProps:{value:e.value.value},on:{change:e.numberChange,input:function(a){a.target.composing||e.$set(e.value,"value",a.target.value)}}})])])]):l("div",{staticClass:"form-group"},[l("label",{class:{bold:e.value.labelBold,italic:e.value.labelItalic,underline:e.value.labelUnderline}},[e._v("\n            "+e._s(e.value.label)+"\n        ")]),e._v(" "),l("div",{staticClass:"input-group"},[l("input",{directives:[{name:"model",rawName:"v-model",value:e.value.value,expression:"value.value"}],staticClass:"form-control",attrs:{type:"number",readonly:e.value.readonly,name:e.value.fieldName,step:e.controlStep},domProps:{value:e.value.value},on:{change:e.numberChange,input:function(a){a.target.composing||e.$set(e.value,"value",a.target.value)}}})])])])}),[],!1,null,"6051ec49",null).exports,v=o({name:"SelectControl",props:["value","labelPosition"],data:function(){return{dataSource:[]}},created:function(){var e=this;if(this.value.isAjax){var a=this;$.getJSON(this.value.ajaxDataUrl).done((function(l){_.isArray(l)?a.dataSource=l:(SethPhatToaster.error("Control data error: ".concat(e.value.label,".")),console.error("Data for select control of ".concat(e.value.label," is wrong format!")))})).fail((function(a){SethPhatToaster.error("Failed to load data for control: ".concat(e.value.label,".")),console.error("Request for Select Data Source Failed: ",a)}))}else this.dataSource=this.value.dataOptions},mounted:function(){_.isEmpty(this.value.defaultValue)||(this.value.isMultiple?this.value.value=[this.value.defaultValue]:this.value.value=this.value.defaultValue)}},(function(){var e=this,a=e.$createElement,l=e._self._c||a;return l("div",["left"===e.labelPosition?l("div",{staticClass:"row"},[l("div",{staticClass:"col-md-4"},[l("label",{class:{bold:e.value.labelBold,italic:e.value.labelItalic,underline:e.value.labelUnderline}},[e._v("\n                "+e._s(e.value.label)+"\n            ")])]),e._v(" "),l("div",{staticClass:"col-md-8"},[l("select",{directives:[{name:"model",rawName:"v-model",value:e.value.value,expression:"value.value"}],staticClass:"form-control",attrs:{multiple:e.value.isMultiple,disabled:e.value.readonly},on:{change:function(a){var l=Array.prototype.filter.call(a.target.options,(function(e){return e.selected})).map((function(e){return"_value"in e?e._value:e.value}));e.$set(e.value,"value",a.target.multiple?l:l[0])}}},e._l(e.dataSource,(function(a){return l("option",{domProps:{value:a.id}},[e._v(e._s(a.text))])})),0)])]):l("div",{staticClass:"form-group"},[l("label",{class:{bold:e.value.labelBold,italic:e.value.labelItalic,underline:e.value.labelUnderline}},[e._v("\n            "+e._s(e.value.label)+"\n        ")]),e._v(" "),l("select",{directives:[{name:"model",rawName:"v-model",value:e.value.value,expression:"value.value"}],staticClass:"form-control",attrs:{multiple:e.value.isMultiple,disabled:e.value.readonly},on:{change:function(a){var l=Array.prototype.filter.call(a.target.options,(function(e){return e.selected})).map((function(e){return"_value"in e?e._value:e.value}));e.$set(e.value,"value",a.target.multiple?l:l[0])}}},e._l(e.dataSource,(function(a){return l("option",{domProps:{value:a.id}},[e._v(e._s(a.text))])})),0)])])}),[],!1,null,"0cb21568",null).exports,d={text:{label:"Text Input",source:o({name:"TextControl",props:["value","labelPosition"],mounted:function(){_.isEmpty(this.value.defaultValue)||(this.value.value=this.value.defaultValue)}},(function(){var e=this,a=e.$createElement,l=e._self._c||a;return l("div",["left"===e.labelPosition?l("div",{staticClass:"row"},[l("div",{staticClass:"col-md-4"},[l("label",{class:{bold:e.value.labelBold,italic:e.value.labelItalic,underline:e.value.labelUnderline}},[e._v("\n                "+e._s(e.value.label)+"\n            ")])]),e._v(" "),l("div",{staticClass:"col-md-8"},[e.value.isMultiLine?l("textarea",{directives:[{name:"model",rawName:"v-model",value:e.value.value,expression:"value.value"}],staticClass:"form-control",attrs:{readonly:e.value.readonly,name:e.value.fieldName},domProps:{value:e.value.value},on:{input:function(a){a.target.composing||e.$set(e.value,"value",a.target.value)}}}):l("input",{directives:[{name:"model",rawName:"v-model",value:e.value.value,expression:"value.value"}],staticClass:"form-control",attrs:{type:"text",readonly:e.value.readonly,name:e.value.fieldName},domProps:{value:e.value.value},on:{input:function(a){a.target.composing||e.$set(e.value,"value",a.target.value)}}})])]):l("div",{staticClass:"form-group"},[l("label",{class:{bold:e.value.labelBold,italic:e.value.labelItalic,underline:e.value.labelUnderline}},[e._v("\n            "+e._s(e.value.label)+"\n        ")]),e._v(" "),e.value.isMultiLine?l("textarea",{directives:[{name:"model",rawName:"v-model",value:e.value.value,expression:"value.value"}],staticClass:"form-control",attrs:{readonly:e.value.readonly,name:e.value.fieldName},domProps:{value:e.value.value},on:{input:function(a){a.target.composing||e.$set(e.value,"value",a.target.value)}}}):l("input",{directives:[{name:"model",rawName:"v-model",value:e.value.value,expression:"value.value"}],staticClass:"form-control",attrs:{type:"text",readonly:e.value.readonly,name:e.value.fieldName},domProps:{value:e.value.value},on:{input:function(a){a.target.composing||e.$set(e.value,"value",a.target.value)}}})])])}),[],!1,null,"c52a7c22",null).exports},number:{label:"Number Input",source:c},datepicker:{label:"Date Picker",source:r},timepicker:{label:"Time Picker",source:o({name:"TimePickerControl",props:["value","labelPosition"],data:function(){return{options:{}}},created:function(){this.options.timeFormat=this.value.timeFormat,_.isEmpty(this.value.defaultValue)||(this.value.value=this.value.defaultValue),this.value.isNowTimeValue&&(this.value.value=moment().format(u.TimeFormat[this.value.timeFormat]))}},(function(){var e=this,a=e.$createElement,l=e._self._c||a;return l("div",["left"===e.labelPosition?l("div",{staticClass:"row"},[l("div",{staticClass:"col-md-4"},[l("label",{class:{bold:e.value.labelBold,italic:e.value.labelItalic,underline:e.value.labelUnderline}},[e._v("\n                "+e._s(e.value.label)+"\n            ")])]),e._v(" "),l("div",{staticClass:"col-md-8"},[l("input",{directives:[{name:"model",rawName:"v-model",value:e.value.value,expression:"value.value"}],staticClass:"form-control",attrs:{type:"time",readonly:e.value.readonly,name:e.value.fieldName},domProps:{value:e.value.value},on:{input:function(a){a.target.composing||e.$set(e.value,"value",a.target.value)}}})])]):l("div",{staticClass:"form-group"},[l("label",{class:{bold:e.value.labelBold,italic:e.value.labelItalic,underline:e.value.labelUnderline}},[e._v("\n            "+e._s(e.value.label)+"\n        ")]),e._v(" "),l("input",{directives:[{name:"model",rawName:"v-model",value:e.value.value,expression:"value.value"}],staticClass:"form-control",attrs:{type:"time",readonly:e.value.readonly,name:e.value.fieldName},domProps:{value:e.value.value},on:{input:function(a){a.target.composing||e.$set(e.value,"value",a.target.value)}}})])])}),[],!1,null,"1663a7b8",null).exports},select:{label:"Select Option",source:v},checkbox:{label:"Checkbox",source:i}},m=o({name:"ControlComponent",props:["control","labelPosition"],data:function(){return{controlInstance:null}},created:function(){d[this.control.type]?this.controlInstance=d[this.control.type].source:console.error("Control type ".concat(this.control.type," doesn't exist to render."))}},(function(){var e=this,a=e.$createElement,l=e._self._c||a;return l("div",{staticClass:"controlItem form-group",class:e.control.className},[l(e.controlInstance,{tag:"component",attrs:{"label-position":e.labelPosition},model:{value:e.control,callback:function(a){e.control=a},expression:"control"}})],1)}),[],!1,null,"0f1b4be6",null),p=o({name:"RowComponent",components:{ControlComponent:m.exports},props:["value","index"],data:function(){return{dynamicTemplate:null,instances:{type:Object}}},methods:{addDynamicObj:function(){this.value.maxInstance>0&&this.value.instances.length===this.value.maxInstance?SethPhatToaster.error("Maximum instances reached, can't create more."):(this.instances.push(_.cloneDeep(this.dynamicTemplate)),this.$parent.updateInstances(this.index,this.instances))},removeDynamicObj:function(e){this.value.minInstance!==this.value.instances.length?(this.instances.splice(e,1),this.$parent.updateInstances(this.index,this.instances)):SethPhatToaster.error("Minimum instances reached, can't remove more.")},generateDynamic:function(){if(this.value.isDynamic&&(this.instances=[],this.dynamicTemplate=_.cloneDeep(this.value.rows),this.value.minInstance>0))for(var e=0;e<this.value.minInstance;e++)this.addDynamicObj()}},mounted:function(){this.generateDynamic()}},(function(){var e=this,a=e.$createElement,l=e._self._c||a;return l("div",{staticClass:"mt-2"},[e.value.isDynamic?l("div",{staticClass:"col-md-12 rowItem"},[l("div",{staticClass:"float-right"},[l("span",{staticClass:"add text-success",on:{click:e.addDynamicObj}},[l("i",{staticClass:"fa fa-plus-circle"})])]),e._v(" "),e._l(e.value.instances,(function(a,t){return l("div",{key:t,staticClass:"rowDynamicItem",class:"rowDynamic_"+t},[l("div",{staticClass:"float-right"},[l("span",{staticClass:"remove text-danger",on:{click:function(a){return e.removeDynamicObj(t)}}},[l("i",{staticClass:"fa fa-times-circle"})])]),e._v(" "),e._l(a,(function(a){return l("div",{staticClass:"row"},e._l(a.controls,(function(a){return l("control-component",{key:a.name+t,attrs:{control:a,"label-position":e.value.labelPosition}})})),1)}))],2)}))],2):e._e(),e._v(" "),e._l(e.value.rows,(function(a){return e.value.isDynamic?e._e():l("div",{staticClass:"row rowItem"},e._l(a.controls,(function(a){return l("control-component",{key:a.name,attrs:{control:a,"label-position":e.value.labelPosition}})})),1)}))],2)}),[],!1,null,"c9c7a700",null),f=o({components:{RowComponent:p.exports},props:{form:{type:Object},formid:{type:Number}},data:function(){return{formdata:{type:Object}}},methods:{updateInstances:function(e,a){this.formdata.sections[e].instances=a},Submit:function(){var e={},a=0;_.forEach(this.formdata.sections,(function(l){l.isDynamic?_.forEach(l.instances,(function(l){_.forEach(l,(function(l){_.forEach(l.controls,(function(l){e[a]={label:l.label,value:l.value},a++}))}))})):_.forEach(l.rows,(function(l){_.forEach(l.controls,(function(l){e[a]={label:l.label,value:l.value},a++}))}))})),console.log(e),n.a.post("/api/post-form",{formid:this.formid,data:e}).then((function(e){console.log(e)})).catch((function(e){return console.log(e)}))}},created:function(){this.formdata=this.form}},(function(){var e=this,a=e.$createElement,l=e._self._c||a;return null!==e.form?l("div",["collapse"===e.form.layout?l("div",{staticClass:"accordion"},e._l(e.form.sections,(function(a,t){return l("div",{},[l("button",{staticClass:"btn btn-link w-100 text-left bg-light",attrs:{type:"button","data-toggle":"collapse","data-target":"#"+a.name+"_gui_body","aria-expanded":"true"}},[l("h2",{staticClass:"mb-0"},[e._v(e._s(a.label))])]),e._v(" "),l("div",{staticClass:"collapse show",attrs:{id:a.name+"_gui_body"}},[l("row-component",{key:a.name,attrs:{index:t},model:{value:e.formdata.sections[t],callback:function(a){e.$set(e.formdata.sections,t,a)},expression:"formdata.sections[index]"}})],1)])})),0):e._e(),e._v(" "),l("button",{staticClass:"btn btn-outline-secondary",on:{click:function(a){return e.Submit()}}},[e._v("Submit")])]):e._e()}),[],!1,null,null,null);a.default=f.exports}}]);