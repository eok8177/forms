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

        <div class="d-flex justify-content-between mt-2">
            <label style="white-space: nowrap;">Mask&nbsp;<span type="button" class="btn btn-sm btn-outline-info" data-container="body" data-html="true" data-toggle="popover" data-placement="bottom" title="Example masks" data-content="date: '99/99/9999' <br> time: '99:99:99' <br> phones: '(99) 9999-9999' <br> mixed: 'AAA 999-AAA' <br> more by url: https://github.com/robinherbots/inputmask">?</span>
            </label> &nbsp;
            <input type="text" name="mask" v-model="control.mask" class="form-control">
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
        },
        mounted() {
            $('[data-toggle="popover"]').popover();
        }
    }
</script>

<style scoped>

</style>
