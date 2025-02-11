<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Timesheets from '../Components/Timesheet.vue';  
import AdminTimesheet from '../Components/AdminTimesheet.vue';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';


const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="container mx-auto">
            <div v-if="user.role_id === 2" class="py-8">
                <timesheets></timesheets>  
            </div>
            <div v-if="user.role_id === 1" class="py-8">
                <admin-timesheet></admin-timesheet>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
