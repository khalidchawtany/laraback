<template>
    <div>
        <!-- <h1 class="subheading grey--text">bread_model_class</h1> -->
        <v-container fluid class="">
            <v-data-table
                :footer-props="{itemsPerPageOptions: [5, 10, 15, 20]}"
                :headers="headers"
                :items="bread_model_classes"
                :options.sync="options"
                :server-items-length="bread_model_classesCount"
                :loading="loading"
                @click:row="showbread_model_class($event)"
                class="elevation-1"
                >
                <!-- @click:row="show($event)" -->
                <template v-slot:top>
                        <v-row>
                            <v-col cols="12" sm="12" md="12">
                                <v-toolbar flat color="white">

                                    <v-toolbar-title>bread_model_classes</v-toolbar-title>
                                    <v-divider class="mx-4" inset vertical ></v-divider>


                                    <div class="flex-grow-1">
                                    </div>

																		<!-- Show body dialog -->
                                    <v-dialog v-model="showbread_model_classDialog" max-width="800px">
                                        <v-card>
                                            <v-card-title>
																								<span class="subtitle-1">
																										{{ selectedbread_model_class.title }}
																								</span>
																								<v-divider class="mx-4" inset vertical ></v-divider>
																								<div class="body-2">
																								{{ selectedbread_model_class.date | moment('Do MMM YYYY') }}
																								</div>
																								<div class="flex-grow-1"></div>

																								<div class="body-2">
																								@{{ selectedbread_model_class.employee_name}}
																								</div>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-container>
																										<v-banner>

                                                    <v-row>
                                                        <v-col cols="12" sm="12" md="12">
																														<div v-html="selectedbread_model_class.body">
																														</div>

                                                        </v-col>
                                                    </v-row>
																										</v-banner>
                                                </v-container>
                                            </v-card-text>

                                            <v-card-actions>
                                                <div class="flex-grow-1"></div>
                                                <v-btn color="blue darken-1" text @click="showbread_model_classDialog = false">Close</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                    <v-dialog v-model="dialog" max-width="800px">
                                        <template v-slot:activator="{ on }">
                                            <v-btn fab small color="primary" dark class="mb-2" @click="showNewbread_model_class">
                                                <v-icon>add</v-icon>
                                            </v-btn>

                                            <v-btn
                                                fab
                                                small
                                                :loading="loading"
                                                :disabled="loading"
                                                color="blue-grey"
                                                class="mb-2 mr-2 white--text"
                                                @click="fetchbread_model_classes()"
                                                >
                                                <v-icon>cached</v-icon>
                                            </v-btn>

                                            <v-btn
                                                fab
                                                small
                                                dark
                                                color="blue-grey"
                                                class="mb-2 mr-2"
                                                @click="filtering = !filtering">
                                                <v-icon>filter_list</v-icon>
                                            </v-btn>

                                        </template>
                                        <v-card>
                                            <v-card-title>
                                                <span class="headline">{{ editedbread_model_classIndex === -1 ? 'New bread_model_class' : 'Edit bread_model_class' }}</span>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-container>
                                                    <v-row>
                                                        <v-col cols="12" sm="12" md="12">
																														<v-text-field v-model="editedbread_model_class.title" label="Title"/>
                                                        </v-col>
                                                        <v-col cols="12" sm="6" md="6">
																														<DatePicker v-model="editedbread_model_class.date" label="Date"/>
                                                        </v-col>
                                                        <v-col cols="12" sm="12" md="12">
																														<tiptap-vuetify
																																label="Report Body"
																																v-model="editedbread_model_class.body"
																																:extensions="extensions"
																																/>
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
                            </v-col>

                            <v-col v-show="filtering"  cols="12" sm="12" md="12">
                                <v-container>
                                    <v-banner elevation="1">

                                        <v-row>
                                            <v-col cols="12" sm="12" md="6">
                                                <!-- Employee -->
                                                <AutoSelector
                                                    label="Employee"
                                                    url="/employees/json_list?q="
                                                    field="full_name"
                                                    :limitToList="true"
                                                    item_select_event_name="bread_model_classes_employee_name_filter_item_selected"
                                                    @bread_model_classes_employee_name_filter_item_selected="applyFilterRule('employees.full_name', $event.full_name)"
                                                    />
                                            </v-col>

                                            <v-col cols="12" sm="12" md="6">
                                                <!-- Date -->
                                                <DatePicker @input="applyFilterRule('date', $event)" label="Date"/>
                                            </v-col>
                                        </v-row>

                                        <template v-slot:actions>
                                            <v-btn text small color="primary" @click="clearFilterRules"><v-icon>clear</v-icon></v-btn>
                                        </template>
                                    </v-banner>
                                </v-container>
                            </v-col>
                        </v-row>

                </template>

								<template v-slot:item.date="{ item }">
										{{ item.date | moment('Do MMM YYYY') }}
								</template>


                <template v-slot:item.action="{ item }">
                    <v-icon :disabled="isDisabled('showEditbread_model_class', item)" small class="mr-2" @click.stop="showEditbread_model_class(item)" >
                        edit
                    </v-icon>
                    <v-icon :disabled="isDisabled('showEditbread_model_class', item)"  small @click.stop="deletebread_model_class(item)" >
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
import Vue from 'vue';
import DatePicker from '@/components/DatePicker';
import bread_model_class from '@/models/bread_model_class';
import AutoSelector from '@/components/AutoSelector';
import { TiptapVuetify, Heading, Bold, Italic, Strike, Underline, Code, Paragraph, BulletList, OrderedList, ListItem, Link, Blockquote, HardBreak, HorizontalRule, History } from 'tiptap-vuetify'

