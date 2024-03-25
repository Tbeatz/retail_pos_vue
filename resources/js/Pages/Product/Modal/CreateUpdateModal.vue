<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import ValidateTransition from '@/Transitions/ValidateTransition.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

    const preview_url = ref('');
    const props = defineProps({
        state: String,
        product: Object,
        businesses: Object,
        units: Object,
        categories: Object,
    })

    const emit = defineEmits(['modal_close']);

    const form = useForm({
        _method : props.state == 'edit' ? 'patch' : '',
        image : props.product ? props.product.image : null,
        name : props.product ? props.product.name : '',
        unit_id : props.product ? (props.product.unit_id ? props.product.unit_id : '') : '',
        product_code : props.product ? props.product.product_code : '',
        category_id : props.product ? (props.product.category_id ? props.product.category_id : '') : '',
        description : props.product ? props.product.description : '',
        price : props.product ? props.product.price : '',
        instock_qty : props.product ? props.product.instock_qty : 0,
        restock_qty : props.product ? props.product.restock_qty : 0,
        business_id : props.product ? (props.product.business_id ? props.product.business_id : '') : '',
        discount_price : props.product ? props.product.discount_price : 0,
    })
    
    function submit(state, id){
        state == 'create' ? form.post(route('product.store'), {
            onSuccess: () => {
                emit('modal_close');
            }
        }) : form.post(route('product.update', id), {
            onSuccess: () => {
                emit('modal_close');
            }
        });
        URL.revokeObjectURL(preview_url.value);
    }

    function upload(e){
        form.clearErrors('image');
        form.image = e.target.files[0];
        preview_url.value = URL.createObjectURL(form.image);
    }
</script>
<template>
    <div id="product_modal" tabindex="-1" aria-hidden="true" class="flex bg-black bg-opacity-50 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full inset-0 h-full">
        <div class="relative p-4 w-full max-w-5xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex items-center justify-between p-4 md:p-4 border-b rounded-t dark:border-gray-900 bg-purple-500 dark:bg-purple-600">
                    <h3 class="text-lg font-semibold text-white dark:text-gray-200">
                        {{state == 'create' ? 'Create New' : 'Edit'}} Product
                    </h3>
                    <button type="button" @click="$emit('modal_close')" class="text-gray-200 bg-transparent hover:bg-purple-600 hover:text-gray-100 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-purple-700 dark:hover:text-gray-100" data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form class="p-4 md:p-5" @submit.prevent="submit(state, product ? product.id : null)">
                    <div class="grid gap-4 mb-4 grid-cols-4">
                        <img class="col-span-1 w-24 h-24 mx-auto m-3 rounded-full shadow-md dark:shadow-blue-600 shadow-blue-500" :src="preview_url ? preview_url : (form.image ? 'file/' + form.image : 'style_images/product.png')" alt="">
                        <div class="col-span-3">
                            <div class="flex items-center gap-1">
                                <InputLabel for="description" value="Description" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.description" />
                                </ValidateTransition>
                            </div>
                            <TextareaInput
                                id="description"
                                v-model="form.description"
                                class="mt-1 block w-full"
                                @input="form.clearErrors('description')"
                                required
                            />
                        </div>
                        <div class="flex flex-col gap-2 items-start col-span-1">
                            <div class="w-full">
                                <div class="flex items-center gap-1">
                                    <InputLabel for="image" value="Image" />
                                    <ValidateTransition>
                                        <InputError :message="form.errors.image" />
                                    </ValidateTransition>
                                </div>
                                <input accept=".jpg, .png" @input="upload" class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white dark:text-gray-200 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file">
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="name" value="Name" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.name" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                type="text"
                                id="name"
                                v-model="form.name"
                                class="mt-1 block w-full"
                                placeholder="Type product name"
                                @input="form.clearErrors('name')"
                                required
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="product_code" value="Product Code" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.product_code" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                type="text"
                                id="product_code"
                                v-model="form.product_code"
                                class="mt-1 block w-full"
                                placeholder="Type product code"
                                @input="form.clearErrors('product_code')"
                                required
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="category_id" value="Product Category" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.category_id" />
                                </ValidateTransition>
                            </div>
                            <SelectInput
                                id="category_id"
                                @input="form.clearErrors('category_id')"
                                v-model="form.category_id"
                                :value="categories"
                                nameProp="name"
                                required
                                autocomplete="category_id"
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="unit_id" value="Product Unit" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.unit_id" />
                                </ValidateTransition>
                            </div>
                            <SelectInput
                                id="unit_id"
                                @input="form.clearErrors('unit_id')"
                                v-model="form.unit_id"
                                :value="units"
                                nameProp="name"
                                required
                                autocomplete="unit_id"
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="price" value="Price" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.price" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                type="text"
                                id="price"
                                v-model="form.price"
                                class="mt-1 block w-full"
                                placeholder="Type product price"
                                @input="form.clearErrors('price')"
                                required
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="instock_qty" value="Instock" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.instock_qty" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                type="number"
                                id="instock_qty"
                                v-model="form.instock_qty"
                                class="mt-1 block w-full"
                                placeholder="Quantity"
                                @input="form.clearErrors('instock_qty')"
                                required
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="restock_qty" value="Restock" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.restock_qty" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                type="number"
                                id="restock_qty"
                                v-model="form.restock_qty"
                                class="mt-1 block w-full"
                                placeholder="Quantity"
                                @input="form.clearErrors('restock_qty')"
                                required
                            />
                        </div>
                        <div class="col-span-2">
                            <div class="flex items-center gap-1">
                                <InputLabel for="business_id" value="Business" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.business_id" />
                                </ValidateTransition>
                            </div>
                            <SelectInput
                                id="business_id"
                                @input="form.clearErrors('business_id')"
                                v-model="form.business_id"
                                :value="businesses"
                                nameProp="name"
                                required
                                autocomplete="business_id"
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="discount_price" value="Discount Price" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.discount_price" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                type="number"
                                id="discount_price"
                                v-model="form.discount_price"
                                class="mt-1 block w-full"
                                placeholder="Price"
                                @input="form.clearErrors('discount_price')"
                            />
                        </div>
                    </div>
                    <button :disabled="form.processing" type="submit" class="text-white inline-flex items-center bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        {{ state == 'create' ? 'Add' : 'Update' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
