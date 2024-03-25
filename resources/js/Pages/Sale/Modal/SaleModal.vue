<script setup>
import { ref } from 'vue';

    const props = defineProps({
        state: String,
        tax_types: Object,
        discount_types: Object,
        tax_array: Array,
        discount_array: Array,
    })

    const emit = defineEmits(['modal_close', 'tax_discount_select']);

</script>
<template>
    <div id="sale_modal" tabindex="-1" aria-hidden="true" class="flex bg-black bg-opacity-50 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full inset-0 h-full">
        <div class="relative p-4 w-full max-w-md h-1/2">
            <div class="relative bg-white rounded-lg dark:bg-gray-800 h-full overflow-hidden border-2 dark:border-purple-600 border-purple-500">
                <div class="flex items-center justify-between p-4 md:p-4 border-b rounded-t dark:border-gray-900 bg-purple-500 dark:bg-purple-600">
                    <h3 class="text-lg font-semibold text-white dark:text-gray-200">
                        {{state == 'tax' ? 'Tax Types' : 'Discount Types'}}
                    </h3>
                    <button type="button" @click="$emit('modal_close')" class="text-gray-200 bg-transparent hover:bg-purple-600 hover:text-gray-100 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-purple-700 dark:hover:text-gray-100" data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="h-full overflow-auto">
                    <ul v-if="state == 'tax'" class="max-w-xl divide-y divide-blue-200 dark:divide-gray-700">
                        <li class="pb-3 w-full pt-3" v-for="tax in tax_types" :key="tax.id">
                            <button @click="$emit('tax_discount_select', tax)"
                                :class="tax_array.some((item) => item.id == tax.id) ? 'bg-purple-100 dark:bg-purple-900 hover:bg-purple-200 dark:hover:bg-purple-800 text-blue-500 dark:text-gray-300' : 'hover:bg-blue-100 dark:hover:bg-blue-900 text-blue-500 dark:text-blue-600'"
                                class="flex flex-row items-center rounded-md justify-between px-14 w-full transform transition-transform duration-300 hover:scale-95 focus:scale-100 pt-2 pb-2">
                                    <p class="text-sm font-medium">
                                        {{ tax.name }}
                                    </p>
                                    <div class="flex items-center justify-start gap-2">
                                        <p class="text-xs text-gray-600 dark:text-gray-400">Rate</p>
                                        <span class="text-xs font-medium bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white px-2 py-1 rounded-md">
                                            {{ tax.tax_rate }} %
                                        </span>
                                    </div>
                            </button>
                        </li>
                    </ul>
                    <ul v-else class="w-full divide-y divide-blue-200 dark:divide-gray-700">
                        <li class="pb-3 w-full pt-3 flex items-stretch" v-for="discount in discount_types" :key="discount.id">
                            <button @click="$emit('tax_discount_select', discount)"
                                :class="discount_array.some((item) => item.id == discount.id) ? 'bg-purple-100 dark:bg-purple-900 hover:bg-purple-200 dark:hover:bg-purple-800 text-blue-500 dark:text-gray-300' : 'hover:bg-blue-100 dark:hover:bg-blue-900 text-blue-500 dark:text-blue-600'"
                                class="flex flex-row items-center rounded-md justify-between px-14 w-full transform transition-transform duration-300 hover:scale-95 focus:scale-100 pt-2 pb-2">
                                    <p class="text-sm font-medium">
                                        {{ discount.name }}
                                    </p>
                                    <div class="flex items-center justify-start gap-2">
                                        <p class="text-xs text-gray-600 dark:text-gray-300">Rate</p>
                                        <span class="text-xs font-medium bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white px-2 py-1 rounded-md">
                                            {{ discount.discount_rate }} %
                                        </span>
                                    </div>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
