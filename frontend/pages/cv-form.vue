<template>
    <v-container fill-height fluid>
        <v-row justify="center">
            <v-col cols="12" md="8">
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
                <v-dialog v-model="dialogEduDelete" max-width="500px">
                    <v-card>
                        <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="closeEduDelete">Cancel</v-btn>
                            <v-btn color="blue darken-1" text @click="deleteEduItemConfirm">OK</v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-dialog v-model="dialogExpDelete" max-width="500px">
                    <v-card>
                        <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="closeExpDelete">Cancel</v-btn>
                            <v-btn color="blue darken-1" text @click="deleteExpItemConfirm">OK</v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <material-card color="green" title="Edit CV" text="">
                    <v-form>
                        <v-container class="py-0">
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field v-model="cv.title" label="Position Title" required />
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field v-model="cv.first_name" label="First Name" class="purple-input" />
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field v-model="cv.surname" label="Surname" class="purple-input" />
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field v-model="cv.middle_name" label="Middle Name" class="purple-input" />
                                </v-col>

                                <v-col cols="12" md="6">
                                    <DobDatePicker @updateDob="strDob = $event" :dob="cv.date_of_birth" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field v-model="cv.address" label="Adress" class="purple-input" />
                                </v-col>

                                <v-col cols="12" md="4" class="d-flex">
                                    <v-select
                                        v-model="cv.district"
                                        :items="cities"
                                        label="District"
                                        class="purple-input"
                                    ></v-select>
                                </v-col>

                                <v-col cols="12" md="4" class="d-flex purple-input">
                                    <v-text-field v-model="cv.city" label="City/Town" class="purple-input" />
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field v-model="cv.email" class="purple-input" label="Email" />
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field v-model="cv.phone" class="purple-input" label="Phone" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field v-model="cv.skype" class="purple-input" label="Skype" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field v-model="cv.linkedin" class="purple-input" label="LinkedIn" />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field v-model="cv.website" label="Website" class="purple-input" />
                                </v-col>

                                <v-col cols="12">
                                    <v-textarea v-model="cv.about_me" class="purple-input" label="About Me" value="" />
                                </v-col>

                                <v-col cols="12">
                                    <v-textarea
                                        v-model="cv.technology_experience"
                                        class="purple-input"
                                        label="Technology Experience"
                                        value=""
                                    />
                                </v-col>

                                <v-col cols="12" class="text-left">
                                    <hr />
                                    <div class="btn-both-v">
                                        <EducationForm
                                            @addEducationItem="listNewEducation($event)"
                                            ref="educationFormRef"
                                        >
                                            + Education
                                        </EducationForm>
                                    </div>
                                    <v-col cols="12">
                                        <v-flex v-for="education in educations" :key="education.institution_name">
                                            <EducationItem
                                                @deleteEducation="deleteEduItem($event)"
                                                :education="education"
                                                :cvEducations="cvEducations"
                                                :ref="(el) => educationIds.push({ educationId: education.id, el: el })"
                                            ></EducationItem>
                                        </v-flex>
                                    </v-col>
                                    <hr />
                                    <div class="btn-both-v">
                                        <WorkExperienceForm
                                            @addWorkExperienceItem="listNewWorkExperience($event)"
                                            ref="experienceFormRef"
                                        >
                                            + Work Experience
                                        </WorkExperienceForm>
                                    </div>
                                    <v-col cols="12">
                                        <v-flex v-for="experience in workExperiences" :key="experience.position">
                                            <WorkExperienceItem
                                                @deleteExperience="deleteExpItem($event)"
                                                :experience="experience"
                                                :ref="
                                                    (el) => experienceIds.push({ experienceId: experience.id, el: el })
                                                "
                                            ></WorkExperienceItem>
                                        </v-flex>
                                    </v-col>
                                </v-col>
                                <v-col cols="12" class="text-right">
                                    <v-btn color="info" @click="saveCv()">Save CV</v-btn>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                </material-card>
            </v-col>
            <v-col cols="12" md="4">
                <material-card class="v-card-profile">
                    <v-avatar slot="offset" class="mx-auto d-block elevation-6" size="130">
                        <img src="https://demos.creative-tim.com/vue-material-dashboard/img/marc.aba54d65.jpg" />
                    </v-avatar>
                    <v-card-text class="text-center">
                        <h6 class="overline mb-3">CEO / CO-FOUNDER</h6>

                        <h4 class="font-weight-light">Alec Thompson</h4>

                        <p class="font-weight-light">
                            Don't be scared of the truth because we need to restart the human foundation in truth And I
                            love you like Kanye loves Kanye I love Rick Owens’ bed design but the back is...
                        </p>

                        <v-btn color="success">Follow</v-btn>
                    </v-card-text>
                </material-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import EducationForm from '../components/EducationForm.vue';
