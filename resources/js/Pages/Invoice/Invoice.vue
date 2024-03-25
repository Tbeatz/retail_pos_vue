<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import InvoiceCard from '@/Components/InvoiceCard.vue';
import { debounce } from '@/Composables/debounce';

const props = defineProps({
    invoices: Object,
    start_date: Date,
    end_date: Date,
    exists: Boolean,
});
const page = usePage();
const start_date = ref(props.start_date);
const end_date = ref(props.end_date);

//search
watch([start_date, end_date], function([new_start, new_end]){
    router.get(route('invoice.index'), {
        start_date : new_start,
        end_date: new_end,
    }, {
        preserveState: true,
    });
});

</script>
<template>
    <Head title="Invoice" />
    <AuthenticatedLayout>
        <section class="p-3 sm:p-5 w-full">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <InvoiceCard v-if="exists == false"
                    title="Invoice"
                    desc="History of Invoices."
                />
                <div v-else>
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                            <div class="lg:w-1/2 md:w-1/2 sm:w-1/3">
                                <form class="flex items-center gap-3">
                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 start-0 flex items-center justify-center ps-2 pr-2 pointer-events-none text-sm text-gray-900 border border-gray-300 dark:border-gray-600 bg-gray-50 rounded-l-lg dark:bg-gray-700 dark:text-white">
                                            From
                                        </div>
                                        <input type="date" v-model="start_date" class="block w-full ps-14 py-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    </div>
                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 start-0 flex items-center justify-center ps-2 pr-2 pointer-events-none text-sm text-gray-900 border border-gray-300 dark:border-gray-600 bg-gray-50 rounded-l-lg dark:bg-gray-700 dark:text-white">
                                            To
                                        </div>
                                        <input type="date" v-model="end_date" class="block w-full ps-10 py-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                    </div>
                                </form>
                            </div>
                            <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                            </div>
                        </div>
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-white uppercase bg-purple-500 dark:bg-purple-700 dark:text-gray-200">
                                    <tr class="text-center">
                                        <th scope="col" class="px-6 py-3">ID</th>
                                        <th scope="col" class="px-6 py-3">Payment Method</th>
                                        <th scope="col" class="px-6 py-3">Tax Amount</th>
                                        <th scope="col" class="px-6 py-3">Total Amount</th>
                                        <th scope="col" class="px-6 py-3">Received Amount</th>
                                        <th scope="col" class="px-6 py-3">Change</th>
                                        <th scope="col" class="px-6 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(invoice, index) in invoices.data" class="text-center border-b dark:border-gray-700" :key="invoice.id">
                                        <td scope="row" class="px-6 py-3">{{ index + 1 }}</td>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ invoice.transaction.payment_method.name }}</th>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ invoice.transaction.total_tax_amount + ' ' + invoice.business.currency_type.name }}</th>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ invoice.transaction.total_amount + ' ' + invoice.business.currency_type.name }}</th>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ invoice.transaction.received_amount + ' ' + invoice.business.currency_type.name }}</th>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ invoice.transaction.change + ' ' + invoice.business.currency_type.name }}</th>
                                        <td class="px-6 py-3 flex items-center gap-2 justify-center">
                                            <button type="button" @click="router.get(route('invoice.show', invoice.id))" class="text-blue-400 hover:text-blue-800 rounded-lg focus:outline-none dark:text-blue-400 dark:hover:text-blue-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Pagination :items="invoices"/>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
