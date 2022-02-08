require('./bootstrap');

import { createApp } from 'vue';
import MainApp from './vue/components/MainApp.vue';

const app = createApp({
    components: {
        'main-app': MainApp
    },
});
app.mount('#app');