export default {
    name: 'bread_model_classes',
    components: { DatePicker, AutoSelector, TiptapVuetify },
    data () {
        return {
            //bread_model_classes: [],
						selectedbread_model_class: {},
						showbread_model_classDialog: false,

            filterRules: [],
            filtering: false,
            loading: false,
            options: {page: 1, itemsPerPage: 5},
            bread_model_classesCount: 0,
            dialog: false,
            editedbread_model_classIndex: -1,
            editedbread_model_class: {
                title: "",
                body: "",
                date: Vue.moment(new Date()).format('YYYY-MM-DD'),
            },
            defaultItem: {
                title: "",
                body: "",
                date: Vue.moment(new Date()).format('YYYY-MM-DD'),
            },
            headers: [
                { text: 'Employee', value: 'employee_name', sortable: true,  },
                { text: 'Title', align: 'left', sortable: true, value: 'title', },
                { text: 'Date', align: 'left', sortable: true, value: 'date', },
                { text: 'Actions', value: 'action', sortable: false },
            ],

						extensions: [
								History,
								Blockquote,
								Link,
								Underline,
								Strike,
								Italic,
								ListItem,
								BulletList,
								OrderedList,
								[Heading, {
								options: {
										levels: [1, 2, 3]
								}
								}],
								Bold,
								Code,
								HorizontalRule,
								Paragraph,
								HardBreak
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
    computed: {
        bread_model_classes(){
            const {sortBy, sortOrder} = this.getSortOptions(this.options);
            return bread_model_class.query()
                .orderBy(sortBy, sortOrder)
                .get();
        },
    },
    methods: {

        closeDialog() {
            this.dialog =  false;
            this.editedbread_model_class = Object.assign({}, this.defaultItem);
            this.setEditIndex = -1;
        },

        async fetchbread_model_classes() {

            this.loading = true;
            const {page, itemsPerPage, sortBy, sortDesc} = this.options;
            const sort = this.getSortParams(sortBy);
            const order = this.getSortParams(sortDesc)? 'desc': 'asc'

            // Clean the state
            bread_model_class.deleteAll();
            await bread_model_class.api().fetch({
                dataTransformer: (response) => {
                    this.bread_model_classesCount = response.data.total;
                    return response.data.rows;
                },
                params: {
                    page: page,
                    rows: itemsPerPage,
                    sort,
                    order,
                    filterRules: JSON.stringify(this.filterRules),
                }
            });

            this.loading = false;
        },

        async deletebread_model_class(item) {
            if (! await this.$root.$confirm('Delete', 'Are you sure to delete this bread_model_class?', { color: 'red' })) {
                return;
            }
            await bread_model_class.api().destroy(item.id);
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
            let editedbread_model_class = this.editedbread_model_class;
            // Update bread_model_variable
            if (this.editedbread_model_classIndex > -1) {
                await bread_model_class.api().update(editedbread_model_class.id, editedbread_model_class );

                // add bread_model_variable
            } else {
                await bread_model_class.api().post({
                    dataKey: 'obj',
                    data: editedbread_model_class
                })

                if (this.bread_model_classesCount == 0) {
                    this.fetchbread_model_classes();
                }
            }
            this.closeDialog();
        },

        applyFilterRule(field, value, op = 'contains') {

            //[{"field":"name","op":"contains","value":"Adi"}]
            let filterRule = { "field": field, "op": op, "value": value};

            var foundFilterRule = this.filterRules.find(function(element) {
                return element.field  == field;
            });

            // remove old filter rule if exists
            if (foundFilterRule) {
                this.filterRules.splice(this.filterRules.indexOf(foundFilterRule), 1);
            }

            this.filterRules.push(filterRule);
            this.fetchbread_model_classes();
        },

        clearFilterRules() {
            // Clear all filters
            this.filterRules = [];
            this.filtering = false;
            this.fetchbread_model_classes();
        },

        isDisabled(operation, item)
        {
						return item.employee_id != this.loggedInUser.employee_id;
        },

				showbread_model_class(bread_model_class) {
						this.selectedbread_model_class = bread_model_class;
						this.showbread_model_classDialog = true;
				}

    },

}
</script>

<style>

</style>
