<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ThemeSwitcher from '@/Components/ThemeSwitcher.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ValidateTransition from '@/Transitions/ValidateTransition.vue';
import AlertTransition from '@/Transitions/AlertTransition.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />
        <AlertTransition>
            <div v-if="$page.props.flash.register_success" class="fixed top-12 right-12 z-50">
                <div class="p-3 text-sm text-blue-900 rounded-lg bg-white shadow-md shadow-blue-500 dark:bg-gray-900 dark:text-white" role="alert">
                    <span class="font-sans font-semibold">{{ $page.props.flash.register_success }}</span>
                </div>
            </div>
        </AlertTransition>
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div class="lg:flex w-1/2 hidden bg-gray-500 bg-no-repeat bg-cover relative items-center" style="background-image: url('/style_images/register.jpg');">
            <div class="absolute bg-black opacity-60 inset-0 z-0"></div>
            <div class="w-full px-24 z-10">
                <h1 class="text-5xl font-bold text-left tracking-wide text-blue-400">Point of Sale</h1>
                <p class="text-3xl my-4">Point of Sale is where you reach 100% of your audience 100% of the time.</p>
            </div>
        </div>
        <div class="lg:w-1/2 w-full flex items-center justify-center md:px-16 px-0 z-0 dark:bg-gray-900 bg-gray-100 shadow-lg shadow-gray-200 dark:shadow-blue-800">
            <div class="absolute lg:hidden z-10 inset-0 bg-gray-500 bg-no-repeat bg-cover items-center" style="background-image: url('/style_images/register.jpg')">
                <div class="absolute bg-black opacity-60 inset-0 z-0"></div>
            </div>
            <div class="w-full py-2 z-20">
                <form @submit.prevent="submit" class=" w-full px-4 lg:px-0 mx-auto">
                    <div class="flex flex-row justify-between items-center">
                        <Link href="/">
                            <h1 class="text-2xl font-semibold text-blue-600 font-sans dark:text-white hover:text-blue-700 hover:underline dark:hover:text-blue-300">LOGIN</h1>
                        </Link>

                        <ThemeSwitcher/>
                    </div>
                    <div class="flex flex-col gap-2 mt-4">
                        <div class="w-full">
                            <div class="flex items-center gap-1">
                                <InputLabel for="email" value="Email" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.email" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                @input="form.clearErrors('email')"
                                required
                                autofocus
                                autocomplete="username"
                            />
                        </div>
                        <div class="w-full">
                            <div class="flex items-center gap-1">
                                <InputLabel for="password" value="Password" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.password" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                @input="form.clearErrors('password')"
                                required
                                autocomplete="current-password"
                            />
                        </div>
                    </div>

                    <div class="mt-4 flex flex-row justify-between">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                        </label>
                        <Link
                            :href="route('register')"
                            class="font-medium underline text-sm text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        >
                            Still not registered yet? Click Here...
                        </Link>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        >
                            Forgot your password?
                        </Link>
                        <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ms-5">Sign In</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
