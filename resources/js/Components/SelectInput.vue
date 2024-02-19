<script setup>
    defineProps({
        require: Boolean,
        id: String,
        value: Array,
        nameProp: String,
    })

    const model = defineModel();
</script>
<template>
    <select
        class="border-gray-300 mt-1 block w-full dark:text-gray-800 text-gray-800 dark:border-gray-700 dark:bg-white focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm font-medium"
        :id="id"
        v-model="model"
        :required="require"
    >
        <option value="" class="dark:text-gray-500 text-gray-500 font-sans text-sm">Select an option...</option>
        <option v-for="v in value" class="dark:text-gray-900 text-gray-800 font-sans text-sm" :value="v.id" :key="v.id">{{ v[nameProp] }}</option>
    </select>
</template>
