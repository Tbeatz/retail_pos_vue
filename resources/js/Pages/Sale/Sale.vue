<script setup>
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { watch } from 'vue';
import FadeTransition from '@/Transitions/FadeTransition.vue';
    
    //props
    const props = defineProps({
        categories: Object,
        products: Object,
        search_item: String,
        filter_item: String,
    })

    const search = ref(props.search_item);
    const imageVisible = ref(true);
    const listViewVisible = ref(false);

    //product each action
    const each_product = ref({});
    function product_add(product){
        if (!each_product.value.hasOwnProperty(product.id)) {
            each_product.value[product.id] = {
                quantity: 0,
                name: product.name,
                price: product.price,
                total_price: 0
            };
        }
        each_product.value[product.id].quantity += 1;
        each_product.value[product.id].total_price = each_product.value[product.id].quantity * each_product.value[product.id].price;
    }
    //for total price
    const totalPriceAllProducts = ref(0);
    watch(each_product.value, function(new_v){
        Object.values(new_v).forEach(product => {
            totalPriceAllProducts.value += product.total_price;
        });
    });

    //date
    const currentDate = new Date();
    const day = currentDate.getDate();
    const month = currentDate.toLocaleString('en-MM', { month: 'long' });
    const year = currentDate.getFullYear();
    const formattedDate = ref(`${month} ${day}, ${year}`);
    
    //category
    const selectedCategory = ref(props.filter_item);

    function toggleSelected(category_id) {
        if(selectedCategory.value == category_id){
            selectedCategory.value = '';
        } else {
            selectedCategory.value = category_id;
        }
    }

    //search
    watch([search, selectedCategory], function([new_v, new_f_v]){
        router.get(route('sale.index'), {
            search_item : new_v,
            filter_item : new_f_v,
        }, {
            preserveState: true,
        });
    });

</script>

