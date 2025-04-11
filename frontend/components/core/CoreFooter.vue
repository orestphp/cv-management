<template>
    <v-footer id="core-footer" height="82">
        <div class="footer-items">
            <span v-for="link in links" :key="link.name">
                <a :href="link.Link" class="tertiary--text footer-links">
                    {{ link.name }}
                </a>
            </span>
        </div>
        <v-spacer />
        <!-- <span class="font-weight-light copyright">
            &copy; {{ new Date().getFullYear() }}
            <a href="#" target="_blank">
                DevIT
                <v-icon color="tertiary" size="17">mdi-star</v-icon>
            </a>
            , nuxtjs+vuetify+laravel9
        </span> -->
    </v-footer>
</template>

<script>
export default {
    data: () => ({
        links: [{ name: 'Home', Link: '/#' }],
    }),
};
</script>

<style>
#core-footer {
    z-index: 0;
}
</style>
