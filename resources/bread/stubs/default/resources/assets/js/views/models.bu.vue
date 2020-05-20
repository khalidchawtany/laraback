<template>
    <div>
        <!-- <h1 class="subheading grey--text">bread_model_class</h1> -->
        <v-container fluid class="">
            <v-data-table
                :footer-props="{itemsPerPageOptions: [5, 10, 15, 20]}"
                :headers="headers"
                :items="allbread_model_classes"
                :options.sync="options"
                :server-items-length="totalbread_model_classes"
                :loading="loading"
                class="elevation-1"
                >
                <!-- @click:row="show($event)" -->
                <template v-slot:top>
                    <v-toolbar flat color="white">
                        <v-toolbar-title>bread_model_classes</v-toolbar-title>
                <v-divider class="mx-4" inset vertical ></v-divider>
                <div class="flex-grow-1"></div>
                <v-dialog v-model="dialog" max-width="800px">
                    <template v-slot:activator="{ on }">
                        <v-btn color="primary" dark class="mb-2" @click="showNewbread_model_class">New</v-btn>

                        <v-btn
                            :loading="loading"
                            :disabled="loading"
                            color="blue-grey"
                            class="mb-2 mr-2 white--text"
                            @click="fetchbread_model_classes()"
                            >
                            Reload
                            <v-icon right dark>cached</v-icon>
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ editedbread_model_classIndex === -1 ? 'New bread_model_class' : 'Edit bread_model_class' }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" sm="6" md="6">
                                        <v-text-field v-model="editedbread_model_class.name" label="Name"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="6">
                                        <v-select v-model="editedbread_model_class.status" :items="[ {value:1, text: 'Active'}, {value:0, text:'Inactive'}]" label="Status">
                                        </v-select>
                                    </v-col>
                                    <v-col cols="12" sm="12" md="12">
                                        <v-textarea v-model="editedbread_model_class.description" label="Description"/>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>

                        <v-card-actions>
                            <div class="flex-grow-1"></div>
                            <v-btn color="blue darken-1" text @click="closeDialog">Cancel</v-btn>
                            <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                    </v-toolbar>
                </template>
                <template v-slot:item.status="{ item }">
                    <v-chip :class="`bread_model_variable-status ${item.status ? 'active' : 'inactive'}`" dark>{{ item.status ? 'Active' : 'Inactive' }}</v-chip>
                </template>
                <template v-slot:item.action="{ item }">
                    <v-icon small class="mr-2" @click.stop="showEditbread_model_class(item)" >
                        edit
                    </v-icon>
                    <v-icon small @click.stop="deletebread_model_class(item)" >
                        delete
                    </v-icon>
                </template>
                <template v-slot:no-data>
                </template>
            </v-data-table>

        </v-container>

    </div>
</template>

<script>
import router from '@/router'
import { EventBus } from '@/eventbus'
import { getErrMessage } from '@/util'
import DatePicker from '@/components/DatePicker';
import bread_model_class from '@/models/bread_model_class';

export default {
    name: 'bread_model_classes',
    components: { DatePicker },
    data () {
        return {
            //allbread_model_classes: [],
            loading: false,
            options: {page: 1, itemsPerPage: 5},
            totalbread_model_classes: 0,
            dialog: false,
            editedbread_model_classIndex: -1,
            editedbread_model_class: {
                name: "",
                status: "",
                description: "",
            },
            defaultItem: {
                name: "",
                status: "",
                description: "",
            },
            headers: [
                { text: 'Name', align: 'left', sortable: true, value: 'name', },
                { text: 'Status', value: 'status', },
                { text: 'Description', value: 'description', },
                { text: 'Actions', value: 'action', sortable: false },
            ],


        }
    },
    watch: {
        options: {
            handler (e) {
                this.fetchbread_model_classes(e)
            },
            deep: true,
        },
        dialog (val) {
            val || this.closeDialog()
        },
    },
    //mounted () {
    //    this.fetchbread_model_classes();
    //},
    computed: {
        //Does not respect sort order sometimes
        allbread_model_classes(){
            //return bread_model_class.query().orderBy(sortBy, this.descending ? 'desc': 'asc').get();
            //This respects sorting
            return bread_model_class.query().orderBy(this.getSortParams(this.options.sortBy), this.getSortParams(this.options.sortDesc)? 'desc': 'asc').get();
            //return bread_model_class.all();
        },
    },
    methods: {

        closeDialog() {
            this.dialog =  false;
            this.editedbread_model_class = Object.assign({}, this.defaultItem);
            this.setEditIndex = -1;
        },

        async fetchbread_model_classes() {
            try {
                this.loading = true;

                const {page, itemsPerPage} = this.options;

                const response = await bread_model_class.$fetch({
                    query: {
                        page: page,
                        rows: itemsPerPage,
                        sort: this.getSortParams(this.options.sortBy),
                        order: this.getSortParams(this.options.sortDesc)? 'desc': 'asc'

                    }
                });

                bread_model_class.create({data: response.rows});

                //this ruins the sort
                //this.allbread_model_classes = bread_model_class.query().orderBy(this.sortBy, this.descending ? 'desc': 'asc').get();
                //this.allbread_model_classes = response.rows;

                this.totalbread_model_classes = response.total;
            } catch (err) {
                EventBus.$emit('snackbar', getErrMessage(err));
            }
            this.loading = false;
        },

        async deletebread_model_class(item) {

            if (! await this.$root.$confirm('Delete', 'Are you sure to delete this bread_model_variable?', { color: 'red' })) {
                return;
            }

            try {
                let res = await bread_model_class.$delete({
                    params: {
                        id: item.id
                    }
                });
                // this fixes an issue with the vuex-orm not accepting where for delete
                bread_model_class.delete(item.id);
                EventBus.$emit('snackbar', res.message);
            }
            catch (err) {
                EventBus.$emit('snackbar', getErrMessage(err));
            }
        },
        show(item){
            router.push(`/bread_model_variables/${item.id}`).catch(console.log);
        },
        showEditbread_model_class(item) {
            this.editedbread_model_classIndex = item.id;
            this.editedbread_model_class = Object.assign({}, item);
            this.dialog = true;
        },
        showNewbread_model_class() {
            this.editedbread_model_classIndex = -1;
            this.editedbread_model_class = Object.assign({}, this.defaultItem);
            this.dialog = true;
        },

        async save () {
            try {
                let response = null;
                // Update bread_model_variable
                if (this.editedbread_model_classIndex > -1) {
                    let editedbread_model_class = this.editedbread_model_class;
                    response = await bread_model_class.$update({
                        params: {
                            id: editedbread_model_class.id,
                        },
                        data: { ...editedbread_model_class }
                    })

                // add bread_model_variable
                } else {
                    let editedbread_model_class = this.editedbread_model_class;
                    response = await bread_model_class.$create({
                        data: { ...editedbread_model_class }
                    })
                }

                this.closeDialog();

                EventBus.$emit('snackbar', response.message);

            } catch(err) {
                EventBus.$emit('snackbar', getErrMessage(err), 'danger');
            }
        },

    },

}
</script>

<style>

.v-chip.bread_model_variable-status.active{
    background: green !important;
}
.v-chip.bread_model_variable-status.inactive{
    background: gray !important;
}
</style>
