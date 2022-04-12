<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Column from 'primevue/column';
import { ref } from 'vue';

const sampleData = ref({
    code: 'ABC',
    name: 'ABC2',
    category: 'ABC4',
    quantity: 10
});

</script>

<template>
    <BreezeAuthenticatedLayout>
        <div
            class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-sm text-gray-700 underline">
                Dashboard
                </Link>

                <template v-else>
                    <Link :href="route('login')" class="text-sm text-gray-700 underline">
                    Log in
                    </Link>

                    <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Register
                    </Link>
                </template>
            </div>

            <DataTable :value="sampleData">
                <Column field="code" header="Code"></Column>
                <Column field="name" header="Name"></Column>
                <Column field="category" header="Category"></Column>
                <Column field="quantity" header="Quantity"></Column>

            </DataTable>

        </div>
    </BreezeAuthenticatedLayout>
</template>