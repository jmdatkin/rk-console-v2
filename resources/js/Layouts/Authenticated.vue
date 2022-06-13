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
            }
        ]
    },
    {
        label: 'Views',
        icon: 'pi pi-fw pi-database',
        items: [
            {
                label: 'Recipients by Route',
                command: () => Inertia.visit('/routerecipients')
            },
            {
                label: 'Schedule Exceptions',
                command: () => Inertia.visit('/exceptions')
            },
            {
                label: 'Assign Substitutes',
                command: () => Inertia.visit('/routedriver')
            },
        ]
    },
    {
        label: 'Reports',
        icon: 'pi pi-fw pi-file',
        items: [
            {
                label: 'Driver Report',
                icon: 'pi pi-fw pi-align-file',
                command: () => Inertia.visit('/reports/driver')
            },
            {
                label: 'Texter Report',
                icon: 'pi pi-fw pi-align-file',
                command: () => Inertia.visit('/reports/texter')
            },
            {
                label: 'Meal Report',
                icon: 'pi pi-fw pi-align-file',
                command: () => Inertia.visit('/reports/meals')
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
                    <Link :href="route('profile')" method="get" as="button">
                    <i class="pi pi-user"></i>
                        Profile
                    </Link>
                    <Link :href="route('logout')" method="post" as="button">
                        Log Out
                    </Link>
                </template>
            </MenuBar>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>

    </App>
</template>
