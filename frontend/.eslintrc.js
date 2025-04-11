const wp = {
    env: {
        browser: true,
        es6: true,
        node: true,
    },
    extends: ['eslint:recommended', 'plugin:vue/essential', 'plugin:nuxt/recommended', '@vue/prettier'],
    globals: {
        Atomics: 'readonly',
        SharedArrayBuffer: 'readonly',
    },
    parserOptions: {
        ecmaVersion: 2018,
        sourceType: 'module',
    },
    plugins: ['vue'],
    rules: {
        'vue/multi-word-component-names': 'off',
        'no-console': 'off',
        'vue/multiline-html-element-content-newline': [
            2,
            {
                ignoreWhenEmpty: true,
                ignores: ['pre', 'textarea'],
                allowEmptyLines: false,
            },
        ],
    },
};

console.log(wp.rules);

module.exports = wp;
