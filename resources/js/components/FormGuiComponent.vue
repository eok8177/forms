<template>
    <div v-if="form !== null">

        <!-- collapse layout -->
        <div class="accordion" v-if="form.layout === 'collapse'">

          <div class="" v-for="(section, index) in form.sections">

            <button class="btn btn-link w-100 text-left bg-light"
                type="button"
                data-toggle="collapse"
                :data-target="'#'+section.name + '_gui_body'"
                aria-expanded="true" >
              <h2 class="mb-0">{{section.label}}</h2>
            </button>

            <div :id="section.name + '_gui_body'" class="collapse show">
                <row-component :propSection="section" :key="section.name"></row-component>
            </div>
          </div>

        </div>


    </div>
</template>

<script>
    import RowComponent from "./formGUI/RowComponent";

    export default {
        props: {
            form: {type: Object},
        },
        components: {RowComponent}
    }
</script>
