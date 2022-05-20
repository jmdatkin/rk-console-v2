require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import NProgress from 'nprogress';
import PrimeVue from 'primevue/config';
import DataTable from 'primevue/datatable';
import ToastService from 'primevue/toastservice';
import Tooltip from 'primevue/tooltip';
import VTooltip from 'v-tooltip'
import ConfirmationService from 'primevue/confirmationservice';
import 'primeicons/primeicons.css';
import 'primeflex/primeflex.css';
import 'primevue/resources/themes/md-light-indigo/theme.css';
import { Inertia } from '@inertiajs/inertia';
import { noopDirectiveTransform } from '@vue/compiler-core';
// import 'primevue/resources/themes/fluent-light/theme.css';
// import 'primevue/resources/themes/arya-green/theme.css';
// import 'primevue/resources/themes/lara-light-indigo/theme.css';


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(PrimeVue)
            .use(ToastService)
            .use(ConfirmationService)
            .use(VTooltip)
            .component('DataTable',DataTable)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });

Inertia.on('start', () => NProgress.start());
Inertia.on('finish', () => NProgress.done());
