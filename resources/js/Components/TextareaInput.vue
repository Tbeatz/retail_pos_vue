<script setup>
defineProps({
    id: String,
})

const model = defineModel({
    type: [String, Number],
    required: true,
});

</script>

<template>
    <textarea 
        :id="id"
        v-model="model"
        rows="4" 
        class="text-gray-900 bg-white border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-200 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm font-sans text-sm" placeholder="Type here..."
    />
</template>