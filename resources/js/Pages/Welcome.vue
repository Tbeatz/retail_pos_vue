<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-center bg-no-repeat welcome_img"
    >
        <div class="absolute top-0 left-0 p-6">
            <Link href="https://www.unityitsolutionprovider.com">
                <img src="/style_images/unity.png" alt="Company Logo" class="logo-overlay">
            </Link>
        </div>
        <div class="absolute flex flex-col items-center justify-center text-justify p-14">
            <h1 class="text-white text-4xl font-semibold mb-4 uppercase relative">
                <span class="text-gradient bg-gradient-to-r from-white to-green-300 bg-clip-text text-transparent">Point of Sale System</span>
            </h1>
            <p class="text-blue-300 text-xl mx-auto border-2 border-yellow-400 rounded-md p-4 shadow-lg">
                A Point of Sale (POS) system is a crucial tool for retail and hospitality businesses, facilitating efficient transactions, inventory management, and sales analysis. It streamlines checkout, enhances customer service, and provides valuable insights for decision-making. POS systems optimize operations, improve inventory control, and boost revenue while ensuring secure payment processing and compliance with industry standards. In summary, POS systems are essential for businesses to streamline operations, improve customer experience, and drive growth.
            </p>
        </div>
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="text-white bg-blue-700 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium uppercase rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                >Log in</Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="text-white bg-yellow-700 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium uppercase rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                >Register</Link>
            </template>
        </div>
    </div>
</template>
<style>
    .welcome_img {
        background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('/style_images/welcome.jpg');
        background-size: cover;
    }

    .logo-overlay {
        filter: brightness(240%);
    }
</style>
