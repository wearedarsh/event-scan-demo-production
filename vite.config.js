import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/frontend/app.css', 
                'resources/css/registration/app.css',
                'resources/css/backend_customer/app.css',
                'resources/css/backend_admin/app.css',
                'resources/js/frontend/app.js',
                'resources/js/backend/app.js'
            ],
            refresh: [
                `resources/views/**/*`
            ],
        }),
        tailwindcss(),
    ],
    server: {
        host: '192.168.1.131',
        port: 5173,
        cors: true,
        watch: {
            usePolling: true,
        },
        hmr: {
            host: '192.168.1.131',
        },
    },
    build: {
        assetsDir: 'assets'
    }
});