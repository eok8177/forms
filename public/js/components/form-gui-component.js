(window.webpackJsonp=window.webpackJsonp||[]).push([[2],{159:function(t,a,i){(t.exports=i(157)(!1)).push([t.i,'\nlabel.required:after {\n    content: "*";\n    color: red;\n}\n',""])},161:function(t,a,i){"use strict";i.r(a);var e=i(3),s=i.n(e);function n(t,a,i){return a in t?Object.defineProperty(t,a,{value:i,enumerable:!0,configurable:!0,writable:!0}):t[a]=i,t}var o={components:{SectionComponent:i(8).a},props:{form:{type:Object},formid:{type:Number},appid:{type:Number},userid:{type:Number}},data:function(){return{formdata:{type:Object},submitData:{},validForm:!0,validSection:!0,files:{},entryid:"",status:"draft",redirect_url:"/",appID:"",admin:!1,msg:""}},methods:{updateInstances:function(t,a){this.formdata.sections[t].instances=a},toggleSection:function(t){this.parseForm(t),this.formdata.sections[t].valid&&$("#"+this.formdata.sections[t].name+"_gui_body").collapse("toggle"),t>0&&this.formdata.sections[t-1].valid&&$("#"+this.formdata.sections[t-1].name+"_gui_body").collapse("hide")},openSection:function(t){$("#"+this.form.sections[t].name+"_gui_body").collapse("show")},expandAllSections:function(){_.forEach(this.form.sections,(function(t,a){$("#"+t.name+"_gui_body").collapse("show")}))},collapseAllSections:function(){_.forEach(this.form.sections,(function(t,a){$("#"+t.name+"_gui_body").collapse("hide")}))},Submit:function(){this.parseForm(-1),this.validForm&&(this.status="submitted",this.SaveApps())},parseForm:function(t){var a=this;a.validForm=!0,a.submitData={},_.forEach(this.formdata.sections,(function(i,e){if(a.validSection=!0,t>=0&&e>t)return!1;i.isDynamic?_.forEach(i.instances,(function(t){_.forEach(t,(function(t){a.fillSubmitData(t.controls,e)}))})):_.forEach(i.rows,(function(t){a.fillSubmitData(t.controls,e)})),a.formdata.sections[e].valid=a.validSection}))},fillSubmitData:function(t,a){var i=this,e=Object.keys(i.submitData).length;_.forEach(t,(function(t){var s=!0;if("file"!=t.type&&"html"!=t.type&&($('body [name="'+t.name+'"]').removeClass("is-invalid"),t.required&&("address"==t.type||t.value||(i.validForm=!1,i.validSection=!1,s=!1,$('body [name="'+t.name+'"]').addClass("is-invalid")),"address"==t.type)))for(var o=1;o<=5;o++)$('body [name="'+t.name+o+'"]').removeClass("is-invalid"),t["show"+o]&&!t["value"+o]&&2!=o&&(i.validForm=!1,i.validSection=!1,s=!1,$('body [name="'+t.name+o+'"]').addClass("is-invalid"));if("file"==t.type&&t.value&&(i.files[t.name]={name:t.label,data:t.value,fieldId:t.fieldName}),"address"==t.type)for(o=1;o<=5;o++)t["show"+o]&&t["value"+o]&&(i.submitData=Object.assign(i.submitData,n({},e,{label:t["label"+o],value:t["value"+o],valid:s,field_id:t["label"+o]})),e++);else"file"!=t.type&&"html"!=t.type&&t.value&&(i.submitData=Object.assign(i.submitData,n({},e,{label:t.label,value:t.value,valid:s,field_id:t.fieldName})),e++);s||$("#"+i.form.sections[a].name+"_gui_body").collapse("show")}))},uploadFiles:function(){var t=this,a=Object.keys(t.files).length;_.forEach(t.files,(function(i,e){if("string"==typeof i.data||i.data instanceof String)return a-=1,!0;var n=new FormData;n.append("appid",t.appID),n.append("entryId",t.entryid),n.append("userid",t.userid),n.append("formId",t.formid),n.append("fieldName",i.name),n.append("fieldId",i.fieldId),n.append("file",i.data),s.a.post("/api/upload-file",n,{headers:{"Content-Type":"multipart/form-data"}}).then((function(i){0==(a-=1)&&"submitted"===t.status&&t.postForm()})).catch((function(t){return console.log(t)}))})),0==a&&"submitted"===t.status?t.postForm():(t.msg="You draft is updated.",window.location.href="/user/draft-saved/"+t.formid)},SaveApps:function(){var t=this;this.parseForm(-1);var a=this;s.a.post("/api/save-apps",{userid:this.userid,formid:this.formid,appid:this.appID,entryid:this.entryid,status:this.status,data:this.form}).then((function(i){a.appID=i.data.appid,a.redirect_url=i.data.redirect_url,t.uploadFiles()})).catch((function(t){return console.log(t)}))},postForm:function(){var t=this;s.a.post("/api/post-form",{appid:this.appID}).then((function(a){window.location.href=t.redirect_url})).catch((function(t){return console.log(t)}))}},created:function(){this.formdata=this.form,this.appID=this.appid},mounted:function(){$("#"+this.form.sections[0].name+"_gui_body").collapse("show")}},l=i(9),d=i(1);var r=Object(d.a)(o,(function(){var t=this,a=t.$createElement,i=t._self._c||a;return null!==t.form?i("div",[i("div",{staticClass:"d-flex justify-content-end mb-2"},[i("a",{staticClass:"btn-expand",on:{click:function(a){return t.expandAllSections()}}},[t._v("expand all")]),t._v(" "),i("a",{staticClass:"btn-expand open",on:{click:function(a){return t.collapseAllSections()}}},[t._v("collapse all")])]),t._v(" "),"collapse"===t.form.layout?i("div",{staticClass:"accordion"},t._l(t.form.sections,(function(t,a){return i("section-component",{key:t.name,attrs:{index:a,section:t}})})),1):t._e(),t._v(" "),i("div",{staticClass:"d-flex justify-content-end mb-2 btns-right"},[t.userid>0?i("button",{staticClass:"save",on:{click:function(a){return t.SaveApps()}}},[t._v("Save application")]):t._e(),t._v(" "),i("button",{staticClass:"submit",on:{click:function(a){return t.Submit()}}},[t._v("Submit application")])]),t._v(" "),i("div",{staticClass:"d-flex justify-content-end mb-2"},[i("a",{staticClass:"btn-expand",on:{click:function(a){return t.expandAllSections()}}},[t._v("expand all")]),t._v(" "),i("a",{staticClass:"btn-expand open",on:{click:function(a){return t.collapseAllSections()}}},[t._v("collapse all")])]),t._v(" "),t.msg?i("div",[t._v(t._s(t.msg))]):t._e(),t._v(" "),i("div",{staticClass:"modal fade",attrs:{id:"dataModal",tabindex:"-1",role:"dialog","aria-labelledby":"dataModalLabel","aria-hidden":"true"}},[i("div",{staticClass:"modal-dialog",attrs:{role:"document"}},[i("div",{staticClass:"modal-content"},[t._m(0),t._v(" "),i("div",{staticClass:"modal-body"},[t._m(1),t._v(" "),t._l(t.submitData,(function(a){return i("div",{staticClass:"row"},[i("div",{staticClass:"col"},[t._v(t._s(a.label))]),t._v(" "),i("div",{staticClass:"col"},[t._v(t._s(a.value))])])}))],2),t._v(" "),t._m(2)])])])]):t._e()}),[function(){var t=this.$createElement,a=this._self._c||t;return a("div",{staticClass:"modal-header"},[a("h5",{staticClass:"modal-title",attrs:{id:"dataModalLabel"}},[this._v("My data")]),this._v(" "),a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[a("span",{attrs:{"aria-hidden":"true"}},[this._v("×")])])])},function(){var t=this.$createElement,a=this._self._c||t;return a("div",{staticClass:"row border-bottom"},[a("div",{staticClass:"col"},[a("b",[this._v("Field Name")])]),this._v(" "),a("div",{staticClass:"col"},[a("b",[this._v("Value")])])])},function(){var t=this.$createElement,a=this._self._c||t;return a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-outline-secondary",attrs:{type:"button","data-dismiss":"modal"}},[this._v("Close")])])}],!1,(function(t){this.$style=l.default.locals||l.default}),null,null);a.default=r.exports},6:function(t,a,i){var e=i(159);"string"==typeof e&&(e=[[t.i,e,""]]);var s={hmr:!0,transform:void 0,insertInto:void 0};i(158)(e,s);e.locals&&(t.exports=e.locals)},9:function(t,a,i){"use strict";var e=i(6),s=i.n(e);a.default=s.a}}]);