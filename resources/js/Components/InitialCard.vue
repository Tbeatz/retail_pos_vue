<script setup>
    defineProps({
        title: String,
        desc: String,
    })
</script>
<template>
    <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-900 dark:border-gray-700">
        <h5 class="mb-2 text-3xl font-bold text-blue-500 dark:text-blue-600">{{title}}</h5>
        <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-200 font-semibold">{{ desc }}</p>
        <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
            <button @click="$emit('create_modal_open')" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="me-2 w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <div class="text-left rtl:text-right">
                    <div class="mb-1 text-xs">Create your</div>
                    <div class="-mt-1 font-sans text-sm font-semibold">{{ title }}</div>
                </div>
            </button>
        </div>
    </div>
</template>