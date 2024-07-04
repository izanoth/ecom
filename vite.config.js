import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/bootstrap.css',
                'resources/js/app.js', // with bootstrap.bundle.js
                'resources/js/axios.js',
                'resources/js/imask.js',
                'resources/j/alpine.js',
                //Adm
                //'resources/js/bootstrap.min.js',
                //'resourses/js/bootstrap.bundle.js',
                //'resources/css/bootstrap.min.css',
                //Adm
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '$': 'jQuery'
        }
    }
});
