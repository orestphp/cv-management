export default function ({ $axios, redirect, $auth }) {
    $axios.defaults.withCredentials = true;

    // if (process.client) {
    //     $axios.onRequest((config) => {
    //         document.cookie.split('; ').forEach((cookie) => {
    //             if (cookie.startsWith('XSRF-TOKEN=')) {
    //                 config.headers['X-XSRF-TOKEN'] = decodeURIComponent(cookie.split('=')[1]);
    //             }
    //         });
    //     });
    // }

    $axios.onError((error) => {
        const code = parseInt(error.response && error.response.status);
        if (code === 401) {
            $auth.logout();
            redirect('/auth/auth-login');
        }
    });
}
