<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    }
});

const classes = computed(() =>
    props.active
        ? 'block bg-purple-600 dark:bg-purple-700 w-full px-4 py-2 text-start text-sm leading-5 text-gray-100 dark:text-gray-200 hover:bg-purple-500 dark:hover:bg-purple-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out'
        : 'block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out'
);
</script>

<template>
    <Link
        :href="href" :class="classes"
    >
        <slot />
    </Link>
</template>
