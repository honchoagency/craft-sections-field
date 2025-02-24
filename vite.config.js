/** @type {import('vite').UserConfig} */

import { defineConfig } from 'vite'

export default defineConfig({
    base: '/src/resources/',
    build: {
        sourcemap: true,
        assetsDir: './',
        outDir: './src/resources/dist/',
        rollupOptions: {
            input: [
                'src/resources/js/sections-field.js',
            ],
            output: {
                assetFileNames: "[name].css",
                entryFileNames: "[name].js",
                chunkFileNames: "chunks/[name].js",
            },
            preserveEntrySignatures: 'strict',
        },
    },
});
