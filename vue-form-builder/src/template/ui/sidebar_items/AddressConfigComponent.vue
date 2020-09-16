<template>
    <div>

        <!-- <div class="d-flex justify-content-between">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" :id="control.name + '_map'" v-model="control.showMap">
              <label class="custom-control-label" :for="control.name + '_map'">{{control.labelMap}}</label>
            </div>
            <input type="text" class="form-control form-control-sm" v-model="control.labelMap">
        </div> -->

        <div class="d-flex justify-content-between">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" :id="control.name + '_1'" v-model="control.show1">
              <label class="custom-control-label" :for="control.name + '_1'">{{control.label1}}</label>
            </div>
            <input type="text" class="form-control form-control-sm" v-model="control.label1">
        </div>

        <div class="d-flex justify-content-between">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" :id="control.name + '_2'" v-model="control.show2">
              <label class="custom-control-label" :for="control.name + '_2'">{{control.label2}}</label>
            </div>
            <input type="text" class="form-control form-control-sm" v-model="control.label2">
        </div>

        <div class="d-flex justify-content-between">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" :id="control.name + '_3'" v-model="control.show3">
              <label class="custom-control-label" :for="control.name + '_3'">{{control.label3}}</label>
            </div>
            <input type="text" class="form-control form-control-sm" v-model="control.label3">
        </div>

        <div class="d-flex justify-content-between">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" :id="control.name + '_4'" v-model="control.show4">
              <label class="custom-control-label" :for="control.name + '_4'">{{control.label4}}</label>
            </div>
            <input type="text" class="form-control form-control-sm" v-model="control.label4">
        </div>

        <div class="d-flex justify-content-between">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" :id="control.name + '_5'" v-model="control.show5">
              <label class="custom-control-label" :for="control.name + '_5'">{{control.label5}}</label>
            </div>
            <input type="text" class="form-control form-control-sm" v-model="control.label5">
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <label>
                    <input type="checkbox" name="mapIt" v-model="control.mapIt"> Map it
                </label>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "AddressConfigComponent",
        props: {
            control: {
                type: Object
            },
        },
    }
</script>

<style scoped>
    .custom-switch {
        max-width: 150px;
        width: 100%;
    }
</style>
