import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss', // If using Sass
                'resources/js/app.js', // Your main JS file
                'resources/js/script.js', // Additional JS file
                'resources/css/styles.css', // Your CSS file
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        },
    },
    build: {
        manifest: true, // Ensures that assets are versioned for caching
    },
});
