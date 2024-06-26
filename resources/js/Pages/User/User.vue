<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CreateUpdateModal from './Modal/CreateUpdateModal.vue';
import ModalTransition from '@/Transitions/ModalTransition.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import ConfirmModal from '@/Components/ConfirmModal.vue';
import AlertTransition from '@/Transitions/AlertTransition.vue';
import Pagination from '@/Components/Pagination.vue';
import FadeTransition from '@/Transitions/FadeTransition.vue';
import InitialCard from '@/Components/InitialCard.vue';
import { debounce } from '@/Composables/debounce';
import SelectInput from '@/Components/SelectInput.vue';

const props = defineProps({
    users: Object,
    roles: Object,
    businesses: Object,
    positions: Object,
    search_item: String,
    exists: Boolean,
    filter_business: String,
    filter_role: String,
    filter_position: String,
})

const modal_open = ref(false);
const confirm_modal_open = ref(false);
const state = ref('');
const user = ref(null);
const page = usePage();
const search = ref(props.search_item);
const filter_business = ref(props.filter_business);
const filter_role = ref(props.filter_role);
const filter_position = ref(props.filter_position);
const checked = ref([]);
const check_del = ref(false);
const all_check_val = ref(false);

//edit and create
function modal_close(){
    modal_open.value = false;
    state.value = '';

    setTimeout(() => {
        page.props.flash.message = null;
    }, 3000);
}

function _modal_open(value, data){
    modal_open.value = true;
    state.value = value;
    user.value = data;
}

//delete
function confirm_modal_close(){
    confirm_modal_open.value = false;
}

function _confirm_modal_open(data){
    confirm_modal_open.value = true;
    user.value = data;
}

function user_del(id){
    if (id == 'all') {
        var request_data = {
            onSuccess: () => {
                checked.value = [];
                all_check_val.value = false;
                confirm_modal_close();
                setTimeout(() => {
                    page.props.flash.message = null;
                }, 3000);
            }
        };
        var url_param = id;
    } else {
        var request_data = Array.isArray(id)
            ? {
                data: { selected_ids: id },
                onSuccess: () => {
                    confirm_modal_close();
                    setTimeout(() => {
                        page.props.flash.message = null;
                    }, 3000);
                }
            }
            : {
                onSuccess: () => {
                    confirm_modal_close();
                    setTimeout(() => {
                        page.props.flash.message = null;
                    }, 3000);
                }
            };
        var url_param = Array.isArray(id) ? 'param' : id;
    }
    router.delete(route('user.destroy', url_param), request_data);
    check_del.value = false;
}

//search
watch([search, filter_business, filter_role, filter_position], debounce(function([new_v, new_fb_v, new_fr_v, new_fp_v]){
    router.get(route('user.index'), {
        search_item : new_v,
        filter_business: new_fb_v,
        filter_role: new_fr_v,
        filter_position: new_fp_v,
    }, {
        preserveState: true,
    });
}),300);

//checkbox
function check_input(checked_id, event){
    const isChecked = event.target.checked;
    if (isChecked) {
        if (!checked.value.includes(checked_id)) {
            checked.value.push(checked_id);
        }
    } else {
        checked.value = checked.value.filter(function(value){
            return value != checked_id;
        });
    }
    check_del.value = checked.value.length > 0;
}

function all_check_fn(event){
    if(all_check_val.value){
        checked.value = 'all';
        check_del.value = true;
    } else {
        checked.value = [];
        check_del.value = false;
    }
}

