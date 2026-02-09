import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        minify: 'terser',
        cssMinify: true,
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['axios'],
                }
            }
        },
        chunkSizeWarningLimit: 1000,
    },
});
