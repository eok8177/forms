(window.webpackJsonp=window.webpackJsonp||[]).push([[5],{282:function(t,e,a){"use strict";var i=a(69),n=a.n(i);e.default=n.a},283:function(t,e,a){(t.exports=a(47)(!1)).push([t.i,'\nlabel.required:after {\n    content: "*";\n    color: red;\n}\n',""])},43:function(t,e,a){"use strict";a.r(e);a(13);function i(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}var n={components:{SectionComponent:a(208).a},props:{form:{type:Object}},data:function(){return{formdata:{type:Object},submitData:{},validForm:!0,validSection:!0,files:{},entryid:"",status:"draft",redirect_url:"/"}},methods:{updateInstances:function(t,e){this.formdata.sections[t].instances=e},toggleSection:function(t){this.parseForm(t),$("#"+this.formdata.sections[t].name+"_gui_body").collapse("toggle")},parseForm:function(t){var e=this;e.validForm=!0,e.submitData={},_.forEach(this.formdata.sections,(function(a,i){if(e.validSection=!0,t>=0&&i>t)return!1;a.isDynamic?_.forEach(a.instances,(function(t){_.forEach(t,(function(t){e.fillSubmitData(t.controls,i)}))})):_.forEach(a.rows,(function(t){e.fillSubmitData(t.controls,i)})),e.formdata.sections[i].valid=e.validSection}))},fillSubmitData:function(t,e){var a=this,n=Object.keys(a.submitData).length;_.forEach(t,(function(t){var o=!0;if("file"!=t.type&&"html"!=t.type&&($('body [name="'+t.name+'"]').removeClass("is-invalid"),t.required&&("address"==t.type||t.value||(a.validForm=!1,a.validSection=!1,o=!1,$('body [name="'+t.name+'"]').addClass("is-invalid")),"address"==t.type)))for(var s=1;s<=5;s++)$('body [name="'+t.name+s+'"]').removeClass("is-invalid"),t["show"+s]&&!t["value"+s]&&2!=s&&(a.validForm=!1,a.validSection=!1,o=!1,$('body [name="'+t.name+s+'"]').addClass("is-invalid"));if("file"==t.type&&t.value&&(a.files[t.name]={name:t.label,data:t.value}),"address"==t.type)for(s=1;s<=5;s++)t["show"+s]&&t["value"+s]&&(a.submitData=Object.assign(a.submitData,i({},n,{label:t["label"+s],value:t["value"+s],valid:o,field_id:t["label"+s]})),n++);else"file"!=t.type&&"html"!=t.type&&t.value&&(a.submitData=Object.assign(a.submitData,i({},n,{label:t.label,value:t.value,valid:o,field_id:t.fieldName})),n++);o||$("#"+a.form.sections[e].name+"_gui_body").collapse("show")}))}},created:function(){this.formdata=this.form},mounted:function(){$("#"+this.form.sections[0].name+"_gui_body").collapse("show")}},o=a(282),s=a(50);var l=Object(s.a)(n,(function(){var t=this.$createElement,e=this._self._c||t;return null!==this.form?e("div",["collapse"===this.form.layout?e("div",{staticClass:"accordion"},this._l(this.form.sections,(function(t,a){return e("section-component",{key:t.name,attrs:{index:a,section:t}})})),1):this._e()]):this._e()}),[],!1,(function(t){this.$style=o.default.locals||o.default}),null,null);e.default=l.exports},69:function(t,e,a){var i=a(283);"string"==typeof i&&(i=[[t.i,i,""]]);var n={hmr:!0,transform:void 0,insertInto:void 0};a(48)(i,n);i.locals&&(t.exports=i.locals)}}]);