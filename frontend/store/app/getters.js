export default {
    getCv(state, id) {
        return state.cvs.find((cv) => cv.id == id);
    },
    getDeletedEducations(state) {
        return state.deletedEducations;
    },
    getDeletedWorkExperiences(state) {
        return state.deletedWorkExperiences;
    },
};
