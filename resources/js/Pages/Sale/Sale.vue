<script setup>
import { Head, router, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, watch, computed } from 'vue';
import FadeTransition from '@/Transitions/FadeTransition.vue';
import TextInput from '@/Components/TextInput.vue';
import ModalTransition from '@/Transitions/ModalTransition.vue';
import SaleCard from '@/Components/SaleCard.vue';
import ChargeModal from './Modal/ChargeModal.vue';
import AlertTransition from '@/Transitions/AlertTransition.vue';

    //props
    const props = defineProps({
        categories: Object,
        products: Object,
        // tax_types: Object,
        // discount_types: Object,
        tax_rate: Number,
        search_item: String,
        filter_item: String,
        currency_type: String,
        exists: Boolean,
        payment_methods: Object,
    })

    const search = ref(props.search_item);
    const imageVisible = ref(true);
    const listViewVisible = ref(false);
    const invoiceProductSelect = ref(false);
    const charge_modal = ref(false);
    const transaction_id = ref(null);
    // const isTax = ref(false);
    // const isDiscount = ref(false);
    // const tax_array = ref([]);
    // const discount_array = ref([]);

    const page = usePage();

    //product each action
    const each_product = ref({});
    function product_add(product){
        if (!each_product.value.hasOwnProperty(product.id)) {
            each_product.value[product.id] = {
                id: product.id,
                quantity: 0,
                name: product.name,
                price: (product.discount_price != 0 && product.discount_price != null) ? (product.price - product.discount_price) : product.price,
                total_price: 0,
            };
        }
        each_product.value[product.id].quantity += 1;
        each_product.value[product.id].total_price = each_product.value[product.id].quantity * each_product.value[product.id].price;
    }
    //for total price
    const totalPriceAllProducts = computed(() => {
        let total = 0;
        Object.values(each_product.value).forEach(product => {
            total = Number((total + (product.total_price * product.quantity)).toFixed(2));
        });
        return total;
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
        if (category_id == 'all') {
            selectedCategory.value = null
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

    //product quantity manage
    const _each_product_quantity = ref(0);
    const invoice_each_product_id = ref(null);
    function each_product_quantity(product){
        invoiceProductSelect.value = true;
        _each_product_quantity.value = product.quantity;
        invoice_each_product_id.value = product.id;
    }

    watch(each_product.value, (new_v) => {
        invoice_each_product_id.value ? _each_product_quantity.value = new_v[invoice_each_product_id.value].quantity : '';
    })

    function increment(){
        _each_product_quantity.value++;
        each_product.value[invoice_each_product_id.value].quantity = _each_product_quantity.value;
        each_product.value[invoice_each_product_id.value].total_price = each_product.value[invoice_each_product_id.value].quantity * each_product.value[invoice_each_product_id.value].price;
    }

    function decrement(){
        _each_product_quantity.value--
        if (_each_product_quantity.value == 0) {
            delete each_product.value[invoice_each_product_id.value];
            invoice_each_product_id.value = null;
            invoiceProductSelect.value = false;
        } else {
            each_product.value[invoice_each_product_id.value].quantity = _each_product_quantity.value;
            each_product.value[invoice_each_product_id.value].total_price = each_product.value[invoice_each_product_id.value].quantity * each_product.value[invoice_each_product_id.value].price;
        }
    }

    function removeInvoiceProduct(){
        _each_product_quantity.value = 0;
        delete each_product.value[invoice_each_product_id.value];
        invoice_each_product_id.value = null;
        invoiceProductSelect.value = false;
    }

    //modal
    // const sale_modal = ref(false);
    // const state = ref('');
    // function openSaleModal(v){
    //     state.value = v;
    //     sale_modal.value = true;
    // }

    // function modal_close(){
    //     sale_modal.value = false;
    // }

    // //tax discount management
    // const total_tax_price = computed(() => {
    //     let taxTotal = 0;
    //     tax_array.value.forEach(item => {
    //         const taxPrice = Number((totalPriceAllProducts.value * (item.tax_rate / 100)).toFixed(2));
    //         taxTotal = Number((taxTotal + taxPrice).toFixed(2));
    //     });
    //     return taxTotal;
    // });

    // const total_discount_price = computed(() => {
    //     let discountTotal = 0;
    //     discount_array.value.forEach(item => {
    //         const discountPrice = Number((totalPriceAllProducts.value * (item.discount_rate / 100)).toFixed(2));
    //         discountTotal = Number((discountTotal + discountPrice).toFixed(2));
    //     });
    //     return discountTotal;
    // })

    // const full_total_price = computed(() => {
    //     let total = 0;
    //     total = Number(((totalPriceAllProducts.value + total_tax_price.value) - total_discount_price.value).toFixed(2));
    //     return total;
    // });

    // function tax_discount_select(v){
    //     if(state.value == 'tax'){
    //         if (!tax_array.value.some((item) => item.id == v.id)) {
    //             tax_array.value.push({ id: v.id, tax_rate: v.tax_rate, name: v.name });
    //         } else {
    //             tax_array.value = tax_array.value.filter((item) => item.id != v.id);
    //         }
    //     } else {
    //         if (!discount_array.value.some((item) => item.id == v.id)) {
    //             discount_array.value.push({ id: v.id, discount_rate: v.discount_rate, name: v.name });
    //         } else {
    //             discount_array.value = discount_array.value.filter((item) => item.id != v.id);
    //         }
    //     }
    // }

    // watch(each_product.value, (new_v) => {
    //     if(Object.keys(new_v).length == 0){
    //         isTax.value = false;
    //         isDiscount.value = false;
    //         discount_array.value = [];
    //         tax_array.value = [];
    //     }
    // })

    const total_tax_price = computed(() => {
        const taxPrice = Number((totalPriceAllProducts.value * (props.tax_rate / 100)).toFixed(2));
        return taxPrice;
    });

    const full_total_price = computed(() => {
        let total = 0;
        total = Number((totalPriceAllProducts.value + total_tax_price.value).toFixed(2));
        return total;
    });

    //modal
    function modal_close(){
        charge_modal.value = false;
    }

    function sale_add(){
        router.post(route('sale.store'), {
            data: each_product.value,
        }, {
            onSuccess: () => {
                transaction_id.value = page.props.flash.transaction_id;
                charge_modal.value = true;
            }
        })
    }

    //reset
    function reset_state(){
        each_product.value = {};
    }

</script>

<template>
    <Head title="Sale" />
    <AuthenticatedLayout>
        <AlertTransition>
            <div v-if="$page.props.flash.message" class="fixed top-12 right-4 z-50">
                <div class="p-3 text-sm text-blue-900 rounded-lg bg-white shadow-md shadow-blue-500 dark:bg-gray-900 dark:text-white" role="alert">
                    <span class="font-sans font-semibold">{{ $page.props.flash.message }}</span>
                </div>
            </div>
        </AlertTransition>
        <SaleCard v-if="exists == false"
            title="Sales"
            desc="Please add some products first."
        />
        <div v-else class="grid grid-cols-5 gap-6 w-full">
            <div class="col-span-4">
                <div class="w-full mb-2">
                    <form class="flex flex-row items-center mb-2 mt-1 justify-start gap-2 w-full">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-1/3">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" v-model="search" id="unit_search" class="bg-gray-50 shadow-sm dark:shadow-purple-600 shadow-purple-500 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search">
                        </div>
                        <ul class="items-center w-1/3 text-sm font-semibold font-sans bg-blue-500 rounded-lg flex dark:bg-gray-800 dark:border-gray-600 shadow-sm dark:shadow-purple-600 shadow-purple-500">
                            <li class="w-full border-r border-blue-200 dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input id="image_visible" type="checkbox" v-model="imageVisible" class="w-4 h-4 text-purple-600 bg-purple-100 border-purple-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="image_visible" class="w-full py-3 ms-2 text-sm font-medium text-white dark:text-gray-200">Image visible</label>
                                </div>
                            </li>
                            <li class="w-full">
                                <div class="flex items-center ps-3">
                                    <input id="list_view" type="checkbox" v-model="listViewVisible" class="w-4 h-4 text-purple-600 bg-purple-100 border-purple-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="list_view" class="w-full py-3 ms-2 text-sm font-medium text-white dark:text-gray-200">List View</label>
                                </div>
                            </li>
                        </ul>
                        <!-- <div class="flex items-center gap-3 w-1/3">
                            <FadeTransition>
                                <button v-if="isTax" @click="openSaleModal('tax')" type="button" class="flex items-center justify-center text-white bg-purple-500 hover:bg-purple-600 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-1">
                                        <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM12.75 12a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V18a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V12Z" clip-rule="evenodd" />
                                        <path d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                                    </svg>
                                    Taxes ({{ tax_array.length }})
                                </button>
                            </FadeTransition>
                            <FadeTransition>
                                <button v-if="isDiscount" @click="openSaleModal('discount')" type="button" class="flex items-center justify-center text-white bg-purple-500 hover:bg-purple-600 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-1">
                                        <path d="M9.375 3a1.875 1.875 0 0 0 0 3.75h1.875v4.5H3.375A1.875 1.875 0 0 1 1.5 9.375v-.75c0-1.036.84-1.875 1.875-1.875h3.193A3.375 3.375 0 0 1 12 2.753a3.375 3.375 0 0 1 5.432 3.997h3.943c1.035 0 1.875.84 1.875 1.875v.75c0 1.036-.84 1.875-1.875 1.875H12.75v-4.5h1.875a1.875 1.875 0 1 0-1.875-1.875V6.75h-1.5V4.875C11.25 3.839 10.41 3 9.375 3ZM11.25 12.75H3v6.75a2.25 2.25 0 0 0 2.25 2.25h6v-9ZM12.75 12.75v9h6.75a2.25 2.25 0 0 0 2.25-2.25v-6.75h-9Z" />
                                    </svg>
                                    Discounts ({{ discount_array.length }})
                                </button>
                            </FadeTransition>
                        </div> -->
                    </form>
                    <div class="flex items-center overflow-hidden overflow-x-auto">
                        <div class="flex flex-shrink-0 min-w-0 gap-2 mb-4 mt-4">
                            <button :class="selectedCategory == null
                                            ? 'text-white bg-blue-500 hover:bg-blue-600 dark:hover:bg-blue-700 dark:bg-blue-600'
                                            : 'bg-white border border-gray-200 text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:bg-gray-800'"
                                    class="flex items-center justify-center rounded-lg w-28 h-14 shadow-md dark:shadow-sm shadow-purple-500 dark:shadow-purple-600"
                                    @click="toggleSelected('all')">
                                <div class="p-2">
                                    <h5 class="text-sm font-semibold">All</h5>
                                </div>
                            </button>
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
                </div>
                <div class="max-h-[500px] overflow-y-auto mt-3 w-full">
                    <div v-if="!listViewVisible" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mr-2.5">
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
                                        <span class="text-white p-1 dark:text-gray-100 text-md font-semibold font-sans">
                                            <div v-if="product.discount_price != 0 && product.discount_price != null" class="flex items-center gap-2 justify-center">
                                                <span class="line-through">{{ product.price }} {{ product.business.currency_type.name }}</span>
                                                <span>{{ product.price - product.discount_price }} {{ product.business.currency_type.name }}</span>
                                            </div>
                                            <span v-else>{{ product.price }} {{ product.business.currency_type.name }}</span>
                                        </span>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                    <ul v-else class="max-w-2xl divide-y divide-blue-200 dark:divide-gray-700 mt-5">
                        <li class="pb-3 sm:pb-4 w-full pt-3 flex items-stretch" v-for="product in products" :key="product.id">
                            <button @click="product_add(product)" class="flex flex-row items-center rounded-md justify-start gap-10 w-full transform transition-transform duration-300 hover:scale-95 focus:scale-100 hover:bg-blue-100 dark:hover:bg-gray-800 focus:bg-blue-100 dark:focus:bg-gray-800 focus:outline-none pt-2 pb-2 px-3">
                                <img v-if="imageVisible" class="w-14 h-14 rounded-full" :src="product.image ? 'file/' + product.image : 'style_images/product.png'" alt="Product Image">
                                <div class="flex flex-row items-center justify-center gap-10">
                                    <p class="text-sm font-medium text-blue-500 dark:text-blue-600">
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
                                    <div v-if="product.discount_price != 0 && product.discount_price != null" class="flex items-center gap-2 justify-center">
                                        <span class="line-through">{{ product.price }} {{ product.business.currency_type.name }}</span>
                                        <span>{{ product.price - product.discount_price }} {{ product.business.currency_type.name }}</span>
                                    </div>
                                    <span v-else>{{ product.price }} {{ product.business.currency_type.name }}</span>
                                </div>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-span-1">
                <!-- <ul class="items-center w-full mb-2 text-sm font-semibold font-sans bg-blue-500 rounded-lg flex dark:bg-gray-800 dark:border-gray-600 shadow-sm dark:shadow-purple-600 shadow-purple-500">
                    <li class="w-full border-r border-blue-200 dark:border-gray-600">
                        <div class="relative flex items-center ps-3 group">
                            <input id="tax" type="checkbox" v-model="isTax" :disabled="Object.keys(each_product).length == 0" class="w-4 h-4 text-purple-600 bg-purple-100 border-purple-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="tax" class="w-full py-3 ms-2 text-sm font-medium text-white dark:text-gray-200">Tax Rate</label>
                            <div class="absolute top-0 left-0 mt-10 bg-purple-500 dark:bg-purple-600 text-white px-2 py-1 rounded text-xs opacity-0 pointer-events-none transition-opacity duration-300" :class="{'group-hover:opacity-100' : Object.keys(each_product).length == 0}">
                                Select product first
                            </div>
                        </div>
                    </li>
                    <li class="w-full">
                        <div class="relative flex items-center ps-3 group">
                            <input id="discount" type="checkbox" v-model="isDiscount" :disabled="Object.keys(each_product).length == 0" class="w-4 h-4 text-purple-600 bg-purple-100 border-purple-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="discount" class="w-full py-3 ms-2 text-sm font-medium text-white dark:text-gray-200">Discount</label>
                            <div class="absolute top-0 left-0 mt-10 bg-purple-500 dark:bg-purple-600 text-white px-2 py-1 rounded text-xs opacity-0 pointer-events-none transition-opacity duration-300" :class="{'group-hover:opacity-100' : Object.keys(each_product).length == 0}">
                                Select product first
                            </div>
                        </div>
                    </li>
                </ul> -->
                <div class="block max-w-sm p-7 bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:hover:shadow-blue-600">
                    <div class="flex justify-between mb-4 items-center gap-3">
                        <h5 class="text-lg font-bold text-blue-500 dark:text-blue-600">Invoice</h5>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">Date: {{ formattedDate }}</p>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 mb-3">
                        <div class="flex justify-between p-1">
                            <p class="font-semibold text-purple-500 dark:text-purple-600">Item</p>
                            <p class="font-semibold text-purple-500 dark:text-purple-600">Price</p>
                        </div>
                        <button class="flex justify-between hover:bg-blue-100 dark:hover:bg-blue-900 w-full p-1 rounded-lg" :class="{'bg-blue-100 dark:bg-blue-900' : ((invoice_each_product_id == product.id) && invoiceProductSelect)}" v-for="product in each_product" @click="each_product_quantity(product)">
                            <p class="text-gray-600 dark:text-gray-400 font-medium">{{ product.name }} ({{ product.quantity + 'x' }})</p>
                            <p class="text-blue-500 dark:text-blue-600 font-medium">{{ product.total_price }}</p>
                        </button>
                    </div>
                    <div>
                        <!-- <div class="mb-1">
                            <label class="text-xs font-semibold text-white rounded-full bg-red-500 dark:bg-red-600 dark:text-gray-300 px-2 py-1">Tax</label>
                        </div> -->
                        <div class="flex justify-between p-1">
                            <p class="text-sm text-red-500 dark:text-red-400 font-semibold">Tax ({{tax_rate}})% :</p>
                            <p class="text-sm text-red-500 dark:text-red-400 font-semibold">+ {{ total_tax_price }}</p>
                        </div>
                    </div>
                    <!-- <div v-if="discount_array.length > 0" class="mt-3">
                        <div class="mb-1">
                            <label class="text-xs font-semibold text-white rounded-full bg-green-500 dark:bg-green-600 dark:text-gray-300 px-2 py-1">Discount</label>
                        </div>
                        <div class="flex justify-between p-1" v-for="discount in discount_array">
                            <p class="text-sm text-green-500 dark:text-green-400 font-semibold">{{discount.name}} ({{discount.discount_rate}}%):</p>
                            <p class="text-sm text-green-500 dark:text-green-400 font-semibold">- {{ Number((totalPriceAllProducts * (discount.discount_rate / 100)).toFixed(2)) }}</p>
                        </div>
                    </div> -->
                    <div class="flex justify-between p-1 mt-3">
                        <p class="font-semibold text-sm text-purple-500 dark:text-purple-600">Sub Total :</p>
                        <p class="font-semibold text-sm text-blue-500 dark:text-blue-600">{{totalPriceAllProducts}} {{ currency_type }}</p>
                    </div>
                    <div class="flex justify-between p-1">
                        <p class="font-semibold text-purple-500 dark:text-purple-600">Total:</p>
                        <p class="font-semibold text-blue-500 dark:text-blue-400">{{full_total_price}} {{ currency_type }}</p>
                    </div>
                </div>
                <FadeTransition>
                    <div v-if="Object.keys(each_product).length > 0" class="mt-3">
                        <button @click="sale_add()" type="button" class="rounded-lg p-2 bg-blue-500 text-sm font-semibold font-sans text-white dark:text-gray-300 dark:bg-blue-600 hover:bg-blue-600 dark:hover:bg-blue-700 shadow-sm shadow-purple-500 w-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>
                            <p>Payment</p>
                        </button>
                    </div>
                </FadeTransition>
                <FadeTransition>
                    <div v-if="invoiceProductSelect && _each_product_quantity > 0" class="flex items-center justify-center mt-2">
                        <button @click="decrement()" class="bg-purple-500 text-white dark:bg-purple-600 dark:text-gray-200 px-4 py-2 rounded-md mr-1 hover:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none text-sm mt-1">
                            -
                        </button>
                        <TextInput
                            type="number"
                            id="quantity"
                            v-model="_each_product_quantity"
                            class="mt-1 block w-full text-center"
                            placeholder="Quantity"
                            min="0"
                        />
                        <button @click="increment()" class="bg-purple-500 text-white dark:bg-purple-600 dark:text-gray-200 px-4 py-2 rounded-md ml-1 hover:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none text-sm mt-1">
                            +
                        </button>
                        <button @click="removeInvoiceProduct()" class="border border-red-300 dark:border-red-400 bg-red-500 text-white dark:bg-red-600 dark:text-gray-200 p-2 ml-1 rounded-full hover:bg-red-600 dark:hover:bg-red-700 focus:outline-none text-sm mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                                <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button @click="invoiceProductSelect = false" class="border border-blue-300 dark:border-blue-400 bg-blue-500 text-white dark:bg-blue-600 dark:text-gray-200 p-2 ml-1 rounded-full hover:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none text-sm mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                </FadeTransition>
            </div>
        </div>
        <ModalTransition>
            <ChargeModal v-if="charge_modal"
                @modal_close="modal_close"
                @reset_state="reset_state"
                :currency_type="currency_type"
                :total_amount="full_total_price"
                :payment_methods="payment_methods"
                :total_tax_amount="total_tax_price"
                :transaction_id="transaction_id"
            />
        </ModalTransition>
    </AuthenticatedLayout>
</template>
