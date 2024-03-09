<script setup>
import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        items: {
            type: Object,
        }
    })
    console.log(props.items);
</script>
<template>
    <div class="flex mt-4 mb-4" v-if="items.links.length > 1">
        <div v-for="(link, index) in items.links" :key="index">
            <!-- previous -->
            <div v-if="(index == 0) && (link.url == null)"
                class="mr-1 px-4 py-2 text-sm font-medium bg-white rounded text-blue-500 hover:bg-blue-500 hover:text-white shadow-sm shadow-purple-500 dark:bg-gray-800 dark:shadow-sm dark:shadow-gray-500 dark:text-blue-400 dark:hover:text-blue-500 dark:hover:bg-gray-900"
                v-html="link.label"
            />
            <Link v-else-if="(index == 0) && (link.url != null)"
                class="mr-1 px-4 py-2 text-sm font-medium bg-white rounded text-blue-500 hover:bg-blue-500 hover:text-white shadow-sm shadow-purple-500 dark:bg-gray-800 dark:shadow-sm dark:shadow-gray-500 dark:text-blue-400 dark:hover:text-blue-500 dark:hover:bg-gray-900" :href="link.url"
                v-html="link.label"
            />
            <!-- pages -->
            <Link v-else-if="(index != items.links.length - 1) && (index !== 0)"
                :class="link.active
                ? 'mr-1 px-4 py-2 text-sm font-medium bg-blue-500 rounded text-white hover:bg-blue-600 hover:text-white shadow-sm shadow-purple-500 dark:bg-blue-600 dark:shadow-sm dark:shadow-gray-500 dark:text-blue-100 dark:hover:text-blue-100 dark:hover:bg-blue-700'
                : 'mr-1 px-4 py-2 text-sm font-medium bg-white rounded text-blue-500 hover:bg-blue-500 hover:text-white shadow-sm shadow-purple-500 dark:bg-gray-800 dark:shadow-sm dark:shadow-gray-500 dark:text-blue-400 dark:hover:text-blue-500 dark:hover:bg-gray-900'" :href="link.url"
                v-html="link.label"
            />
            <!-- next -->
            <div v-if="(index == items.links.length - 1) && (link.url == null)"
                class="mr-1 px-4 py-2 text-sm font-medium bg-white rounded text-blue-500 hover:bg-blue-500 hover:text-white shadow-sm shadow-purple-500 dark:bg-gray-800 dark:shadow-sm dark:shadow-gray-500 dark:text-blue-400 dark:hover:text-blue-500 dark:hover:bg-gray-900"
                v-html="link.label"
            />
            <Link v-else-if="(index == items.links.length - 1) && (link.url != null)"
                class="mr-1 px-4 py-2 text-sm font-medium bg-white rounded text-blue-500 hover:bg-blue-500 hover:text-white shadow-sm shadow-purple-500 dark:bg-gray-800 dark:shadow-sm dark:shadow-gray-500 dark:text-blue-400 dark:hover:text-blue-500 dark:hover:bg-gray-900" :href="link.url"
                v-html="link.label"
            />
        </div>
        <div>{{ items.per_page }}</div>
        <div>{{ items.total }}</div>
    </div>
</template>
