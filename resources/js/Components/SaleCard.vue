<script setup>
import { Link } from '@inertiajs/vue3';

    defineProps({
        title: String,
        desc: String,
    })
</script>
<template>
    <div class="w-4/5 mx-auto p-4 mt-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-900 dark:border-gray-700">
        <h5 class="mb-2 text-3xl font-bold text-blue-500 dark:text-blue-600">{{title}}</h5>
        <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-200 font-semibold">{{ desc }}</p>
        <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
            <Link :href="route('product.index')" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 me-2">
                    <path fill-rule="evenodd" d="M16.5 3.75a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5h-6a1.5 1.5 0 0 1-1.5-1.5V15a.75.75 0 0 0-1.5 0v3.75a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V5.25a3 3 0 0 0-3-3h-6a3 3 0 0 0-3 3V9A.75.75 0 1 0 9 9V5.25a1.5 1.5 0 0 1 1.5-1.5h6Zm-5.03 4.72a.75.75 0 0 0 0 1.06l1.72 1.72H2.25a.75.75 0 0 0 0 1.5h10.94l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 0 0-1.06 0Z" clip-rule="evenodd" />
                </svg>
                <div class="text-left rtl:text-right">
                    <div class="mb-1 text-xs">Go to</div>
                    <div class="-mt-1 font-sans text-sm font-semibold">Product Page</div>
                </div>
            </Link>
        </div>
    </div>
</template>