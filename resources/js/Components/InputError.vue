<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-if="message">
        <p class="text-sm text-red-600 dark:text-red-400 font-medium">
            > {{ message }}
        </p>
    </div>
</template>
