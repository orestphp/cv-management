<template>
    <v-row>
        <v-col cols="12">
            <v-date-picker v-model="dates" range header-color="dp-header"></v-date-picker>
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="dateRangeText"
                label="Date range"
                prepend-icon="mdi-calendar"
                readonly
            ></v-text-field>
        </v-col>
    </v-row>
</template>

<script>
export default {
    data: () => ({
        dates: ['2019-09-10', '2019-09-20'],
    }),
    computed: {
        dateRangeText() {
            this.$emit('updatePeriod', this.dates);
            return this.dates.join('-');
        },
    },
};
</script>

<style scppe>
.dp-header {
    background-color: #82b1ff !important;
}
</style>
