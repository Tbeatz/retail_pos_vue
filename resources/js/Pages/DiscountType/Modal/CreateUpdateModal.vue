<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import ValidateTransition from '@/Transitions/ValidateTransition.vue';
import { useForm } from '@inertiajs/vue3';

    const props = defineProps({
        state: String,
        discount_type: Object,
    })

    const emit = defineEmits(['modal_close']);

    const form = useForm({
        name : props.discount_type ? props.discount_type.name : '',
    })

    function submit(state, id){
        state == 'create' ? form.post(route('discount_type.store'), {
            onSuccess: () => {
                emit('modal_close');
            }
        }) : form.patch(route('discount_type.update', id), {
            onSuccess: () => {
                emit('modal_close');
            }
        });
    }
</script>
<template>
    <div id="discount_type_modal" tabindex="-1" aria-hidden="true" class="flex bg-black bg-opacity-50 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full inset-0 h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex items-center justify-between p-4 md:p-4 border-b rounded-t dark:border-gray-900 bg-purple-500 dark:bg-purple-600">
                    <h3 class="text-lg font-semibold text-white dark:text-gray-200">
                        {{state == 'create' ? 'Create New' : 'Edit'}} Discount Type
                    </h3>
                    <button type="button" @click="$emit('modal_close')" class="text-gray-200 bg-transparent hover:bg-purple-600 hover:text-gray-100 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-purple-700 dark:hover:text-gray-100" data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form class="p-4 md:p-5" @submit.prevent="submit(state, discount_type ? discount_type.id : null)">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
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
                                placeholder="Type discount type name"
                                @input="form.clearErrors('name')"
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
