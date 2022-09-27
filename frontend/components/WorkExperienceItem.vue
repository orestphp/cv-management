<template>
    <v-card class="card-with-bottom-m">
        <v-toolbar flat dark color="primary" class="custom_cls">
            <v-btn icon dark @click="close" class="text-right">
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-card flat class="text-h6 card-title">{{ experience.position }}</v-card>
        </v-toolbar>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Position</v-list-item-title>
                <v-list-item-subtitle>{{ experience.position }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Company Name</v-list-item-title>
                <v-list-item-subtitle>{{ experience.company_name }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Company Website</v-list-item-title>
                <v-list-item-subtitle>{{ experience.company_website }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Tech-stack</v-list-item-title>
                <v-list-item-subtitle>{{ experience.tech_stack }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Summary</v-list-item-title>
                <v-list-item-subtitle>{{ experience.summary }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line>
            <v-list-item-content>
                <v-list-item-title>Period</v-list-item-title>
                <v-list-item-subtitle>{{ experience.period }}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
    </v-card>
</template>

<script>
export default {
    props: ['experience'],
    data: () => ({}),
    methods: {
        close() {
            // destroy the vue listeners, etc
            this.$destroy();
            // remove the element from the DOM
            this.$el.parentNode.removeChild(this.$el);
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
