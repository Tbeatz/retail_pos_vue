<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        default: '#',
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'text-white border border-transparent bg-blue-500 hover:bg-white hover:text-blue-500 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:border-transparent dark:text-gray-200 dark:hover:text-blue-600 dark:focus:ring-blue-800 dark:hover:bg-white dark:hover:text-blue-600 shadow-md shadow-gray-500 dark:shadow-purple-500 hover:shadow-blue-500 dark:hover:shadow-gray-500'
        : 'text-blue-500 border border-transparent hover:bg-blue-500 hover:text-white focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:border-transparent dark:text-blue-600 dark:hover:text-gray-200 dark:focus:ring-blue-800 dark:hover:bg-blue-600 shadow-md shadow-blue-500 dark:shadow-gray-500 hover:shadow-gray-500 dark:hover:shadow-purple-500'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
