<template>
    <div>

      <div class="form-group" v-if="value.show1" :class="value.cssClass">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label1"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 v-model="value.value1"
                 :readonly="value.readonly"
                 :name="value.fieldName + '1'"
                  @change="showMap()"
                 >
          </div>
      </div>

      <div class="form-group" v-if="value.show2" :class="value.cssClass">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label2"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 v-model="value.value2"
                 :readonly="value.readonly"
                 :name="value.fieldName + '2'"
                  @change="showMap()"
                 >
          </div>
      </div>

      <div class="form-group" v-if="value.show3" :class="value.cssClass">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label3"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 v-model="value.value3"
                 :readonly="value.readonly"
                 :name="value.fieldName + '3'"
                  @change="showMap()"
                 >
          </div>
      </div>

      <div class="form-group" v-if="value.show4" :class="value.cssClass">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label4"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 v-model="value.value4"
                 :readonly="value.readonly"
                 :name="value.fieldName + '4'"
                  @change="showMap()"
                 >
          </div>
      </div>

      <div class="form-group" v-if="value.show5" :class="value.cssClass">
          <label :class="{'bold': value.labelBold, 'italic': value.labelItalic, 'underline': value.labelUnderline}" v-html="value.label5"></label>
          <div class="input-group">
              <input type="text" class="form-control"
                 v-model="value.value5"
                 :readonly="value.readonly"
                 :name="value.fieldName + '5'"
                  @change="showMap()"
                 >
          </div>
      </div>

      <div v-if="showMap()" class="map-it">
        <img style="max-width: 100%;" :src="'https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=640x300&maptype=roadmap&key='+key+'&format=jpg&visual_refresh=true&markers=size:small%7Ccolor:0xff0000%7Clabel:1%7C'+address" :alt="'Google Map of '+address">
      </div>

    </div>
</template>

<script>
    export default {
        name: "AddressControl",
        props: ['value', 'labelPosition'],
        data: () => ({
            key: '',
            address: '',
        }),
        mounted() {
          this.key = 'AIzaSyDnxGiPdH3lTiOVu98kJxvn3h8Oezlw3w4';
          this.showMap();
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
            }
            this.address = addr.join();
            return show;
          }
        }
    }
</script>

<style scoped>

</style>
