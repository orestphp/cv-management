<template>
    <v-card class="card-with-bottom-m">
        <v-toolbar flat dark color="primary" class="custom_cls">
            <v-btn icon dark @click="remove(education)" class="text-right">
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-card flat class="text-h6 card-title">
                <EducationForm
                    v-if="education"
                    :education="education"
                    @editEducationItem="editEducationHandler($event)"
                    ref="educationFormRef"
                >
                    {{ !edu.institution_name ? education.institution_name : edu.institution_name }}
                </EducationForm>
            </v-card>
        </v-toolbar>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Institute Name</v-list-item-title>
                <v-list-item-subtitle>
                    {{ !edu.institution_name ? education.institution_name : edu.institution_name }}
                </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Faculty</v-list-item-title>
                <v-list-item-subtitle>{{ !edu.faculty ? education.faculty : edu.faculty }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Website</v-list-item-title>
                <v-list-item-subtitle>{{ !edu.website ? education.website : edu.website }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Summary</v-list-item-title>
                <v-list-item-subtitle>{{ !edu.summary ? education.summary : edu.summary }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Period</v-list-item-title>
                <v-list-item-subtitle>{{ !edu.period ? education.period : edu.period }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
    </v-card>
</template>

<script>
import EducationForm from '../components/EducationForm.vue';
import { mapState, mapMutations } from 'vuex';
import _ from '../node_modules/lodash'; // fix for v-model="cv.title" where 'cv' from store

export default {
    components: { EducationForm },
    props: ['education'],
    data: () => ({
        edu: {},
    }),
    computed: {
        ...mapState('app', {
            cvs: (state) => _.cloneDeep(state.cvs),
        }),
    },
    methods: {
        ...mapMutations('app', ['setCvs', 'setDeletedEducations']),

        remove(education) {
            this.$emit('deleteEducation', education);
        },
        closeDialog(educationId) {
            // destroy the vue listeners, etc
            this.$destroy();
            // remove the element from the DOM
            this.$el.parentNode.removeChild(this.$el);
            // deleted education
            if (Number.isInteger(educationId)) {
                this.setDeletedEducations(educationId);
            }
        },
        editEducationHandler(education) {
            console.log('Edit: ', education); // received from "EducationForm" component
            if (typeof education.institution_name !== 'undefined' && education.institution_name !== '') {
                this.edu = education;
                this.updateEducationInStore(this.education.id, education);
            }
        },
        updateEducationInStore(eduId, newEducation) {
            // had todo it in "EducationForm" (child) cos it`s B in A, B, C herarchy
            const cvId = parseInt(this.$route.query['id']);
            this.cvs.forEach((cv, cvIndex) => {
                if (cv.id == cvId) {
                    if (typeof cv.education !== 'undefined') {
                        cv.education.forEach((edu, index) => {
                            if (edu.id == eduId) {
                                cv.education[index] = { ...newEducation }; // commit it
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
