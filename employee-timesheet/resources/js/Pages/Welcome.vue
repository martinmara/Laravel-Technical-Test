<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: { type: String, required: true },
    phpVersion: { type: String, required: true },
});

const { auth } = usePage().props;
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 dark:bg-black min-h-screen flex flex-col justify-center items-center text-center text-black dark:text-white">
       
        <img
            id="background"
            class="absolute inset-0 w-full h-full object-cover opacity-30"
            src="https://laravel.com/assets/img/welcome/background.svg"
            @error="handleImageError"
        />
        
        <div class="relative z-10 flex flex-col items-center px-6 py-12">
           
            <div class="mb-8">
                <svg
                    class="h-20 w-auto text-[#FF2D20]"
                    viewBox="0 0 62 65"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                   
                </svg>
            </div>

          
            <h1 class="text-4xl font-semibold text-gray-800 dark:text-white mb-4">
                Employee Timesheet Web App
            </h1>
            <p class="text-lg text-gray-500 dark:text-white mb-8">
                Log your work hours and manage your timesheets
            </p>

            <nav class="space-x-4">
              
                <template v-if="auth.user">
                    <Link
                        :href="route('dashboard')"
                        class="inline-block px-6 py-3 bg-[#FF2D20] text-white rounded-lg text-lg transition-all hover:bg-[#e73e17] focus:outline-none"
                    >
                        Go to Dashboard
                    </Link>
                </template>
                
                <template v-else>
                    <Link
                        v-if="canLogin"
                        :href="route('login')"
                        class="inline-block px-6 py-3 bg-[#FF2D20] text-white rounded-lg text-lg transition-all hover:bg-[#e73e17] focus:outline-none"
                    >
                        Log in
                    </Link>
                    
                    <template v-if="canRegister">
                        <Link
                            :href="route('register')"
                            class="inline-block px-6 py-3 bg-gray-800 text-white rounded-lg text-lg transition-all hover:bg-gray-700 focus:outline-none"
                        >
                            Register
                        </Link>
                    </template>
                </template>
            </nav>

            <div class="mt-12 text-sm text-gray-500 dark:text-white">
                <p>Laravel Version: <span class="font-medium text-gray-800 dark:text-white">{{ laravelVersion }}</span></p>
                <p>PHP Version: <span class="font-medium text-gray-800 dark:text-white">{{ phpVersion }}</span></p>
            </div>
        </div>
    </div>
</template>
