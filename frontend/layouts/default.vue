<template>
    <v-app>
        <core-app-bar v-if="this.$auth.loggedIn" />
        <core-drawer v-if="this.$auth.loggedIn" />
        <core-view />
        <core-footer v-if="this.$auth.loggedIn" />
    </v-app>
</template>

<script>
import CoreDrawer from '~/components/core/CoreDrawer';
import CoreFooter from '~/components/core/CoreFooter';
import AppBar from '~/components/core/AppBar';
import CoreView from '~/components/core/CoreView';
export default {
    //middleware: 'auth',
    props: {
        source: String,
    },
    data: () => ({
        drawer: null,
    }),
    components: {
        CoreDrawer: CoreDrawer,
        CoreFooter: CoreFooter,
        CoreAppBar: AppBar,
        CoreView: CoreView,
    },
};
</script>
