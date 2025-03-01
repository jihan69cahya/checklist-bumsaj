import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vercel from "vite-plugin-vercel";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vercel(),
    ],
    server: {
        https: true,
    },
});
