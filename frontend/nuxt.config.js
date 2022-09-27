module.exports = {
    /*
     ** Headers of the page
     */
    head: {
        title: 'nuxt-vuetify-dashboard',
        meta: [
            { charset: 'utf-8' },
            {
                name: 'viewport',
                content: 'width=device-width, initial-scale=1',
            },
            {
                hid: 'description',
                name: 'description',
                content: 'Nuxt.js + Vuetify.js + Material Dashboard',
            },
        ],
        link: [
            { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
            {
                rel: 'stylesheet',
                href: 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons',
            },
        ],
    },
    plugins: [
        '~/plugins/axios.js',
        '~/plugins/vuetify.js',
        '~/plugins/base.js',
        '~/plugins/chartist.js',
        '~/plugins/components.js',
        { src: '~/plugins/ckeditor.js', mode: 'client' },
        // { src: '~/plugins/vuex-persist.js', mode: 'client' } // gives Err: 
        /*
        [Vue warn]: The client-side rendered virtual DOM tree is not matching server-rendered content. This is likely caused by incorrect HTML markup ..
        */
    ],
    css: ['~/assets/less/main.less'],
    /*
     ** Customize the progress bar color
     */
    loading: { color: '#3B8070' },
    /*
     ** Build configuration
     */
    build: {
        extractCSS: true,
        optimization: {
            splitChunks: {
                cacheGroups: {
                    styles: {
                        name: 'styles',
                        test: /\.(css|vue)$/,
                        chunks: 'all',
                        enforce: true,
                    },
                },
            },
        },
        extend(config, ctx) {
            // Run ESLint on save
            if (ctx.isDev && ctx.isClient) {
                config.module.rules.push({
                    enforce: 'pre',
                    test: /\.(js|vue)$/,
                    loader: 'eslint-loader',
                    exclude: /(node_modules)/,
                });
            }
            if (ctx.isClient) {
                config.devtool = 'source-map';
            }
        },
        transpile: [/^vuetify/],
        postcss: null,
    },
    /*
     ** Nuxt.js dev-modules
     */
    buildModules: [
        // Doc: https://github.com/nuxt-community/eslint-module
        '@nuxtjs/eslint-module',
    ],
    /*
     ** Nuxt.js modules
     */
    modules: ['@nuxtjs/axios', '@nuxtjs/auth-next'],
    /*
     ** Axios module configuration
     ** See https://axios.nuxtjs.org/options
     */
    axios: {
        baseURL: 'http://localhost:8001/',
        credentials: true,
    },
    auth: {
        strategies: {
            laravelSanctum: {
                provider: 'laravel/sanctum',
                url: 'http://localhost:8001',
                endpoints: {
                    login: { url: '/login', method: 'post' },
                    logout: { url: '/logout', method: 'post' },
                    user: { url: '/api/user', method: 'get' },
                },
                user: {
                    property: false,
                },
            },
        },
        redirect: {
            login: '/auth/login',
            logout: '/auth/login',
            home: '/cv-list'
        },
    },
};
