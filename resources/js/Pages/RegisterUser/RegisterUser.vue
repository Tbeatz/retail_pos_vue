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
import RegisterUserCard from '../../Components/RegisterUserCard.vue';

const props = defineProps({
    users: Object,
    search_item: String,
    exists: Boolean,
});

const modal_open = ref(false);
const confirm_modal_open = ref(false);
const reg_user = ref(null);
const page = usePage();
const search = ref(props.search_item);

//edit and create
function modal_close(){
    modal_open.value = false;

    setTimeout(() => {
        page.props.flash.message = null;
    }, 3000);
}

function _modal_open(data){
    modal_open.value = true;
    reg_user.value = data;
}

//delete
function confirm_modal_close(){
    confirm_modal_open.value = false;
}

function _confirm_modal_open(data){
    confirm_modal_open.value = true;
    reg_user.value = data;
}

function user_del(id){
    router.delete(route('reg_user.destroy', id), {
        onSuccess: () => {
            confirm_modal_open.value = false;
        }
    });
}

//search
watch(search, debounce(function(new_v){
    router.get(route('reg_user.index'), {
        search_item : new_v,
    }, {
        preserveState: true,
    });
}), 300);

</script>
<template>
    <Head title="Registered User" />
    <AuthenticatedLayout>
        <section class="p-3 sm:p-5 w-full">
            <AlertTransition>
                <div v-if="$page.props.flash.message" class="fixed top-12 right-4 z-50">
                    <div class="p-3 text-sm text-blue-900 rounded-lg bg-white shadow-md shadow-blue-500 dark:bg-gray-900 dark:text-white" role="alert">
                        <span class="font-sans font-semibold">{{ $page.props.flash.message }}</span>
                    </div>
                </div>
            </AlertTransition>
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <RegisterUserCard v-if="exists == false"
                    title="Registered User"
                    desc="Approve of reject the registered Users!"
                />
                <div v-else>
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                            <div class="lg:w-1/2 md:w-1/2 sm:w-1/3">
                                <form class="flex items-center">
                                    <label for="simple-search" class="sr-only">Search</label>
                                    <div class="relative w-full">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="text" v-model="search" id="user_search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-white uppercase bg-purple-500 dark:bg-purple-700 dark:text-gray-200">
                                    <tr class="text-center">
                                        <th scope="col" class="px-6 py-3">ID</th>
                                        <th scope="col" class="px-6 py-3">Name</th>
                                        <th scope="col" class="px-6 py-3">Email</th>
                                        <th scope="col" class="px-6 py-3">Phone</th>
                                        <th scope="col" class="px-6 py-3">Address</th>
                                        <th scope="col" class="px-6 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(user, index) in users.data" class="text-center border-b dark:border-gray-700" :key="user.id">
                                        <td scope="row" class="px-6 py-3">{{ index + 1 }}</td>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ user.name }}</th>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ user.email }}</th>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ user.phone }}</th>
                                        <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ user.address }}</th>
                                        <td class="px-6 py-3 flex items-center gap-2 justify-center">
                                            <button @click="_modal_open(user)" class="text-green-400 hover:text-green-800 rounded-lg focus:outline-none dark:text-green-400 dark:hover:text-green-100" type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <button @click="_confirm_modal_open(user)" class="text-red-500 hover:text-red-800 rounded-lg focus:outline-none dark:text-red-500 dark:hover:text-red-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
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
            <CreateUpdateModal v-if="modal_open" @modal_close="modal_close" :reg_user="reg_user"/>
            <ConfirmModal v-if="confirm_modal_open" @modal_close="confirm_modal_close" @delete="user_del(reg_user.id)" />
        </ModalTransition>
    </AuthenticatedLayout>
</template>
