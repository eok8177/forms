(window.webpackJsonp=window.webpackJsonp||[]).push([[2],{176:function(t,a,e){"use strict";e.r(a);var i=e(148),s=e.n(i);function n(t,a,e){return a in t?Object.defineProperty(t,a,{value:e,enumerable:!0,configurable:!0,writable:!0}):t[a]=e,t}var o={components:{SectionComponent:e(185).a},props:{form:{type:Object},formid:{type:Number},appid:{type:Number},userid:{type:Number}},data:function(){return{formdata:{type:Object},submitData:{},validForm:!0,validSection:!0,files:{},status:"draft",redirect_url:"/",appID:"",admin:!1,msg:"",errorMsg:"",disabledBtn:!1,redirect:!0,regEmail:/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/}},methods:{updateInstances:function(t,a){this.formdata.sections[t].instances=a},toggleSection:function(t){$("#"+this.formdata.sections[t].name+"_gui_body").hasClass("show")?this.parseForm(t):$("#"+this.formdata.sections[t].name+"_gui_body").collapse("toggle"),this.formdata.sections[t].valid&&$("#"+this.formdata.sections[t].name+"_gui_body").collapse("toggle"),t>0&&this.formdata.sections[t-1].valid&&$("#"+this.formdata.sections[t-1].name+"_gui_body").collapse("hide")},openSection:function(t){$("#"+this.form.sections[t].name+"_gui_body").collapse("show")},expandAllSections:function(){_.forEach(this.form.sections,(function(t,a){$("#"+t.name+"_gui_body").collapse("show")}))},collapseAllSections:function(){_.forEach(this.form.sections,(function(t,a){$("#"+t.name+"_gui_body").collapse("hide")}))},Submit:function(){this.parseForm(-1),this.validForm?(this.status="submitted",this.SaveApps()):this.errorMsg="Please address issues highlighted and try again"},parseForm:function(t){var a=this;a.validForm=!0,a.submitData={},_.forEach(this.formdata.sections,(function(e,i){if(a.validSection=!0,t>=0&&i>t)return!1;e.isDynamic?_.forEach(e.instances,(function(t){_.forEach(t,(function(t){a.fillSubmitData(t.controls,i)}))})):_.forEach(e.rows,(function(t){a.fillSubmitData(t.controls,i)})),e.invisible&&(a.validSection=!0),a.formdata.sections[i].valid=a.validSection,a.validSection||(a.validForm=!1)}))},fillSubmitData:function(t,a){var e=this,i=Object.keys(e.submitData).length;_.forEach(t,(function(t){var s=!0;if("file"!=t.type&&"html"!=t.type&&($('body [name="'+t.name+'"]').removeClass("is-invalid"),$("body .error-msg."+t.name).hide(),t.required)){if("address"==t.type||t.value||(s=!1,$('body [name="'+t.name+'"]').addClass("is-invalid")),"address"==t.type)for(var o=1;o<=5;o++)$('body [name="'+t.name+o+'"]').removeClass("is-invalid"),t["show"+o]&&!t["value"+o]&&2!=o&&(s=!1,$('body [name="'+t.name+o+'"]').addClass("is-invalid"));t.isEmail&&(e.regEmail.test(t.value)||(s=!1,$('body [name="'+t.name+'"]').addClass("is-invalid"))),t.invisible&&(s=!0)}if("file"==t.type&&($('body [name="'+t.name+'"]').removeClass("is-invalid"),$("body .error-msg."+t.name).hide(),t.required&&(t.value?t.value instanceof File||0==t.value.length&&(s=!1,$('body [name="'+t.name+'"]').addClass("is-invalid")):(s=!1,$('body [name="'+t.name+'"]').addClass("is-invalid"),t.invisible&&(s=!0)))),"file"==t.type&&t.value instanceof File&&(e.files[t.name]={name:t.label,data:t.value,fieldId:t.fieldName}),s||(e.validSection=!1,$("body .error-msg."+t.name).show()),"address"==t.type)for(o=1;o<=5;o++)t["show"+o]&&t["value"+o]&&(e.submitData=Object.assign(e.submitData,n({},i,{label:t["label"+o],value:t["value"+o],valid:s,field_id:t["label"+o]})),i++);else"file"!=t.type&&"html"!=t.type&&t.value&&(e.submitData=Object.assign(e.submitData,n({},i,{label:t.label,value:t.value,valid:s,field_id:t.fieldName})),i++);s||(console.log("not valid: "+t.label),$("#"+e.form.sections[a].name+"_gui_body").collapse("show"))}))},uploadFiles:function(){var t=this,a=Object.keys(t.files).length;_.forEach(t.files,(function(e,i){if("string"==typeof e.data||!(e.data instanceof File))return a-=1,!0;var n=e.data.name.replace(/[/\?%*:|"<>#]/g,"-"),o=new FormData;o.append("appid",t.appID),o.append("userid",t.userid),o.append("formId",t.formid),o.append("fieldName",e.name),o.append("fieldId",e.fieldId),o.append("file",e.data,n),s.a.post("/api/upload-file",o,{headers:{"Content-Type":"multipart/form-data"}}).then((function(e){0==(a-=1)&&"submitted"===t.status&&t.postForm()})).catch((function(t){return console.log(t)}))})),0==a&&"submitted"===t.status?t.postForm():"submitted"!=t.status&&(t.redirect?window.location.href="/user/draft-saved/"+t.formid:t.msg="You draft is updated."),this.disabledBtn=!1},SaveApps:function(t){var a=this;this.redirect=!t,this.parseForm(-1),this.disabledBtn=!0;var e=this;s.a.post("/api/save-apps",{userid:this.userid,formid:this.formid,appid:this.appID,status:this.status,data:this.form}).then((function(t){e.appID=t.data.appid,e.redirect_url=t.data.redirect_url,a.uploadFiles()})).catch((function(t){return console.log(t)}))},postForm:function(){var t=this;s.a.post("/api/post-form",{appid:this.appID}).then((function(a){window.location.href=t.redirect_url})).catch((function(t){return console.log(t)}))}},created:function(){this.formdata=this.form,this.appID=this.appid},mounted:function(){$("#"+this.form.sections[0].name+"_gui_body").collapse("show")}},l=e(189),d=e(178);var r=Object(d.a)(o,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return null!==t.form?e("div",[e("div",{staticClass:"d-flex justify-content-end mb-2"},[e("a",{staticClass:"btn-expand",on:{click:function(a){return t.expandAllSections()}}},[t._v("expand all")]),t._v(" "),e("a",{staticClass:"btn-expand open",on:{click:function(a){return t.collapseAllSections()}}},[t._v("collapse all")])]),t._v(" "),"collapse"===t.form.layout?e("div",{staticClass:"accordion"},t._l(t.form.sections,(function(t,a){return e("section-component",{key:t.name,attrs:{index:a,section:t}})})),1):t._e(),t._v(" "),e("div",{staticClass:"d-flex justify-content-end mb-2 text-danger"},[t._v(t._s(t.errorMsg))]),t._v(" "),e("div",{staticClass:"d-flex justify-content-end mb-2 btns-right"},[t.userid>0?e("button",{staticClass:"save",attrs:{disabled:t.disabledBtn},on:{click:function(a){return t.SaveApps()}}},[t._v("Save")]):t._e(),t._v(" "),e("button",{staticClass:"submit",attrs:{disabled:t.disabledBtn},on:{click:function(a){return t.Submit()}}},[t._v("Submit")])]),t._v(" "),e("div",{staticClass:"d-flex justify-content-end mb-2"},[e("a",{staticClass:"btn-expand",on:{click:function(a){return t.expandAllSections()}}},[t._v("expand all")]),t._v(" "),e("a",{staticClass:"btn-expand open",on:{click:function(a){return t.collapseAllSections()}}},[t._v("collapse all")])]),t._v(" "),t.msg?e("div",[t._v(t._s(t.msg))]):t._e(),t._v(" "),e("div",{staticClass:"modal fade",attrs:{id:"dataModal",tabindex:"-1",role:"dialog","aria-labelledby":"dataModalLabel","aria-hidden":"true"}},[e("div",{staticClass:"modal-dialog",attrs:{role:"document"}},[e("div",{staticClass:"modal-content"},[t._m(0),t._v(" "),e("div",{staticClass:"modal-body"},[t._m(1),t._v(" "),t._l(t.submitData,(function(a){return e("div",{staticClass:"row"},[e("div",{staticClass:"col"},[t._v(t._s(a.label))]),t._v(" "),e("div",{staticClass:"col"},[t._v(t._s(a.value))])])}))],2),t._v(" "),t._m(2)])])])]):t._e()}),[function(){var t=this.$createElement,a=this._self._c||t;return a("div",{staticClass:"modal-header"},[a("h5",{staticClass:"modal-title",attrs:{id:"dataModalLabel"}},[this._v("My data")]),this._v(" "),a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[a("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])])])},function(){var t=this.$createElement,a=this._self._c||t;return a("div",{staticClass:"row border-bottom"},[a("div",{staticClass:"col"},[a("b",[this._v("Field Name")])]),this._v(" "),a("div",{staticClass:"col"},[a("b",[this._v("Value")])])])},function(){var t=this.$createElement,a=this._self._c||t;return a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-outline-secondary",attrs:{type:"button","data-dismiss":"modal"}},[this._v("Close")])])}],!1,(function(t){this.$style=l.default.locals||l.default}),null,null);a.default=r.exports},183:function(t,a,e){var i=e(190);"string"==typeof i&&(i=[[t.i,i,""]]);var s={hmr:!0,transform:void 0,insertInto:void 0};e(182)(i,s);i.locals&&(t.exports=i.locals)},189:function(t,a,e){"use strict";var i=e(183),s=e.n(i);a.default=s.a},190:function(t,a,e){(t.exports=e(181)(!1)).push([t.i,'\nlabel.required:after {\n    content: "*";\n    color: red;\n}\n',""])}}]);