<template>
    <div>
        <label>
            <input type="checkbox" name="isMultiLine" v-model="control.isMultiLine"> Multi-line?
        </label>
        <label>
            <input type="checkbox" name="isEmail" v-model="control.isEmail"> Email?
        </label>
        <div>
            <label>Pre Filled</label>
            <select class="form-control" v-model="control.pre_filled">
                <option value="false" selected>&lt;empty&gt;</option>
                <option value="first_name">First Name</option>
                <option value="last_name">Last Name</option>
                <option value="email">Email</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TextConfigComponent",
        props: {
            control: {
                type: Object
            },
        }
    }
</script>

<style scoped>

</style>