<template>
    <Head title="Sale" />
    <AuthenticatedLayout>
        <div class="grid grid-cols-5 gap-6">
            <div class="col-span-4">
                <div class="w-full mb-2">
                    <form class="flex flex-row items-center mb-2 mt-1 justify-start gap-2">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-1/3">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" v-model="search" id="unit_search" class="bg-gray-50 shadow-sm dark:shadow-purple-600 shadow-purple-500 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search">
                        </div>
                        <ul class="items-center w-1/4 text-sm font-semibold font-sans bg-blue-500 rounded-lg flex dark:bg-gray-800 dark:border-gray-600 shadow-sm dark:shadow-purple-600 shadow-purple-500">
                            <li class="w-full border-b border-blue-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input id="image_visible" type="checkbox" v-model="imageVisible" class="w-4 h-4 text-purple-600 bg-purple-100 border-purple-300 rounded focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="image_visible" class="w-full py-3 ms-2 text-sm font-medium text-white dark:text-gray-200">Image visible</label>
                                </div>
                            </li>
                            <li class="w-full dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input id="list_view" type="checkbox" v-model="listViewVisible" class="w-4 h-4 text-purple-600 bg-purple-100 border-purple-300 rounded focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="list_view" class="w-full py-3 ms-2 text-sm font-medium text-white dark:text-gray-200">List View</label>
                                </div>
                            </li>
                        </ul>
                    </form>

                    <div class="flex items-center gap-2">
                        <button v-for="category in categories" :key="category.id" 
                                :class="category.id == selectedCategory 
                                        ? 'text-white bg-blue-500 hover:bg-blue-600 dark:hover:bg-blue-700 dark:bg-blue-600'
                                        : 'bg-white border border-gray-200 text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:bg-gray-800'" 
                                class="flex items-center justify-center rounded-lg w-28 h-14 shadow-md dark:shadow-sm shadow-purple-500 dark:shadow-purple-600"
                                @click="toggleSelected(category.id)">
                            <div class="p-2">
                                <h5 class="text-sm font-semibold">{{ category.name }}</h5>
                            </div>
                        </button>
                    </div>
                </div>
                <div class="max-h-screen overflow-y-auto mt-3 w-full">
                    <FadeTransition>
                        <div v-if="!listViewVisible" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <div v-for="product in products" :key="product.id" class="relative bg-white dark:bg-gray-800 shadow-md rounded-lg hover:shadow-lg hover:shadow-purple-600 transform transition-transform duration-300 hover:scale-95 focus:scale-100 focus:ring-purple-500 focus:ring-2">
                                <button @click="product_add(product)" type="button" class='w-full h-auto'>
                                    <img v-if="imageVisible" class="w-full h-36 object-cover" :src="product.image ? 'file/' + product.image : 'style_images/product.png'" alt="Product Image">
                                    <div class="p-4">
                                        <h2 class="text-lg font-semibold text-blue-500 dark:text-blue-600 font-sans mb-2 flex justify-start items-center">
                                            {{ product.name }}
                                        </h2>
                                        <div class="flex items-center justify-start gap-2">
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Product Code</p>
                                            <span class="text-xs font-medium bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white px-2 py-1 rounded-md">
                                                {{ product.product_code }}
                                            </span>
                                        </div>
                                        <!-- <div class="flex items-center justify-start gap-2 mt-2">
                                            <p class="text-sm text-purple-500 dark:text-purple-600">Instock</p>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-500 text-white dark:bg-purple-600 dark:text-white">
                                                {{ product.instock_qty }}
                                            </span>
                                        </div> -->
                                        <div class="mt-4 flex justify-center items-center bg-purple-500 dark:bg-purple-600 rounded-lg">
                                            <span class="text-white p-1 dark:text-gray-100 text-md font-semibold font-sans">{{ product.price }} {{ product.currency_type.name }}</span>
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </FadeTransition>
                    <FadeTransition>
                        <ul v-if="listViewVisible" class="max-w-xl divide-y divide-blue-200 dark:divide-gray-700 mt-5">
                            <li class="pb-3 sm:pb-4 w-full pt-3 flex items-stretch" v-for="product in products" :key="product.id">
                                <button @click="product_add(product)" class="flex flex-row items-center rounded-md justify-end space-x-4 w-full transform transition-transform duration-300 hover:scale-95 focus:scale-100 hover:bg-blue-100 dark:hover:bg-gray-800 focus:bg-blue-100 dark:focus:bg-gray-800 focus:outline-none pt-2 pb-2 px-3">
                                    <img v-if="imageVisible" class="w-14 h-14 rounded-full" :src="product.image ? 'file/' + product.image : 'style_images/product.png'" alt="Product Image">
                                    <div class="flex flex-row items-center flex-grow space-x-4">
                                        <p class="text-sm font-medium text-blue-500 dark:text-blue-600 min-w-[10rem] align-left">
                                            {{ product.name }}
                                        </p>
                                        <div class="flex items-center justify-start gap-2">
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Product Code</p>
                                            <span class="text-xs font-medium bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white px-2 py-1 rounded-md">
                                                {{ product.product_code }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-sm font-semibold text-purple-500 dark:text-purple-600">
                                        {{ product.price }} {{ product.currency_type.name }}
                                    </div>
                                </button>
                            </li>
                        </ul>

                    </FadeTransition>
                </div>
            </div>

            <div class="col-span-1">
                <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <div class="flex justify-between mb-4 items-center gap-3">
                        <h5 class="text-xl font-bold text-gray-900 dark:text-white">Invoice</h5>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">Date: {{ formattedDate }}</p>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 py-4">
                        <div class="flex justify-between mb-2">
                            <p class="font-semibold text-gray-700 dark:text-gray-400">Item</p>
                            <p class="font-semibold text-gray-700 dark:text-gray-400">Price</p>
                        </div>
                        <div class="flex justify-between mb-2" v-for="product in each_product">
                            <p class="text-gray-700 dark:text-gray-400">{{ product.name }} ({{ product.quantity + 'x' }})</p>
                            <p class="text-gray-700 dark:text-gray-400">{{ product.total_price }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between mt-4">
                        <p class="font-semibold text-gray-700 dark:text-gray-400">Total :</p>
                        <p class="font-semibold text-blue-500 dark:text-blue-400">{{totalPriceAllProducts}}</p>
                    </div>
                    <!-- <div class="flex justify-between">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Tax (10%):</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">5 MMK</p>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Discount:</p>
                        <p class="text-sm text-green-500 dark:text-green-400">-10 MMK</p>
                    </div> -->
                    <!-- <div class="flex justify-between mt-2">
                        <p class="font-semibold text-gray-700 dark:text-gray-400">Total:</p>
                        <p class="font-semibold text-blue-500 dark:text-blue-400">45 MMK</p>
                    </div> -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>