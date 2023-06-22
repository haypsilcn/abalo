import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        vue(
            {
                template: {
                    compilerOptions: {
                        isCustomElement: (tag) => {
                            return tag.includes("vue-dock-menu") // (return true)
                        }
                    }
                }
            }
        ),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
