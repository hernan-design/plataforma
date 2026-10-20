import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import commonjs from 'vite-plugin-commonjs';
import path from 'path';

export default defineConfig({
    publicDir: 'public',
    server: {
        host: '127.0.0.1',
        watch: {
            ignored: ['**/public/temp/**']
        }
    },

    define: {
        global: 'window',
        'process.env': {},
        'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV || 'development')
    },

    plugins: [
        // Convierte módulos CommonJS/UMD (misc.js, laroute.js, states.js) a ESM
        commonjs(),

        laravel({
            input: [
                'resources/assets/sass/application.scss',
                'resources/assets/sass/landing.scss',
                'resources/assets/js/components/main.js',
                'resources/assets/js/app-client.js'
            ],
            refresh: true,
        }),

        react({
            include: /\.(jsx|js)$/
        }),
    ],

    esbuild: {
        loader: 'jsx',
        include: /resources\/assets\/js\/.*\.js$/,
        exclude: []
    },

    optimizeDeps: {
        // Forzar a Vite a pre-procesar estos módulos UMD/IIFE problemáticos
        include: [
            'resources/assets/js/helpers/misc.orig.js',
            'resources/assets/js/helpers/laroute.orig.js',
            'resources/assets/js/helpers/states.orig.js',
        ],
        esbuildOptions: {
            loader: {
                '.js': 'jsx',
            },
        },
    },

    resolve: {
        alias: [
            // jQuery/Underscore/Backbone globals
            { find: /^[$]$/, replacement: path.resolve(__dirname, 'resources/assets/js/jquery-global.js') },
            { find: 'jQuery', replacement: path.resolve(__dirname, 'resources/assets/js/jquery-global.js') },
            { find: 'jquery', replacement: path.resolve(__dirname, 'resources/assets/js/jquery-global.js') },
            { find: 'underscore', replacement: path.resolve(__dirname, 'resources/assets/js/underscore-global.js') },
            { find: 'backbone', replacement: path.resolve(__dirname, 'resources/assets/js/backbone-global.js') },
            { find: /^foundation$/, replacement: path.resolve(__dirname, 'resources/assets/libs/foundation/js/foundation.js') },
            { find: /^Materialize$/, replacement: path.resolve(__dirname, 'resources/assets/libs/Materialize/dist/js/materialize.js') },
            { find: 'svg-entry-animator', replacement: path.resolve(__dirname, 'resources/assets/js/helpers/entryShapeAnimator.js') },
            { find: 'select2/dist/js/i18n/es.js', replacement: path.resolve(__dirname, 'resources/assets/js/helpers/select2-es.js') },
            { find: 'select2/dist/js/i18n/es', replacement: path.resolve(__dirname, 'resources/assets/js/helpers/select2-es.js') },

            // Redirect UMD helpers to ESM wrappers (named exports)
            { find: /.*[\\\/]helpers[\\\/]misc(?:\.js)?$/, replacement: path.resolve(__dirname, 'resources/assets/js/helpers/misc.esm.js') },
            { find: /.*[\\\/]helpers[\\\/]states(?:\.js)?$/, replacement: path.resolve(__dirname, 'resources/assets/js/helpers/states.esm.js') },
            { find: /.*[\\\/]helpers[\\\/]laroute(?:\.js)?$/, replacement: path.resolve(__dirname, 'resources/assets/js/helpers/laroute.esm.js') },
            { find: /.*[\\\/]init-app(?:\.js)?$/, replacement: path.resolve(__dirname, 'resources/assets/js/init-app.esm.js') },

            // Fix paths for slick-carousel fonts and ajax loader
            // (la carpeta "slick.js" confunde al dev server de Vite; se usan las copias de /public)
            { find: /.*[\\\/]ajax-loader\.gif$/, replacement: '/img/ajax-loader.gif' },
            { find: /.*[\\\/]fonts[\\\/]slick\.(woff|ttf|eot|svg|woff2)$/, replacement: '/css/fonts/slick.$1' },
        ]
    },


    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern-compiler',
                silenceDeprecations: ['legacy-js-api', 'color-functions', 'slash-div', 'function-units', 'if-function', 'import', 'global-builtin'],
                includePaths: [
                    path.resolve(__dirname, 'resources/assets/libs'),
                    path.resolve(__dirname, 'resources/assets/libs/foundation/scss'),
                    path.resolve(__dirname, 'resources/assets/libs/Materialize/sass'),
                    path.resolve(__dirname, 'resources/assets/libs/font-awesome/scss'),
                    path.resolve(__dirname, 'resources/assets/libs/slick.js/slick'),
                    path.resolve(__dirname, 'node_modules/compass-mixins/lib')
                ],
                loadPaths: [
                    path.resolve(__dirname, 'resources/assets/libs'),
                    path.resolve(__dirname, 'resources/assets/libs/foundation/scss'),
                    path.resolve(__dirname, 'resources/assets/libs/Materialize/sass'),
                    path.resolve(__dirname, 'resources/assets/libs/font-awesome/scss'),
                    path.resolve(__dirname, 'resources/assets/libs/slick.js/slick'),
                    path.resolve(__dirname, 'node_modules/compass-mixins/lib')
                ]
            }
        }
    }
});
