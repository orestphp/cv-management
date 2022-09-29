export default {
    setDrawer: (state, value) => (state.drawer = value),
    setImage: (state, value) => (state.image = value),
    setColor: (state, value) => (state.color = value),
    toggleDrawer: (state) => (state.drawer = !state.drawer),
    // Cv
    setCvs: (state, cvs) => {
        state.cvs = cvs;
    },
    setDeletedEducations(state, deletedEducations) {
        if(deletedEducations) {
            state.deletedEducations.push(deletedEducations);
        } else {
            state.deletedEducations = [];
        }
    },
    setDeletedWorkExperiences(state, deletedWorkExperiences) {
        if(deletedWorkExperiences) {
            state.deletedWorkExperiences.push(deletedWorkExperiences);
        } else {
            state.deletedWorkExperiences = [];
        }
    },
    deleteCv(state, { cv }) {
        state.cvs.splice(state.cvs.indexOf(cv), 1);
    },
};