import WorkExperienceForm from '../components/WorkExperienceForm.vue';
import DobDatePicker from '../components/DobDatePicker.vue';
import EducationItem from '../components/EducationItem.vue';
import WorkExperienceItem from '../components/WorkExperienceItem.vue';
import { mapState, mapGetters, mapMutations } from 'vuex';
import _ from '../node_modules/lodash'; // *fix for v-model="cv.title" where 'cv' from store

export default {
    middleware: 'auth',
    components: { EducationForm, WorkExperienceForm, DobDatePicker, EducationItem, WorkExperienceItem },
    data: () => ({
        strDob: '',
        dialog: false,
        errorClass: '',
        dialogEduDelete: false,
        dialogExpDelete: false,

        educationId: 0,
        educationIds: [],
        tempEducationDelete: {},

        experienceId: 0,
        experienceIds: [],
        tempExperienceDelete: {},

        cv: {
            title: '',
            first_name: '',
            surname: '',
            middle_name: '',
            date_of_birth: '',
            address: '',
            district: '',
            city: '',
            email: '',
            phone: '',
            skype: '',
            linkedin: '',
            website: '',
            about_me: '',
            technology_experience: '',
        },
        cvEducations: [],
        cvWorkExperiences: [],
        cities: [
            'Kyiv',
            'Sevastopol',
            'Cherkasy Oblast',
            'Chernihiv Oblast',
            'Chernivtsi Oblast',
            'Crimea',
            'Dnipropetrovsk Oblast',
            'Donetsk Oblast',
            'Kharkiv Oblast',
            'Kherson Oblast',
            'Kirovohrad Oblast',
            'Luhansk Oblast',
            'Lviv Oblast',
            'Mykolaiv Oblast',
            'Odesa Oblast',
            'Poltava Oblast',
            'Sumy Oblast',
            'Zaporizhzhia Oblast',
        ],
    }),
    computed: {
        ...mapState('app', {
            cvs: (state) => _.cloneDeep(state.cvs),
            deletedEducations: (state) => state.deletedEducations,
            deletedWorkExperiences: (state) => state.deletedWorkExperiences,
        }),
        ...mapGetters('app', ['getCv', 'getDeletedEducations', 'getDeletedWorkExperiences']),

        changeDialogColor() {
            return this.errorClass;
        },
        educations() {
            return this.cvEducations;
        },
        workExperiences() {
            return this.cvWorkExperiences;
        },
    },
    created() {
        this.editingCv();
    },
    mounted() {
        this.changeDialogColor;
    },
    methods: {
        ...mapMutations('app', ['setDeletedEducations', 'setDeletedWorkExperiences']),
        ///////////////////// Delete Education /////////////////////
        deleteEduItem(education) {
            this.educationId = education.id;
            this.tempEducationDelete = education;
            this.dialogEduDelete = true;
        },
        deleteEduItemConfirm() {
            let self = this;
            if (typeof this.tempEducationDelete.temp_id !== 'undefined') {
                // delete the one from 'cvEducations'
                this.cvEducations.splice(
                    this.cvEducations.findIndex(function (ed) {
                        return ed.temp_id === self.tempEducationDelete.temp_id;
                    }),
                    1
                );
            } else {
                // delete the one from 'cvEducations')
                this.cvEducations.splice(
                    this.cvEducations.findIndex(function (ed) {
                        return ed.id === self.tempEducationDelete.id;
                    }),
                    1
                );
            }
            // close html element
            let result = this.educationIds.filter((obj) => {
                return obj.educationId === this.educationId;
            });
            const education = Array.isArray(result) ? result[0] : result;
            education.el.closeDialog(this.educationId);
            this.tempEducationDelete = {};
            this.dialogEduDelete = false;
        },
        closeEduDelete() {
            this.$nextTick(() => {
                this.dialogEduDelete = false;
            });
        },
        //////////////////// Delete WorkExperiences////////////////////////
        deleteExpItem(experience) {
            this.experienceId = experience.id;
            if (typeof experience.temp_id !== 'undefined' && experience.temp_id !== '') {
                this.tempExperienceDelete = experience;
            }
            this.dialogExpDelete = true;
        },
        deleteExpItemConfirm() {
            let self = this;
            if (this.tempExperienceDelete.temp_id) {
                // delete the one from 'cvEducations')
                this.cvWorkExperiences.splice(
                    this.cvWorkExperiences.findIndex((ex) => ex.temp_id === self.tempExperienceDelete.temp_id),
                    1
                );
            } else {
                // delete the one from 'cvEducations')
                this.cvWorkExperiences.splice(
                    this.cvWorkExperiences.findIndex((ex) => ex.id === self.tempExperienceDelete.id),
                    1
                );
            }
            // delete html element
            let result = this.experienceIds.filter((obj) => {
                return obj.experienceId === this.experienceId;
            });
            const experience = Array.isArray(result) ? result[0] : result;
            experience.el.closeDialog(this.experienceId);
            this.tempExperienceDelete = {};
            this.dialogExpDelete = false;
        },
        closeExpDelete() {
            this.$nextTick(() => {
                this.dialogExpDelete = false;
            });
        },
        ///////////////////////////////////////////////////////////////////
        editingCv() {
            const cvId = parseInt(this.$route.query['id']);
            if (cvId) {
                this.initCvByIdFromStore(cvId);
                this.cvEducations = this.cv.education;
                this.cvWorkExperiences = this.cv.work_experience;
            }
        },
        initCvByIdFromStore(id) {
            this.cvs.forEach((cv) => {
                if (cv.id === id) {
                    return (this.cv = cv);
                }
            });
        },
        listNewEducation(education) {
            if (typeof education.institution_name !== 'undefined' && education.institution_name !== '') {
                const newEducation = Object.assign({}, education);
                this.cvEducations.unshift(newEducation);
                this.$refs.educationFormRef.reset();
            }
        },
        listNewWorkExperience(experience) {
            if (typeof experience.position !== 'undefined' && experience.position !== '') {
                const newWorkExperience = Object.assign({}, experience);
                this.cvWorkExperiences.unshift(newWorkExperience);
                this.$refs.experienceFormRef.reset();
            }
        },
        // Save/edit Cv (finish)
        async saveCv() {
            const cvId = parseInt(this.$route.query['id']);
            this.cv.date_of_birth = this.strDob ? this.strDob : this.cv.date_of_birth;
            let action = !isNaN(cvId) ? '/api/cv/' + cvId : '/api/cv';
            if (!isNaN(cvId)) {
                this.initCvByIdFromStore(cvId);
            }
            let data = !isNaN(cvId)
                ? {
                      cv: this.cv,
                      cvEducations: this.cvEducations,
                      cvWorkExperiences: this.cvWorkExperiences,
                      deletedEducations: this.deletedEducations,
                      deletedWorkExperiences: this.deletedWorkExperiences,
                  }
                : {
                      cv: this.cv,
                      cvEducations: this.cvEducations,
                      cvWorkExperiences: this.cvWorkExperiences,
                  };
            let self = this;
            // Save all CV
            await this.$axios.$get('sanctum/csrf-cookie');
            await this.$axios
                .post(action, data)
                .then(function (response) {
                    if (response) {
                        self.setDeletedEducations();
                        self.setDeletedWorkExperiences();
                        self.$router.push('/cv-list');
                    }
                })
                .catch(function (error) {
                    console.log(error);

                    if (error && error.response) {
                        self.dialog = true;
                        setTimeout(function () {
                            self.errorClass = 'error';
                            document.getElementById('cv-alert-title').innerHTML = 'Error:';
                            document.getElementById('cv-alert-message').innerHTML = JSON.stringify(
                                error.response.data.errors
                            );
                        }, 0);
                    } else {
                        self.$router.push('/cv-list');
                    }
                });
        },
    },
};
</script>

<style>
.btn-both-v {
    margin: 20px;
}
</style>
