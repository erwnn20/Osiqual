import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import path from 'path';
import fs from 'fs';

function getAllJsFiles(dir) {
    let results = [];
    // const list = ;
    fs.readdirSync(dir)
        .forEach(file => {
            const fullPath = path.join(dir, file);
            const stat = fs.statSync(fullPath);
            if (stat && stat.isDirectory()) {
                results = results.concat(getAllJsFiles(fullPath));
            } else if (fullPath.endsWith('.js')) {
                results.push(fullPath);
            }
        });
    return results;
}

const scriptFiles = getAllJsFiles('resources/js/scripts');

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                ...scriptFiles,
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
