<script setup>
    defineProps({
        title: String,
        desc: String,
    })
</script>
<template>
    <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-900 dark:border-gray-700">
        <h5 class="mb-2 text-3xl font-bold text-blue-500 dark:text-blue-600">{{title}}</h5>
        <p class="text-base text-gray-500 sm:text-lg dark:text-gray-200 font-semibold">{{ desc }}</p>
    </div>
</template>
