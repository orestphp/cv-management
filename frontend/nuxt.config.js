export default {
    server: {
        host: '0.0.0.0', // Allow external access
        port: 3000,
    },
    runtimeConfig: {
        public: {
            apiBase: process.env.API_BASE_URL || 'http://app:8001', // Change localhost to "app"
        },
    },
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
        // '~/plugins/request-logger.js',
        // { src: '~/plugins/vuex-persist.js', mode: 'client' } // gives Err:
    ],
    css: ['~/assets/less/main.less'],
    loading: { color: '#3B8070' },
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
    buildModules: ['@nuxtjs/eslint-module'],
    modules: ['@nuxtjs/axios', '@nuxtjs/auth-next'],
    axios: {
        baseURL: 'http://localhost:8001',
        credentials: true,
    },
    auth: {
        strategies: {
            laravelSanctum: {
                provider: 'laravel/sanctum',
                url: 'http://localhost:8001',
                endpoints: {
                    login: { url: '/login', method: 'post' }, // Corrected line
                    logout: { url: '/logout', method: 'post' },
                    user: { url: '/api/user', method: 'get' },
                },
                user: {
                    property: false, // Laravel returns user object directly
                },
            },
        },
        redirect: {
            login: '/auth/auth-login',
            logout: '/auth/auth-login',
            home: '/',
        },
    },
};
