<template>
    <!-- Decimal places for number -->
    <div class="row mt-2">
        <div class="col-md-12">
            <label>
                <input type="checkbox" name="isInteger" v-model="control.isInteger"> Integer Only
            </label>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Decimal places</label>
                <input type="number" min="0" max="5" class="form-control decimalPlaces"
                       v-model="control.decimalPlace" :disabled="control.isInteger">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Min value</label>
                <input type="number" class="form-control decimalPlaces" v-model="control.minValue">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Max value</label>
                <input type="number" class="form-control decimalPlaces" v-model="control.maxValue">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NumberConfigComponent",
        props: {
            control: {
                type: Object
            },
        },
    }
</script>

<style scoped>

</style>
