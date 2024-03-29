<!--
/**
* Description:
* VueJS Address Component (frontend)
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*/
-->
<template>
    <div>
      <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label"></label>

      <div class="form-group" v-if="value.show1" :class="value.cssClass">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label1"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 ref="input1"
                 v-model="value.value1"
                 :readonly="value.readonly"
                 :name="value.fieldName + '1'"
                  @blur="showMap(1)"
                 >
          </div>
      </div>

      <div class="form-group" v-if="value.show2" :class="value.cssClass">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label2"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 ref="input2"
                 v-model="value.value2"
                 :readonly="value.readonly"
                 :name="value.fieldName + '2'"
                  @blur="showMap(2)"
                 >
          </div>
      </div>

      <div class="form-group" v-if="value.show3" :class="value.cssClass">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label3"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 ref="input3"
                 v-model="value.value3"
                 :readonly="value.readonly"
                 :name="value.fieldName + '3'"
                  @blur="showMap(3)"
                 >
          </div>
      </div>

      <div class="form-group" v-if="value.show4" :class="value.cssClass">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label4"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 ref="input4"
                 v-model="value.value4"
                 :readonly="value.readonly"
                 :name="value.fieldName + '4'"
                  @blur="showMap(4)"
                 >
          </div>
      </div>

      <div class="form-group" v-if="value.show5" :class="value.cssClass">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label5"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 ref="input5"
                 v-model="value.value5"
                 :readonly="value.readonly"
                 :name="value.fieldName + '5'"
                  @blur="showMap(5)"
                 >
          </div>
      </div>

      <div v-if="showmap" class="map-it d-flex">
        <a :href="'https://www.google.com/maps/place/'+value.address" target="_blank">View on Map</a>


        <!-- <img style="max-width: 100%;" :src="'https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=640x300&maptype=roadmap&key='+key+'&format=jpg&visual_refresh=true&markers=size:small%7Ccolor:0xff0000%7Clabel:1%7C'+address" :alt="'Google Map of '+address">
          -->

        <div class="form-group ml-3 w-100" v-if="admin">
          <label>Lat/Lng</label>
          <input type="text" class="form-control mb-2" readonly="readonly" :value="value.lat">
          <input type="text" class="form-control mb-2" readonly="readonly" :value="value.lng">
          <input type="text" class="form-control mb-2" readonly="readonly" :value="value.address">
        </div>
      </div>

    </div>
</template>

<script>
    import Inputmask from "inputmask";
    import axios from 'axios';
    export default {
        name: "AddressControl",
        props: ['value', 'labelPosition'],
        data: () => ({
            key: '',
            address: '',
            showmap: false,
            admin: false
        }),
        mounted() {
          // TODO move key outside
          this.key = KEY_MAP;
          this.showMap();
          this.admin = this.$parent.$parent.$parent.$parent.admin;
          this.value.readonly = this.admin || this.value.readonly;

          if (this.value.show1 && this.value.mask1) {
            let im1 = new Inputmask(this.value.mask1);
            im1.mask(this.$refs.input1);
          }
          if (this.value.show2 && this.value.mask2) {
            let im2 = new Inputmask(this.value.mask2);
            im2.mask(this.$refs.input2);
          }
          if (this.value.show3 && this.value.mask3) {
            let im3 = new Inputmask(this.value.mask3);
            im3.mask(this.$refs.input3);
          }
          if (this.value.show4 && this.value.mask4) {
            let im4 = new Inputmask(this.value.mask4);
            im4.mask(this.$refs.input4);
          }
          if (this.value.show5 && this.value.mask5) {
            let im5 = new Inputmask(this.value.mask5);
            im5.mask(this.$refs.input5);
          }
        },
        methods: {
          showMap() {
            let addr = [];
            let show = false;
            if (this.value.mapIt) {
              show = true;
              for (let i = 1; i <= 5; i++) {
                let cond = this.value['show'+i];
                let item = this.value['value'+i];
                if (cond && item ) addr.push(item);
                if (cond && !item) show = false;
              }
              this.address = addr.join();
            }
            if (show) this.getLatLng();
            this.showmap = show;
          },
          getLatLng() {
            let self = this;
            axios.post('/api/get-coords', {
                key:  this.key,
                address:  this.address,
              })
              .then(
                (res) => {
                  if (res.status == 200) {
                    self.value.lat = res.data.lat;
                    self.value.lng = res.data.lng;
                    self.value.address = res.data.address;
                  }
                }
              )
              .catch(error => console.log(error));
          }
        }
    }
</script>

<style scoped>

</style>
