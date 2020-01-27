try {
  window.Popper = require('popper.js').default;
  window.$ = window.jQuery = require('jquery');

  require('bootstrap');
} catch (e) {}

// ---------- Methods ---------- //
$(function () {

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  //Delete record
  $('.delete').on('click', function (e) {
    if (!confirm('Are you sure you want to delete?')) return false;
  e.preventDefault();
    $.post({
      type: 'DELETE',  // destroy Method
      url: $(this).attr("href")
    }).done(function (data) {
      console.log(data);
      location.reload(true);
    });
  });

  //Change status of record
  $('.status').on('click', function (e) {
    e.preventDefault();
    var item = $(this);
    $.post({
      type: 'PUT',
      url: $(this).attr('href'),
        // data: {},
        dataType: 'json'
      }).done(function (data) {
        if (data.status == 1) {
          item.removeClass('fa-times-circle').addClass('fa-check-circle');
        } else {
          item.removeClass('fa-check-circle').addClass('fa-times-circle');
        }
        if (item.hasClass('reload')) location.reload(true);
      });
  });

  //Send Email method
  $('.sendemail').on('click', function (e) {
    e.preventDefault();
    var item = $(this);
    item.removeClass('fa-envelope-o').addClass('fa-paper-plane-o').prop('disabled', true);
    $.post({
      type: 'PUT',
      url: $(this).attr('href'),
        dataType: 'json'
      }).done(function (data) {
          // item.removeClass('fa-paper-plane-o').addClass('fa-envelope-o');
      });
  });

  // CK Editor
  var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token='+ $('meta[name="csrf-token"]').attr('content'),
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='+ $('meta[name="csrf-token"]').attr('content')
  };
  $('.editor').ckeditor(options);

  //laravel file manager
  $('.lfm').filemanager('image');

  $('.lfm').on('click', function(){
    var $container = $(this).closest('.image-lfm');
    $container.find('.delete-image').removeClass('d-none');
  });
  //Delete uploaded image in form
  $('.delete-image').on('click', function(){
    var $container = $(this).closest('.image-lfm');
    $container.find('.image-input').val(null);
    $container.find('.image-src').attr('src', '');
    $(this).removeClass('d-none');
    $(this).addClass('d-none');
  });

});
/*----- VueJS -----*/
window.Vue = require('vue');

Vue.component(
    'form-builder-component', 
    () => import(
        /* webpackChunkName: "form-builder-component" */
        './components/FormBuilderComponent.vue'
    )
);

const app = new Vue({
    el: '#app',
});
