<template>
    <v-container fill-height fluid grid-list-xl>
        <v-row justify="center">
            <v-col cols="12">
                <v-dialog v-model="dialog" width="500">
                    <v-card>
                        <v-card-title
                            class="text-h5 lighten-2 alert-title"
                            v-bind:class="changeDialogColor"
                            id="cv-alert-title"
                        ></v-card-title>
                        <v-card-text class="alert-message" id="cv-alert-message"></v-card-text>
                    </v-card>
                </v-dialog>
                <material-card color="green" flat full-width title="List of CVs" text="">
                    <v-data-table :headers="headers" :items="cvs" sort-by="id" class="elevation-1">
                        <template v-slot:top>
                            <v-toolbar flat>
                                <!-- <v-toolbar-title>My CRUD</v-toolbar-title>
                                <v-divider class="mx-4" inset vertical></v-divider> -->
                                <v-spacer></v-spacer>
                                <v-btn color="primary" dark class="mb-2" to="cv-form">New CV</v-btn>
                                <v-dialog v-model="dialogDelete" max-width="500px">
                                    <v-card>
                                        <v-card-title class="text-h5">
                                            Are you sure you want to delete this item?
                                        </v-card-title>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                            <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                            <v-spacer></v-spacer>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-toolbar>
                        </template>
                        <template v-slot:[`item.actions`]="{ item }">
                            <div class="cv-actions">
                                <v-icon small class="mr-2 mt-3" @click="editItem(item)">mdi-pencil</v-icon>
                                <v-icon small class="mt-3" @click="deleteItem(item)">mdi-delete</v-icon>
                            </div>
                        </template>
                        <template v-slot:no-data>
                            <v-btn color="primary" @click="initialize">Reset</v-btn>
                        </template>
                    </v-data-table>
                </material-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mapMutations } from 'vuex';

export default {
    data: () => ({
        //middleware: 'auth',
        dialog: false,
        errorClass: '',
        dialogDelete: false,
        headers: [
            { sortable: true, text: '#', value: 'id' },
            { sortable: true, text: 'title', value: 'title' },
            { sortable: true, text: 'email', value: 'email' },
            { sortable: true, text: 'name', value: 'name' },
            { sortable: true, text: 'birth', value: 'dob' },
            { sortable: false, text: '', value: 'actions', align: 'right' },
        ],
        cvs: [],
        editedIndex: -1,
        editedItem: { id: 0 },
        defaultItem: { id: 0 },
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Item' : 'Edit Item';
        },

        changeDialogColor() {
            return this.errorClass;
        },
    },

    watch: {
        dialog(val) {
            val || this.close();
        },
        dialogDelete(val) {
            val || this.closeDelete();
        },
    },

    created() {
        this.initialize();
        console.log('storage auth: ' + this.$auth.$storage.getState('auth'));
        console.log('user: ' + this.$auth.user);
        console.log('loggedIn: ' + this.$auth.loggedIn);
    },

    methods: {
        ...mapMutations('app', ['setCvs']),

        async initialize() {
            let self = this;
            //await this.$axios.$get('sanctum/csrf-cookie', { withCredentials: true });
            await this.$axios
                .get('/api/cv', { withCredentials: true })
                .then(function (response) {
                    console.log(response);
                    if (response.data) {
                        const tempCvs = response.data;
                        self.setCvs(tempCvs); // store
                        tempCvs.forEach((cv) => {
                            const name = cv.first_name + ' ' + cv.surname;
                            // local
                            self.cvs.push({
                                id: cv.id,
                                title: cv.title,
                                email: cv.email,
                                name: name,
                                dob: cv.date_of_birth,
                                cv: cv,
                            });
                        });
                    }
                })
                .catch(function (error) {
                    console.log('error:');
                    console.error(error);
                    window.location.href = '/auth/auth-login';
                });
        },

        editItem(cv) {
            this.$router.push('/cv-form?id=' + cv.id);
        },

        deleteItem(item) {
            this.editedIndex = this.cvs.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },

        deleteItemConfirm() {
            this.dialogDelete = false;
            if (this.editedItem.id) {
                let self = this;
                this.$axios.$get('sanctum/csrf-cookie');
                this.$axios
                    .delete('/api/cv/' + this.editedItem.id)
                    .then(function (response) {
                        if (response.data) {
                            self.cvs.splice(self.editedIndex, 1);
                            self.closeDelete();
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                        self.dialog = true;
                        setTimeout(function () {
                            self.errorClass = 'error';
                            document.getElementById('cv-alert-title').innerHTML = 'Error:';
                            document.getElementById('cv-alert-message').innerHTML = JSON.stringify(error);
                        }, 0);
                    });
            }
        },

        close() {
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        closeDelete() {
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },
    },
};
</script>

<style lang="css">
.v-data-table-header th span {
    font-size: 18px !important;
}
</style>
