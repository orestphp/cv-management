<template>
    <v-row>
        <v-dialog v-model="dialog" persistent max-width="600px">
            <template v-slot:activator="{ on, attrs }">
                <v-btn color="primary" dark v-bind="attrs" v-on="on">
                    <slot></slot>
                </v-btn>
            </template>
            <div id="scrollEdu">
                <v-toolbar flat dark color="primary" class="custom_cls">
                    <v-btn icon dark @click="dialog = false" class="text-right">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar>

                <v-card>
                    <v-card-title>
                        <span class="text-h5">Education Institute</span>
                    </v-card-title>
                    <v-card-text>
                        <div class="card-required">
                            <small>* indicates required field</small>
                        </div>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                        label="Institute Name*"
                                        required
                                        v-model="edu.institution_name"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field label="Faculty" v-model="edu.faculty"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field label="Website" v-model="edu.website"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field label="Summary" v-model="edu.summary"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <DatePicker v-on:updatePeriod="aPeriod = $event" />
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="close">Close</v-btn>
                        <v-btn color="blue darken-1" text @click.prevent="saveEducationItem">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </div>
        </v-dialog>
    </v-row>
</template>

<script>
import DatePicker from './DatePicker.vue';
import moment from 'moment';

export default {
    components: { DatePicker },
    props: ['education'],
    data: () => ({
        aPeriod: [],
        edu: {},
        eduDefault: {
            institution_name: '',
            faculty: '',
            //address: '',
            website: '',
            summary: '',
            period: '',
            period_from: '',
            period_to: '',
        },
        dialog: false,
    }),
    mounted() {
        this.$nextTick(function () {
            if (this.education) {
                // received "education" via props
                this.edu = { ...this.education };
            }
        });

        Object.assign(this.edu, this.eduDefault, this.education);
    },
    methods: {
        saveEducationItem() {
            // Format date
            const from = this.fDate(this.aPeriod[0]);
            const to = this.fDate(this.aPeriod[1]);
            this.edu.period_from = this.aPeriod[0];
            this.edu.period_to = this.aPeriod[1];
            this.edu.period = `From ${from} - ${to}`;
            const cvId = parseInt(this.$route.query['id']);

            if (this.edu.institution_name !== '' && this.edu.id && cvId) {
                // "edit" Education Item
                this.$emit('editEducationItem', this.edu);
            } else {
                // "add" Education Item
                this.$emit('addEducationItem', this.edu);
            }

            // Close
            this.close();
        },
        reset() {
            this.edu.institution_name = '';
            this.edu.faculty = '';
            // this.edu.address = '';
            this.edu.website = '';
            this.edu.summary = '';
            this.edu.period = '';
            this.edu.period_from = '';
            this.edu.period_to = '';
        },
        fDate(date) {
            if (date) {
                return moment(String(date)).format('DD/MM/YYYY');
            }
        },
        close() {
            this.dialog = false;
            document.getElementById('scrollEdu').scrollIntoView();
        },
    },
};
</script>

<style scope>
.text-right {
    float: right !important;
}

.custom_cls {
    display: block;
    width: 100%;
}

.card-required {
    color: black !important;
}
</style>
