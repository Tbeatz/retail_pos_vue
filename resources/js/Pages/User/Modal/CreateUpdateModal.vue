<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import ValidateTransition from '@/Transitions/ValidateTransition.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

    const preview_url = ref('');

    const props = defineProps({
        state: String,
        user: Object,
        roles: Object,
        businesses: Object,
        positions: Object,
    })

    const page = usePage();

    const emit = defineEmits(['modal_close']);

    const form = useForm({
        _method : props.state == 'edit' ? 'patch' : '',
        avatar : props.user ? props.user.avatar : '',
        name : props.user ? props.user.name : '',
        email : props.user ? props.user.email : '',
        phone : props.user ? props.user.phone : '',
        address : props.user ? props.user.address : '',
        password : '',
        role_id : (page.props.auth.user.role_id == 1 && page.props.auth.user.position_id == 1) ? 1 : (props.user ? props.user.role_id : ''),
        business_id : props.user ? (props.user.business_id ? props.user.business_id : '') : '',
        position_id : props.user ? (props.user.position_id ? props.user.position_id : '') : '',
        state: props.state,
    })

    function submit(state, id){
        state == 'create' ? form.post(route('user.store'), {
            onSuccess: () => {
                emit('modal_close');
            }
        }) : form.post(route('user.update', id), {
            onSuccess: () => {
                emit('modal_close');
            }
        });
        URL.revokeObjectURL(preview_url.value);
    }

    function upload(e){
        form.clearErrors('avatar');
        form.avatar = e.target.files[0];
        preview_url.value = URL.createObjectURL(form.avatar);
    }
</script>
<template>
    <div id="user_modal" tabindex="-1" aria-hidden="true" class="flex bg-black bg-opacity-50 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full inset-0 h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex items-center justify-between p-4 md:p-4 border-b rounded-t dark:border-gray-900 bg-purple-500 dark:bg-purple-600">
                    <h3 class="text-lg font-semibold text-white dark:text-gray-200">
                        {{state == 'create' ? 'Create New' : 'Edit'}} User
                    </h3>
                    <button type="button" @click="$emit('modal_close')" class="text-gray-200 bg-transparent hover:bg-purple-600 hover:text-gray-100 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-purple-700 dark:hover:text-gray-100" data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form class="p-4 md:p-5" @submit.prevent="submit(state, user ? user.id : null)">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <img class="col-span-2 w-20 h-20 mx-auto m-1 rounded-full shadow-md dark:shadow-blue-600 shadow-blue-500" :src="preview_url ? preview_url : (form.avatar ? 'file/' + form.avatar : 'style_images/user.png')" alt="">
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="avatar" value="Avatar" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.avatar" />
                                </ValidateTransition>
                            </div>
                            <input accept=".jpg, .png" @input="upload" class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white dark:text-gray-200 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file">
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="name" value="User Name" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.name" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                type="text"
                                id="name"
                                v-model="form.name"
                                class="mt-1 block w-full"
                                placeholder="Type user name"
                                @input="form.clearErrors('name')"
                                required
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="phone" value="Phone No" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.phone" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                type="text"
                                id="phone"
                                v-model="form.phone"
                                class="mt-1 block w-full"
                                placeholder="Type user phone number"
                                @input="form.clearErrors('phone')"
                                required
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="role_id" value="Role" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.role_id" />
                                </ValidateTransition>
                            </div>
                            <SelectInput
                                id="role_id"
                                @input="form.clearErrors('role_id')"
                                v-model="form.role_id"
                                :value="roles"
                                nameProp="name"
                                required
                                autocomplete="role_id"
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
                                <InputLabel for="position_id" value="Position" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.position_id" />
                                </ValidateTransition>
                            </div>
                            <SelectInput
                                id="position_id"
                                @input="form.clearErrors('position_id')"
                                v-model="form.position_id"
                                :value="positions"
                                nameProp="name"
                                required
                                autocomplete="position_id"
                            />
                        </div>
                        <div class="col-span-1" v-if="$page.props.auth.user.role_id != 1">
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
                                autocomplete="business_id"
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="email" value="Login Email" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.email" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                type="text"
                                id="email"
                                v-model="form.email"
                                class="mt-1 block w-full"
                                placeholder="Type login email"
                                @input="form.clearErrors('email')"
                                required
                            />
                        </div>
                        <div class="col-span-1">
                            <div class="flex items-center gap-1">
                                <InputLabel for="password" value="Login Password" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.password" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                type="password"
                                id="password"
                                v-model="form.password"
                                class="mt-1 block w-full"
                                placeholder="Type user password"
                                @input="form.clearErrors('password')"
                                :required="state == 'edit' ? false : true"
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
