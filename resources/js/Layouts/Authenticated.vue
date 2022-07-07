<script setup>
import { inject, ref } from 'vue';
import App from './App';
import MenuBar from 'primevue/menubar';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import Button from 'primevue/button';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Header from '../Components/Header.vue';

const showingNavigationDropdown = ref(false);

const items = ref([
    {
        label: 'Dashboard',
        command: () => Inertia.visit(route('dashboard'))
    },
    {
        label: 'Resources',
        icon: 'pi pi-fw pi-database',
        items: [
            {
                label: 'Personnel',
                icon: 'pi pi-fw pi-user',
                command: () => Inertia.visit(route('datatables.personnel'))
            },
            {
                label: 'Recipients',
                icon: 'pi pi-fw pi-box',
                command: () => Inertia.visit(route('datatables.recipients'))

            },
            {
                label: 'Drivers',
                icon: 'pi pi-fw pi-car',
                command: () => Inertia.visit(route('datatables.drivers'))
            },
            {
                label: 'Routes',
                icon: 'pi pi-fw pi-map',
                command: () => Inertia.visit(route('datatables.routes'))
            },
            {
                label: 'Agencies',
                icon: 'pi pi-fw pi-building',
                command: () => Inertia.visit(route('datatables.agencies'))
            }
        ]
    },
    {
        label: 'Views',
        icon: 'pi pi-fw pi-database',
        items: [
            {
                label: 'Recipients by Route',
                command: () => Inertia.visit(route('recipientsbyroute'))
            },
            {
                label: 'Drivers by Route',
                command: () => Inertia.visit(route('driversbyroute'))
            },
            {
                label: 'Schedule Exceptions',
                command: () => Inertia.visit(route('exception.index'))
            },
        ]
    },
    // {
    //     label: 'Reports',
    //     icon: 'pi pi-fw pi-file',
    //     items: [
    //         {
    //             label: 'Driver Report',
    //             icon: 'pi pi-fw pi-align-file',
    //             command: () => Inertia.visit('/reports/driver')
    //         },
    //         {
    //             label: 'Texter Report',
    //             icon: 'pi pi-fw pi-align-file',
    //             command: () => Inertia.visit('/reports/texter')
    //         },
    //         {
    //             label: 'Meal Report',
    //             icon: 'pi pi-fw pi-align-file',
    //             command: () => Inertia.visit('/reports/meals')
    //         },
    //     ]
    // }
]);

</script>

<template>
    <App>
        <div class="app-wrapper">
            <Header>
                <MenuBar class="mb-2" :model="items">
                    <template #start>
                        <Link :href="route('dashboard')">
                        <BreezeApplicationLogo class="block h-9 w-auto" />
                        </Link>
                    </template>
                    <template #end>
                        <Button label="Profile" icon="pi pi-user" class="p-button-text p-button-plain"
                            @click="() => Inertia.get(route('profile'))"></Button>
                        <Button label="Log Out" class="p-button-text p-button-plain"
                            @click="() => Inertia.post(route('logout'))"></Button>
                        <!-- <Link :href="route('profile')" method="get" as="button">
                    <i class="pi pi-user"></i>
                        Profile
                    </Link>
                    <Link :href="route('logout')" method="post" as="button">
                        Log Out
                    </Link> -->
                    </template>
                </MenuBar>

            </Header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>

    </App>
</template>

<style lang="scss">
.app-wrapper {
    // padding: 10px;
}

.p-menubar {
    border: 0;
}
</style>