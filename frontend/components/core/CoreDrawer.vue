<template>
    <v-navigation-drawer
        id="app-drawer"
        v-model="inputValue"
        :src="require('/static/img/left_side_bg.jpeg')"
        app
        color="grey darken-2"
        dark
        floating
        mobile-breakpoint="991"
        persistent
        width="260"
    >
        <template v-slot:img="attrs">
            <v-img v-bind="attrs" gradient="to top, rgba(0 ,0 ,0 , .8), rgba(0 ,0 ,0 , .8)" />
        </template>

        <v-list-item two-line>
            <v-list-item-avatar color="white">
                <v-img :src="require('/static/img/hr.png')" height="34" contain />
            </v-list-item-avatar>

            <v-list-item-title class="title">HR Company</v-list-item-title>
        </v-list-item>

        <v-divider class="mx-3 mb-3" />

        <v-list nav>
            <!-- Bug in Vuetify for first child of v-list not receiving proper border-radius -->

            <v-list-item v-for="(link, i) in links" :key="i" :to="link.to" active-class="primary white--text">
                <v-list-item-action>
                    <v-icon>{{ link.icon }}</v-icon>
                </v-list-item-action>

                <v-list-item-title>{{ link.text }}</v-list-item-title>
            </v-list-item>
        </v-list>

        <template v-slot:append>
            <v-list nav>
                <v-list-item to="#">
                    <v-list-item-action>
                        <v-icon>mdi-package-up</v-icon>
                    </v-list-item-action>

                    <v-list-item-title class="font-weight-light">Something else</v-list-item-title>
                </v-list-item>
            </v-list>
        </template>
    </v-navigation-drawer>
</template>

<script>
// Utilities
import { mapMutations, mapState } from 'vuex';

export default {
    props: {
        opened: {
            type: Boolean,
            default: false,
        },
    },
    data: () => ({
        links: [
            {
                to: '/cv-list',
                icon: 'mdi-clipboard-outline',
                text: 'CV List',
            },
            {
                to: '/user-profile',
                icon: 'mdi-account',
                text: 'User Profile',
            },
            // {
            //     to: '/',
            //     icon: 'mdi-view-dashboard',
            //     text: 'Dashboard',
            // },
            // {
            //     to: '/maps',
            //     icon: 'mdi-map-marker',
            //     text: 'GoogleMaps',
            // },
            // {
            //     to: '/notifications',
            //     icon: 'mdi-bell',
            //     text: 'Notifications',
            // },
        ],
    }),

    computed: {
        ...mapState('app', ['image', 'color']),
        inputValue: {
            get() {
                return this.$store.state.app.drawer;
            },
            set(val) {
                this.setDrawer(val);
            },
        },
    },

    methods: {
        ...mapMutations('app', ['setDrawer', 'toggleDrawer']),
    },
};
</script>
