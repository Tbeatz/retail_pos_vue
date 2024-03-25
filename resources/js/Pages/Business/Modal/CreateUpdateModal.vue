<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import ValidateTransition from '@/Transitions/ValidateTransition.vue';
import { useForm } from '@inertiajs/vue3';

    const props = defineProps({
        state: String,
        business: Object,
        business_types: Object,
        currency_types: Object,
        tax_types: Object,
    })

    const emit = defineEmits(['modal_close']);

    const form = useForm({
        name : props.business ? props.business.name : '',
        business_type_id : props.business ? (props.business.business_type_id ? props.business.business_type_id : '') : '',
        address : props.business ? props.business.address : '',
        email : props.business ? props.business.email : '',
        phone : props.business ? props.business.phone : '',
        currency_type_id: props.business ? (props.business.currency_type_id ? props.business.currency_type_id : '') : '',
        tax_type_id: props.business ? (props.business.tax_type_id ? props.business.tax_type_id : '') : '',
    })
    
    function submit(state, id){
        state == 'create' ? form.post(route('business.store'), {
            onSuccess: () => {
                emit('modal_close');
            }
        }) : form.patch(route('business.update', id), {
            onSuccess: () => {
                emit('modal_close');
            }
        });
    }
</script>
<template>
    <div id="business_modal" tabindex="-1" aria-hidden="true" class="flex bg-black bg-opacity-50 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full inset-0 h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex items-center justify-between p-4 md:p-4 border-b rounded-t dark:border-gray-900 bg-purple-500 dark:bg-purple-600">
                    <h3 class="text-lg font-semibold text-white dark:text-gray-200">
                        {{state == 'create' ? 'Create New' : 'Edit'}} Business
                    </h3>
                    <button type="button" @click="$emit('modal_close')" class="text-gray-200 bg-transparent hover:bg-purple-600 hover:text-gray-100 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-purple-700 dark:hover:text-gray-100" data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form class="p-4 md:p-5" @submit.prevent="submit(state, business ? business.id : null)">
                    <div class="grid gap-4 mb-4 grid-cols-2">
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
                                placeholder="Type business name"
                                @input="form.clearErrors('name')"
                                required
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="tax_type_id" value="Tax Type" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.tax_type_id" />
                                </ValidateTransition>
                            </div>
                            <SelectInput
                                id="tax_type_id"
                                @input="form.clearErrors('tax_type_id')"
                                v-model="form.tax_type_id"
                                :value="tax_types"
                                nameProp="name"
                                required
                                autocomplete="tax_type_id"
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="business_type_id" value="Business Type" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.business_type_id" />
                                </ValidateTransition>
                            </div>
                            <SelectInput
                                id="business_type_id"
                                @input="form.clearErrors('business_type_id')"
                                v-model="form.business_type_id"
                                :value="business_types"
                                nameProp="name"
                                required
                                autocomplete="business_type_id"
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="currency_type_id" value="Currency Type" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.currency_type_id" />
                                </ValidateTransition>
                            </div>
                            <SelectInput
                                id="currency_type_id"
                                @input="form.clearErrors('currency_type_id')"
                                v-model="form.currency_type_id"
                                :value="currency_types"
                                nameProp="name"
                                required
                                autocomplete="currency_type_id"
                            />
                        </div>
                        <div class="col-span-2">
                            <div class="flex items-center gap-1">
                                <InputLabel for="address" value="Address" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.address" />
                                </ValidateTransition>
                            </div>
                            <TextareaInput
                                id="address"
                                v-model="form.address"
                                class="mt-1 block w-full"
                                @input="form.clearErrors('address')"
                                required
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="email" value="Email" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.email" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                type="text"
                                id="email"
                                v-model="form.email"
                                class="mt-1 block w-full"
                                placeholder="Type business email"
                                @input="form.clearErrors('email')"
                                required
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="phone" value="Phone Number" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.phone" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                type="text"
                                id="phone"
                                v-model="form.phone"
                                class="mt-1 block w-full"
                                placeholder="Type phone number"
                                @input="form.clearErrors('phone')"
                                required
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
