<template>
    <v-card class="card-with-bottom-m">
        <v-toolbar flat dark color="primary" class="custom_cls">
            <v-btn icon dark @click="remove" class="text-right">
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-card flat class="text-h6 card-title">
                <WorkExperienceForm
                    v-if="experience"
                    :experience="experience"
                    @editWorkExperienceItem="editExperienceHandler($event)"
                    ref="experienceFormRef"
                >
                    {{ !exp.position ? experience.position : exp.position }}
                </WorkExperienceForm>
            </v-card>
        </v-toolbar>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Position</v-list-item-title>
                <v-list-item-subtitle>{{ !exp.position ? experience.position : exp.position }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Company Name</v-list-item-title>
                <v-list-item-subtitle>
                    {{ !exp.company_name ? experience.company_name : exp.company_name }}
                </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Company Website</v-list-item-title>
                <v-list-item-subtitle>
                    {{ !exp.company_website ? experience.company_website : exp.company_website }}
                </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Tech-stack</v-list-item-title>
                <v-list-item-subtitle>
                    {{ !exp.tech_stack ? experience.tech_stack : exp.tech_stack }}
                </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Summary</v-list-item-title>
                <v-list-item-subtitle>{{ !exp.summary ? experience.summary : exp.summary }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Period</v-list-item-title>
                <v-list-item-subtitle>{{ !exp.period ? experience.period : exp.period }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
    </v-card>
</template>

<script>
import WorkExperienceForm from '../components/WorkExperienceForm.vue';
import { mapState, mapMutations } from 'vuex';
import _ from '../node_modules/lodash'; // fix for v-model="cv.title" where 'cv' from store

export default {
    components: { WorkExperienceForm },
    props: ['experience'],
    data: () => ({
        exp: {},
    }),
    computed: {
        ...mapState('app', {
            cvs: (state) => _.cloneDeep(state.cvs),
        }),
    },
    methods: {
        ...mapMutations('app', ['setCvs', 'setDeletedWorkExperiences']),

        remove(experienceId) {
            if (experienceId) {
                this.$emit('deleteExperience', experienceId);
            } else {
                this.closeDialog(experienceId);
            }
        },
        closeDialog(experienceId) {
            // destroy the vue listeners, etc
            this.$destroy();
            // remove the element from the DOM
            this.$el.parentNode.removeChild(this.$el);
            // deleted experience
            if(Number.isInteger(experienceId)) {
                this.setDeletedWorkExperiences(experienceId);
            }
        },
        editExperienceHandler(experience) {
            console.log('Edit: ', experience); // received from "WorkExperienceForm" component
            if (typeof experience.position !== 'undefined' && experience.position !== '') {
                this.exp = experience;
                this.setExperienceStore(this.experience.id, experience);
            }
        },
        setExperienceStore(expId, newExperience) {
            // had todo it in "WorkExperienceForm" (child) cos it`s B in A, B, C herarchy
            const cvId = parseInt(this.$route.query['id']);
            this.cvs.forEach((cv, cvIndex) => {
                if (cv.id == cvId) {
                    if (typeof cv.work_experience !== 'undefined') {
                        cv.work_experience.forEach((exp, index) => {
                            if (exp.id == expId) {
                                cv.work_experience[index] = { ...newExperience }; // commit it
                                this.cvs[cvIndex] = cv;
                                this.setCvs(this.cvs);
                                return 1;
                            }
                        });
                    }
                }
            });
        },
    },
};
</script>

<style>
.card-with-bottom-m {
    margin-bottom: 20px;
}
.card-title {
    background-color: transparent !important;
}
</style>