</script>
<template>
    <Head title="User" />
    <AuthenticatedLayout>
        <section class="p-3 sm:p-5 w-full">
            <AlertTransition>
                <div v-if="$page.props.flash.message" class="fixed top-12 right-4 z-50">
                    <div class="p-3 text-sm text-blue-900 rounded-lg bg-white shadow-md shadow-blue-500 dark:bg-gray-900 dark:text-white" user="alert">
                        <span class="font-sans font-semibold">{{ $page.props.flash.message }}</span>
                    </div>
                </div>
            </AlertTransition>
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <InitialCard v-if="exists == false"
                    @create_modal_open="_modal_open('create', null)"
                    title="User"
                    desc="Register for new user users."
                />
                <div v-else>
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                            <div class="lg:w-2/3 md:w-2/3 sm:w-1/3">
                                <form class="flex items-center gap-2">
                                    <label for="simple-search" class="sr-only">Search</label>
                                    <div class="relative w-1/4 mt-1">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="text" v-model="search" id="user_search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search">
                                    </div>
                                    <div v-if="$page.props.auth.user.role_id != 1" class="relative w-1/4">
                                        <SelectInput
                                            id="business_id"
                                            v-model="filter_business"
                                            :value="businesses"
                                            nameProp="name"
                                            default_option="Filter Business"
                                        />
                                    </div>
                                    <div v-if="$page.props.auth.user.role_id != 1 && $page.props.auth.user.position_id != 1" class="relative w-1/4">
                                        <SelectInput
                                            id="role_id"
                                            v-model="filter_role"
                                            :value="roles"
                                            nameProp="name"
                                            default_option="Filter Role"
                                        />
                                    </div>
                                    <div class="relative w-1/4">
                                        <SelectInput
                                            id="position_id"
                                            v-model="filter_position"
                                            :value="positions"
                                            nameProp="name"
                                            default_option="Filter Position"
                                        />
                                    </div>
                                </form>
                            </div>
                            <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                                <FadeTransition>
                                    <button v-if="check_del" type="button" @click="user_del(checked)" class="flex items-center justify-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-700 dark:hover:bg-red-800 focus:outline-none dark:focus:ring-red-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                        </svg>
                                        Delete Selected
                                    </button>
                                </FadeTransition>
                                <button type="button" @click="_modal_open('create', null)" class="flex items-center justify-center text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    <svg class="h-5 w-5 mr-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                    </svg>
                                    Add User
                                </button>
                            </div>
                        </div>
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-white uppercase bg-purple-500 dark:bg-purple-700 dark:text-gray-200">
                                    <tr class="text-center">
                                        <th scope="col" class="p-4">
                                            <div class="flex items-center">
                                                <input v-model="all_check_val" @change="all_check_fn($event)" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label class="sr-only">checkbox</label>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3">ID</th>
                                        <th scope="col" class="px-6 py-3">Avatar</th>
                                        <th scope="col" class="px-6 py-3">Name</th>
                                        <th scope="col" class="px-6 py-3">Login Email</th>
                                        <th scope="col" class="px-6 py-3">Phone No</th>
                                        <th scope="col" class="px-6 py-3">Role</th>
                                        <th scope="col" class="px-6 py-3">Position</th>
                                        <th v-if="$page.props.auth.user.role_id != 1" scope="col" class="px-6 py-3">Business</th>
                                        <th scope="col" class="px-6 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(user, index) in users.data" class="text-center border-b dark:border-gray-700" :key="user.id">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                                <input v-if="all_check_val == false" @change="check_input(user.id, $event)" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td scope="row" class="px-6 py-3">{{ index + 1 }}</td>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <img class="w-14 h-14 rounded-full shadow-md dark:shadow-blue-600 shadow-blue-500 mx-auto" :src="user.avatar ? 'file/' + user.avatar : 'style_images/user.png'" alt="">
                                        </th>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ user.name }}</th>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ user.email }}</th>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ user.phone }}</th>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ user.role.name }}</th>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ user.position.name }}</th>
                                        <th v-if="$page.props.auth.user.role_id != 1" class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ user.business ? user.business.name : '-' }}</th>
                                        <td class="px-6 py-3">
                                            <button @click="_modal_open('edit', user)" class="text-yellow-400 hover:text-yellow-800 rounded-lg focus:outline-none dark:text-yellow-400 dark:hover:text-yellow-100 mr-1" type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                    <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                                </svg>
                                            </button>
                                            <button @click="_confirm_modal_open(user)" class="text-red-500 hover:text-red-800 rounded-lg focus:outline-none dark:text-red-500 dark:hover:text-red-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Pagination :items="users"/>
                </div>
            </div>
        </section>
        <ModalTransition>
            <CreateUpdateModal v-if="modal_open" @modal_close="modal_close" :state="state" :user="user" :roles="roles" :businesses="businesses" :positions="positions"/>
            <ConfirmModal v-if="confirm_modal_open" @modal_close="confirm_modal_close" @delete="user_del(user.id)" />
        </ModalTransition>
    </AuthenticatedLayout>
</template>
