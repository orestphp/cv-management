<template>
    <v-row>
        <v-dialog v-model="dialog" persistent max-width="600px">
            <template v-slot:activator="{ on, attrs }">
                <v-btn color="primary" dark v-bind="attrs" v-on="on">
                    <slot></slot>
                </v-btn>
            </template>
            <div id="scrollWorkExp">
                <v-toolbar flat dark color="primary" class="custom_cls">
                    <v-btn icon dark @click="dialog = false" class="text-right">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar>
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Professional Experience</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field label="Position*" required v-model="exp.position"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field label="Conpany Name" v-model="exp.company_name"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field label="Company Website" v-model="exp.company_website"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field label="Tech Stack" v-model="exp.tech_stack"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field label="Summary" v-model="exp.summary"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <DatePicker v-on:updatePeriod="aPeriod = $event" />
                                </v-col>
                            </v-row>
                        </v-container>
                        <small>*indicates required field</small>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="close">Close</v-btn>
                        <v-btn color="blue darken-1" text @click.prevent="saveWorkExperienceItem">Save</v-btn>
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
    props: ['experience'],
    data: () => ({
        aPeriod: [],
        exp: {},
        expDefault: {
            temp_id: 0,
            position: '',
            company_name: '',
            company_website: '',
            tech_stack: '',
            summary: '',
            period: '',
            period_from: '',
            period_to: '',
        },
        dialog: false,
    }),
    mounted() {
        if (this.experience) {
            // received "experience" via props
            this.exp = { ...this.experience };
        }
        Object.assign(this.exp, this.expDefault, this.experience);
    },
    methods: {
        saveWorkExperienceItem() {
            // Format date
            const from = this.fDate(this.aPeriod[0]);
            const to = this.fDate(this.aPeriod[1]);
            this.exp.period_from = this.aPeriod[0];
            this.exp.period_to = this.aPeriod[1];
            this.exp.period = `From ${from} - ${to}`;

            if (this.exp.position !== '' && (this.exp.id || this.exp.temp_id == this.exp.position)) {
                // "edit" WorkExperience Item
                this.$emit('editWorkExperienceItem', this.exp);
            } else {
                // "add" WorkExperience Item
                if(!this.exp.id) {
                    this.exp.temp_id = this.exp.position;
                }
                this.$emit('addWorkExperienceItem', this.exp);
            }

            // Close
            this.close();
        },
        reset() {
            this.exp.position = '';
            this.exp.company_name = '';
            this.exp.company_website = '';
            this.exp.tech_stack = '';
            this.exp.summary = '';
            this.exp.period = '';
            this.exp.period_from = '';
            this.exp.period_to = '';
        },
        fDate(date) {
            if (date) {
                return moment(String(date)).format('DD/MM/YYYY');
            }
        },
        close() {
            this.dialog = false;
            document.getElementById('scrollWorkExp').scrollIntoView();
        },
    },
};
</script>
