<script setup>
import { inject, ref } from 'vue';
import App from './App';
import MenuBar from 'primevue/menubar';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const showingNavigationDropdown = ref(false);

const items = ref([
    {
        label: 'Dashboard',
        command: () => Inertia.visit('/ndashboard')
    },
    {
        label: 'Resources',
        icon: 'pi pi-fw pi-database',
        items: [
            {
                label: 'Personnel',
                icon: 'pi pi-fw pi-user',
                command: () => Inertia.visit('/datatables/personnel')
            },
            {
                label: 'Recipients',
                icon: 'pi pi-fw pi-box',
                command: () => Inertia.visit('/datatables/recipients')

            },
            {
                label: 'Drivers',
                icon: 'pi pi-fw pi-car',
                command: () => Inertia.visit('/datatables/drivers')
            },
            {
                label: 'Routes',
                icon: 'pi pi-fw pi-map',
                command: () => Inertia.visit('/datatables/routes')
            },
            {
                label: 'Agencies',
                icon: 'pi pi-fw pi-building',
                command: () => Inertia.visit('/datatables/agencies')
            },
            {
                separator: true
            },
            {
                label: 'Export',
                icon: 'pi pi-fw pi-external-link'
            }
        ]
    },
    {
        label: 'Views',
        icon: 'pi pi-fw pi-database',
        items: [
            {
                label: 'Substitutes',
                command: () => Inertia.visit('/exceptions')
            },
            {
                label: 'Route Driver View',
                command: () => Inertia.visit('/routedriver')
            },
        ]
    },
    {
        label: 'Reports',
        icon: 'pi pi-fw pi-file',
        items: [
            {
                label: 'Left',
                icon: 'pi pi-fw pi-align-left'
            },
            {
                label: 'Right',
                icon: 'pi pi-fw pi-align-right'
            },
            {
                label: 'Center',
                icon: 'pi pi-fw pi-align-center'
            },
            {
                label: 'Justify',
                icon: 'pi pi-fw pi-align-justify'
            },
        ]
    }
]);

</script>

<template>
    <App>
        <div>
            <MenuBar :model="items">
                <template #start>
                    <Link :href="route('dashboard')">
                    <BreezeApplicationLogo class="block h-9 w-auto" />
                    </Link>
                </template>
                <template #end>
                </template>
            </MenuBar>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>

    </App>
</template>
