<template>
    <v-app>
        <core-app-bar v-if="this.$auth.loggedIn" />
        <core-drawer v-if="this.$auth.loggedIn" />
        <core-view />
        <core-footer v-if="this.$auth.loggedIn" />
    </v-app>
</template>

<script>
import Drawer from '@/components/core/Drawer';
import Footer from '@/components/core/Footer';
import AppBar from '@/components/core/AppBar';
import View from '@/components/core/View';
export default {
    middleware: 'auth',
    props: {
        source: String,
    },
    data: () => ({
        drawer: null,
    }),
    components: {
        CoreDrawer: Drawer,
        CoreFooter: Footer,
        CoreAppBar: AppBar,
        CoreView: View,
    },
};
</script>
