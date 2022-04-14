require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import PrimeVue from 'primevue/config';
import DataTable from 'primevue/datatable';
import 'primeicons/primeicons.css';
import 'primevue/resources/themes/md-light-indigo/theme.css';
// import 'primevue/resources/themes/fluent-light/theme.css';
// import 'primevue/resources/themes/lara-light-indigo/theme.css';


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(PrimeVue)
            .component('DataTable',DataTable)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
