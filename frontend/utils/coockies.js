export function getCookie(name) {
    if (process.client) {
        // Ensure it only runs in the browser
        let value = `; ${document.cookie}`;
        let parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }
    return null;
}
