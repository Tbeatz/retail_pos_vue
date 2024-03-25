<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import ThemeSwitcher from '@/Components/ThemeSwitcher.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

const _scroll = ref(null);
const _scroll_lvl = ref('');

function scrollToTop(){
    _scroll.value.scrollTo({ top: 0, behavior: 'smooth' });
};

function handleScroll(e) {
    _scroll_lvl.value = e.target.scrollTop;
};

onMounted(() => {
  _scroll.value = document.getElementById('scroll_body');
  _scroll.value.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  _scroll.value.removeEventListener('scroll', handleScroll);
});

</script>

<template>
<div class="h-screen w-full bg-gray-100 dark:bg-gray-900 relative flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="h-full w-16 flex flex-col space-y-10 items-center justify-center relative bg-white dark:bg-gray-800 text-blue-600 dark:text-blue-600 font-medium shadow-md shadow-purple-600">
        <div class="top-2 absolute">
            <ThemeSwitcher extraStyle="shadow-md shadow-gray-500 dark:shadow-purple-500 hover:shadow-blue-500 dark:hover:shadow-gray-500 "/>
        </div>
        <NavLink v-if="$page.props.auth.user.role_id != 1" :href="route('dashboard')" :active="route().current('dashboard')" class="relative inline-flex items-center group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 0 0 0 1.5H3v10.5a3 3 0 0 0 3 3h1.21l-1.172 3.513a.75.75 0 0 0 1.424.474l.329-.987h8.418l.33.987a.75.75 0 0 0 1.422-.474l-1.17-3.513H18a3 3 0 0 0 3-3V3.75h.75a.75.75 0 0 0 0-1.5H2.25Zm6.54 15h6.42l.5 1.5H8.29l.5-1.5Zm8.085-8.995a.75.75 0 1 0-.75-1.299 12.81 12.81 0 0 0-3.558 3.05L11.03 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l2.47-2.47 1.617 1.618a.75.75 0 0 0 1.146-.102 11.312 11.312 0 0 1 3.612-3.321Z" clip-rule="evenodd" />
            </svg>
            <span class="pointer-events-none dark:text-gray-200 text-gray-600 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 absolute left-11 font-sans font-semibold shadow-sm px-2 py-1 rounded-md shadow-blue-400 z-10">Reports</span>
        </NavLink>
        <NavLink v-if="$page.props.auth.user.role_id != 1 && $page.props.auth.user.role_id != 2" :href="route('sale.index')" :active="route().current('sale.index')" class="relative inline-flex items-center group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 0 1-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004ZM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 0 1-.921.42Z" />
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 0 1-.921-.421l-.879-.66a.75.75 0 0 0-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 0 0 1.5 0v-.81a4.124 4.124 0 0 0 1.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 0 0-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 0 0 .933-1.175l-.415-.33a3.836 3.836 0 0 0-1.719-.755V6Z" clip-rule="evenodd" />
            </svg>
            <span class="pointer-events-none dark:text-gray-200 text-gray-600 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 absolute left-11 font-sans font-semibold shadow-sm px-2 py-1 rounded-md shadow-blue-400 z-10">Sales</span>
        </NavLink>
        <NavLink v-if="$page.props.auth.user.role_id != 1" :href="route('product.index')" :active="route().current('product.index')" class="relative inline-flex items-center group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
            </svg>
            <span class="pointer-events-none dark:text-gray-200 text-gray-600 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 absolute left-11 font-sans font-semibold shadow-sm px-2 py-1 rounded-md shadow-blue-400 z-10">Products</span>
        </NavLink>
        <NavLink v-if="$page.props.auth.user.role_id != 1" :href="route('invoice.index')" class="relative inline-flex items-center group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M12 1.5c-1.921 0-3.816.111-5.68.327-1.497.174-2.57 1.46-2.57 2.93V21.75a.75.75 0 0 0 1.029.696l3.471-1.388 3.472 1.388a.75.75 0 0 0 .556 0l3.472-1.388 3.471 1.388a.75.75 0 0 0 1.029-.696V4.757c0-1.47-1.073-2.756-2.57-2.93A49.255 49.255 0 0 0 12 1.5Zm3.53 7.28a.75.75 0 0 0-1.06-1.06l-6 6a.75.75 0 1 0 1.06 1.06l6-6ZM8.625 9a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm5.625 3.375a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z" clip-rule="evenodd" />
            </svg>
            <span class="pointer-events-none dark:text-gray-200 text-gray-600 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 absolute left-11 font-sans font-semibold shadow-sm px-2 py-1 rounded-md shadow-blue-400 z-10">Invoices</span>
        </NavLink>
    </aside>

    <div class="w-full h-full flex flex-col justify-between">
        <nav class="h-16 w-full flex items-center relative justify-end px-5 space-x-10 bg-purple-600 dark:bg-purple-700">
            <div class="absolute top-0 left-2 p-2 m-2 rounded-md bg-white shadow-blue-500 dark:shadow-blue-600 shadow-md">
                <Link href="https://www.unityitsolutionprovider.com">
                    <img src="/style_images/unity.png" alt="Company Logo" class="w-50 h-10">
                </Link>
            </div>
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center" v-if="$page.props.auth.user.role_id == 1 || $page.props.auth.user.role_id == 2">
                <Dropdown align="right" width="48">
                    <template v-slot:trigger>
                        <span class="inline-flex rounded-md">
                            <button type="button"
                            :class="(route().current('role.index') || route().current('reg_user.index') || route().current('tenant.index') || route().current('user.index') || (route().current('position.index') && $page.props.auth.user.role_id == 1))
                                ? 'inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-sans rounded-md text-white dark:text-white bg-blue-500 dark:bg-blue-600 hover:text-blue-100 dark:hover:text-blue-200 focus:outline-none transition ease-in-out duration-150'
                                : 'inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-sans rounded-md text-white dark:text-gray-100 bg-purple-600 dark:bg-purple-700 hover:text-blue-100 dark:hover:text-blue-200 focus:outline-none transition ease-in-out duration-150'">
                                User Management
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ms-1 -me-0.5 h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </button>
                        </span>
                    </template>
                    <template #content>
                        <DropdownLink :href="route('role.index')" :active="route().current('role.index')"> Role </DropdownLink>
                        <DropdownLink v-if="($page.props.auth.user.role_id == 1 || $page.props.auth.user.position_id == 1)" :href="route('reg_user.index')" :active="route().current('reg_user.index')"> Registered Users </DropdownLink>
                        <DropdownLink v-if="!$page.props.auth.tenant" :href="route('tenant.index')" :active="route().current('tenant.index')"> Tenant Users </DropdownLink>
                        <DropdownLink v-if="($page.props.auth.user.role_id == 1 && $page.props.auth.user.position_id == 1) || $page.props.auth.user.role_id == 2" :href="route('user.index')" :active="route().current('user.index')"> Users </DropdownLink>
                        <DropdownLink v-if="($page.props.auth.user.role_id == 1)" :href="route('position.index')" :active="route().current('position.index')"> Position </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center" v-if="$page.props.auth.user.role_id != 1 && $page.props.auth.user.role_id != 3">
                <Dropdown align="right" width="48">
                    <template v-slot:trigger>
                        <span class="inline-flex rounded-md">
                            <button type="button"
                            :class="(route().current('business_type.index') || route().current('business.index') || route().current('position.index'))
                                ? 'inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-sans rounded-md text-white dark:text-white bg-blue-500 dark:bg-blue-600 hover:text-blue-100 dark:hover:text-blue-200 focus:outline-none transition ease-in-out duration-150'
                                : 'inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-sans rounded-md text-white dark:text-gray-100 bg-purple-600 dark:bg-purple-700 hover:text-blue-100 dark:hover:text-blue-200 focus:outline-none transition ease-in-out duration-150'">
                                Business
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ms-1 -me-0.5 h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                </svg>
                            </button>
                        </span>
                    </template>
                    <template #content>
                        <DropdownLink :href="route('business_type.index')" :active="route().current('business_type.index')"> Business Type </DropdownLink>
                        <DropdownLink :href="route('business.index')" :active="route().current('business.index')"> Business </DropdownLink>
                        <DropdownLink :href="route('position.index')" :active="route().current('position.index')"> Position </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center" v-if="$page.props.auth.user.role_id != 1 && $page.props.auth.user.role_id != 3">
                <Dropdown align="right" width="48">
                    <template v-slot:trigger>
                        <span class="inline-flex rounded-md">
                            <button type="button"
                            :class="(route().current('payment_method.index') || route().current('invoice_type.index') || route().current('invoice_status.index') || route().current('tax_type.index'))
                                ? 'inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-sans rounded-md text-white dark:text-white bg-blue-500 dark:bg-blue-600 hover:text-blue-100 dark:hover:text-blue-200 focus:outline-none transition ease-in-out duration-150'
                                : 'inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-sans rounded-md text-white dark:text-gray-100 bg-purple-600 dark:bg-purple-700 hover:text-blue-100 dark:hover:text-blue-200 focus:outline-none transition ease-in-out duration-150'">
                                Financial
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ms-1 -me-0.5 h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                </svg>
                            </button>
                        </span>
                    </template>
                    <template #content>
                        <DropdownLink :href="route('payment_method.index')" :active="route().current('payment_method.index')"> Payment Method </DropdownLink>
                        <DropdownLink :href="route('invoice_type.index')" :active="route().current('invoice_type.index')"> Invoice Type </DropdownLink>
                        <DropdownLink :href="route('invoice_status.index')" :active="route().current('invoice_status.index')"> Invoice Status </DropdownLink>
                        <DropdownLink :href="route('tax_type.index')" :active="route().current('tax_type.index')"> Tax Type </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center" v-if="$page.props.auth.user.role_id != 1">
                <Link :href="route('category.index')"
                    :class="route().current('category.index')
                    ? 'inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-sans rounded-md text-white dark:text-white bg-blue-500 dark:bg-blue-600 hover:text-blue-100 dark:hover:text-blue-200 focus:outline-none transition ease-in-out duration-150'
                    : 'inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-sans rounded-md text-white dark:text-gray-100 bg-purple-600 dark:bg-purple-700 hover:text-blue-100 dark:hover:text-blue-200 focus:outline-none transition ease-in-out duration-150'">
                        Product Category
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ms-1 -me-0.5 h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                        </svg>
                </Link>
            </div>
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center" v-if="$page.props.auth.user.role_id != 1 && $page.props.auth.user.role_id != 3">
                <Dropdown align="right" width="48">
                    <template v-slot:trigger>
                        <span class="inline-flex rounded-md">
                            <button type="button"
                                :class="(route().current('unit.index') || route().current('currency_type.index'))
                                ? 'inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-sans rounded-md text-white dark:text-white bg-blue-500 dark:bg-blue-600 hover:text-blue-100 dark:hover:text-blue-200 focus:outline-none transition ease-in-out duration-150'
                                : 'inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-sans rounded-md text-white dark:text-gray-100 bg-purple-600 dark:bg-purple-700 hover:text-blue-100 dark:hover:text-blue-200 focus:outline-none transition ease-in-out duration-150'">
                                Miscellaneous
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ms-1 -me-0.5 h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </button>
                        </span>
                    </template>
                    <template #content>
                        <DropdownLink :href="route('currency_type.index')" :active="route().current('currency_type.index')"> Currency Type </DropdownLink>
                        <DropdownLink :href="route('unit.index')" :active="route().current('unit.index')"> Unit </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Settings Dropdown -->
                <div class="relative">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-sans rounded-md text-blue-100 font-semibold dark:text-blue-100 bg-purple-600 dark:bg-purple-700 hover:text-blue-100 dark:hover:text-blue-200 focus:outline-none transition ease-in-out duration-150"
                                >
                                    {{ $page.props.auth.user.name }}
                                    <div class="ms-2">
                                        <img class="w-10 h-10 rounded-full ring-2 ring-blue-600" :src="$page.props.auth.user.avatar ? 'file/' + $page.props.auth.user.avatar : '/style_images/user.png'" alt="">
                                    </div>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('profile.edit')" :active="route().current('profile.edit')"> Profile </DropdownLink>
                            <DropdownLink :href="route('profile.password')" :active="route().current('profile.password')"> Change Password </DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="showingNavigationDropdown = !showingNavigationDropdown"
                    class="inline-flex items-center justify-center p-1 rounded-md text-white dark:text-white hover:text-gray-100 dark:hover:text-gray-200 hover:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none focus:bg-blue-500 dark:focus:bg-blue-600 focus:text-white dark:focus:text-gray-200 transition duration-150 ease-in-out"
                >
                    <svg class="h-4 w-4" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path
                            :class="{
                                hidden: showingNavigationDropdown,
                                'inline-flex': !showingNavigationDropdown,
                            }"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{
                                hidden: !showingNavigationDropdown,
                                'inline-flex': showingNavigationDropdown,
                            }"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </nav>
        <!-- Responsive Navigation Menu -->
        <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }" class="sm:hidden overflow-y-auto">
            <div class="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink v-if="($page.props.auth.user.role_id == 1 || $page.props.auth.user.position_id == 1)" :href="route('reg_user.index')" :active="route().current('reg_user.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                   Registered Users
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('role.index')" :active="route().current('role.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                   Role
                </ResponsiveNavLink>
                <ResponsiveNavLink v-if="!$page.props.auth.tenant" :href="route('tenant.index')" :active="route().current('tenant.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                   Tenant Users
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('user.index')" :active="route().current('user.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                   Users
                </ResponsiveNavLink>
                <ResponsiveNavLink v-if="$page.props.auth.user.role_id == 1" :href="route('position.index')" :active="route().current('position.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                   Position
                </ResponsiveNavLink>
            </div>
            <div class="pt-2 pb-3 space-y-1 border-t border-gray-200 dark:border-gray-600" v-if="$page.props.auth.user.role_id != 1">
                <ResponsiveNavLink :href="route('business_type.index')" :active="route().current('business_type.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                   Business Type
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('business.index')" :active="route().current('business.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                   Business
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('position.index')" :active="route().current('position.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                   Position
                </ResponsiveNavLink>
            </div>
            <div v-if="$page.props.auth.user.role_id != 1" class="pt-2 pb-3 space-y-1 border-t border-gray-200 dark:border-gray-600">
                <ResponsiveNavLink :href="route('payment_method.index')" :active="route().current('payment_method.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                    Payment Method
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('invoice_type.index')" :active="route().current('invoice_type.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                    Invoice Type
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('invoice_status.index')" :active="route().current('invoice_status.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                    Invoice Status
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('tax_type.index')" :active="route().current('tax_type.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                    Tax Type
                </ResponsiveNavLink>
            </div>
            <div class="pt-2 pb-3 space-y-1 border-t border-gray-200 dark:border-gray-600" v-if="$page.props.auth.user.role_id != 1">
                <ResponsiveNavLink :href="route('category.index')" :active="route().current('category.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                   Product Category
                </ResponsiveNavLink>
            </div>
            <div class="pt-2 pb-3 space-y-1 border-t border-gray-200 dark:border-gray-600" v-if="$page.props.auth.user.role_id != 1">
                <ResponsiveNavLink :href="route('currency_type.index')" :active="route().current('currency_type.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                   Currency Type
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('unit.index')" :active="route().current('unit.index')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                    Unit
                </ResponsiveNavLink>
            </div>
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-sans text-base text-blue-600 dark:text-gray-100">
                        {{ $page.props.auth.user.name }}
                    </div>
                    <div class="font-sans text-sm text-blue-500 dark:text-blue-500">{{ $page.props.auth.user.email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <ResponsiveNavLink :href="route('profile.edit')" :active="route().current('profile.edit')" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                        Profile
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('logout')" method="post" as="button" class="block px-4 py-2 text-sm text-blue-500 dark:text-blue-600 hover:bg-purple-100 dark:hover:bg-gray-800 hover:text-blue-800 dark:hover:text-blue-400">
                        Log Out
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
        <!-- Page Heading -->
        <!-- <header class="bg-white dark:bg-gray-800 shadow" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header> -->
        <!-- Page Content -->
        <main class="max-w-full h-full flex relative overflow-hidden">
            <div id="scroll_body" class="h-full w-full m-4 flex flex-wrap items-start justify-start rounded-tl grid-flow-col auto-cols-max gap-4 overflow-y-auto">
                <slot />
                <button v-if="_scroll_lvl > 100" @click="scrollToTop()" class="fixed bottom-6 right-6 bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-full shadow-md dark:shadow-gray-700 shadow-gray-500 dark:bg-blue-600 dark:hover:bg-blue-700 z-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 18.75 7.5-7.5 7.5 7.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 7.5-7.5 7.5 7.5" />
                    </svg>
                </button>
            </div>
        </main>
    </div>
</div>
</template>
