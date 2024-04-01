<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

    const props = defineProps({
        invoice: Object,
    })

    //date
    const invoiceDate = new Date(props.invoice.created_at);
    const day = (invoiceDate).getDate();
    const month = (invoiceDate).toLocaleString('en-MM', { month: 'long' });
    const year = (invoiceDate).getFullYear();
    const formattedDate = ref(`${month} ${day}, ${year}`);

    function print(){
        const printableContent = document.getElementById('printable-content').innerHTML;
        const originalContent = document.body.innerHTML;
        document.body.innerHTML = printableContent;
        window.print();
        document.body.innerHTML = originalContent;
    }

</script>
<template>
    <Head title="Invoice Show" />
    <AuthenticatedLayout>
        <div id="printable-content" class="block max-w-sm p-7 bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:hover:shadow-blue-600 mt-1">
            <div class="flex justify-between mb-4 items-center gap-3">
                <h5 class="text-lg font-bold text-blue-500 dark:text-blue-600">Invoice</h5>
                <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">Date: {{ formattedDate }}</p>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 mb-3">
                <div class="flex justify-between p-1">
                    <p class="font-semibold text-purple-500 dark:text-purple-600">Item</p>
                    <p class="font-semibold text-purple-500 dark:text-purple-600">Price</p>
                </div>
                <button class="flex justify-between hover:bg-blue-100 dark:hover:bg-blue-900 w-full p-1 rounded-lg" v-for="sale in invoice.transaction.sales">
                    <p class="text-gray-600 dark:text-gray-400 font-medium">{{ sale.product_name }} ({{ sale.quantity + 'x' }})</p>
                    <p class="text-blue-500 dark:text-blue-600 font-medium">{{ sale.total_price }}</p>
                </button>
            </div>
            <div>
                <div class="flex justify-between p-1">
                    <p class="text-sm text-red-500 dark:text-red-400 font-semibold">Tax ({{invoice.business.tax_type.tax_rate}})% :</p>
                    <p class="text-sm text-red-500 dark:text-red-400 font-semibold">+ {{ invoice.transaction.total_tax_amount }}</p>
                </div>
            </div>
            <div class="flex justify-between p-1 mt-3">
                <p class="font-semibold text-sm text-purple-500 dark:text-purple-600">Sub Total :</p>
                <p class="font-semibold text-sm text-blue-500 dark:text-blue-600">{{Number((invoice.transaction.total_amount - invoice.transaction.total_tax_amount).toFixed(2))}} {{ invoice.business.currency_type.name }}</p>
            </div>
            <div class="flex justify-between p-1">
                <p class="font-semibold text-purple-500 dark:text-purple-600">Total:</p>
                <p class="font-semibold text-blue-500 dark:text-blue-400">{{invoice.transaction.total_amount}} {{ invoice.business.currency_type.name }}</p>
            </div>
            <div class="flex justify-between mt-6 p-1">
                <button @click="router.get(route('invoice.index'))" class="rounded-lg px-4 py-2 bg-red-500 text-sm font-semibold font-sans text-white dark:text-gray-300 dark:bg-red-600 hover:bg-red-600 dark:hover:bg-red-700 flex items-center justify-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                    </svg>
                    Back
                </button>
                <button @click="print" class="rounded-lg px-4 py-2 bg-blue-500 text-sm font-semibold font-sans text-white dark:text-gray-300 dark:bg-blue-600 hover:bg-blue-600 dark:hover:bg-blue-700 flex items-center justify-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z" clip-rule="evenodd" />
                    </svg>
                    Print
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
