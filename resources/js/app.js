require('./bootstrap');

import { createApp, h, provide } from 'vue';
import { App, createInertiaApp, Head } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import NProgress from 'nprogress';
import PrimeVue from 'primevue/config';
import DataTable from 'primevue/datatable';
import Button from 'primevue/button';
import ToastService from 'primevue/toastservice';
import Tooltip from 'primevue/tooltip';
import VTooltip from 'v-tooltip'
import ConfirmationService from 'primevue/confirmationservice';
import 'primeicons/primeicons.css';
import 'primevue/resources/primevue.min.css';
import 'primeflex/primeflex.css';
import { Inertia } from '@inertiajs/inertia';
import AxiosNProgress from './axios-nprogress';
import { noopDirectiveTransform } from '@vue/compiler-core';
import { useToast } from 'primevue/usetoast';
import mitt from 'mitt';
import moment from 'moment-timezone';
// import 'primevue/resources/themes/md-light-indigo/theme.css';
// import 'primevue/resources/themes/mdc-light-indigo/theme.css';
import 'primevue/resources/themes/saga-blue/theme.css';

// import 'primevue/resources/themes/arya-blue/theme.css';
// import 'primevue/resources/themes/vela-blue/theme.css';

// import 'primevue/resources/themes/fluent-light/theme.css';

// import 'primevue/resources/themes/arya-green/theme.css';

// import 'primevue/resources/themes/bootstrap4-light-blue/theme.css';
// import 'primevue/resources/themes/tailwind-light/theme.css';
// import 'primevue/resources/themes/luna-blue/theme.css';
// import 'primevue/resources/themes/lara-light-indigo/theme.css';


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'CCRK Conosle';
const toastBus = mitt();

// moment.tz.setDefault('Etc/UTC');
moment.tz.setDefault('America/New_York');
// moment().utc().utcOffset("-4:00");

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(PrimeVue)
            .use(ToastService)
            .use(ConfirmationService)
            .provide('toastBus', toastBus)
            // .use(VTooltip)
            .directive('tooltip', Tooltip)
            .component('DataTable', DataTable)
            .component('Button', Button)
            .component('Head', Head)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

AxiosNProgress();

InertiaProgress.init({ color: '#4B5563' });

Inertia.on('start', () => NProgress.start());
Inertia.on('finish', () => NProgress.done());


export { toastBus };