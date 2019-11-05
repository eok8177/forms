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
                <row-component v-model="formdata.sections[index]" :key="section.name" :index="index"></row-component>
            </div>
          </div>

        </div>

        <button @click="Submit()" class="btn btn-outline-secondary">Submit</button>


    </div>
</template>

<script>
    import RowComponent from "./formGUI/RowComponent";

    export default {
        components: {RowComponent},
        props: {
            form: {type: Object},
        },
        data: () => ({
            formdata: {type: Object},
        }),
        methods: {
            updateInstances(index, instance) {
                this.formdata.sections[index].instances = instance;
            },
            Submit() {
                //TODO parse object & send to server
                console.log(this.formdata.sections);
            }
        },
        created() {
            this.formdata = this.form;
        }
    }
</script>
