<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ThemeSwitcher from '@/Components/ThemeSwitcher.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { Head, Link, useForm, usePage} from '@inertiajs/vue3';
import ValidateTransition from '@/Transitions/ValidateTransition.vue';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: '',
    position_id : '',
    password: '',
    password_confirmation: '',
});

const page = usePage();

defineProps({
    positions : Array,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            setTimeout(() => {
                page.props.flash.register_success = null
            }, 3000);
            form.reset('password', 'password_confirmation')
        },
    });
};
</script>

<template class="dark">
    <Head title="Register" />
    <GuestLayout>
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
                        <h1 class="text-2xl font-semibold text-blue-600 font-sans dark:text-white hover:text-blue-700 hover:underline dark:hover:text-blue-300">REGISTER</h1>
                    </Link>

                    <ThemeSwitcher/>
                </div>
                <div class="flex flex-row gap-2 mt-4">
                    <div class="w-1/2">
                        <div class="flex items-center gap-1">
                            <InputLabel for="name" value="Name" />
                            <ValidateTransition>
                                <InputError :message="form.errors.name" />
                            </ValidateTransition>
                        </div>
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            @input="form.clearErrors('name')"
                            required
                            autofocus
                            autocomplete="name"
                        />
                    </div>
                    <div class="w-1/2">
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
                            autocomplete="username"
                        />
                    </div>
                </div>

                <div class="flex flex-row gap-2 mt-4">
                    <div class="w-1/2">
                        <div class="flex items-center gap-1">
                            <InputLabel for="phone" value="Phone No." />
                            <ValidateTransition>
                                <InputError :message="form.errors.phone" />
                            </ValidateTransition>
                        </div>
                        <TextInput
                            id="phone"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.phone"
                            @input="form.clearErrors('phone')"
                            required
                            autocomplete="phone"
                        />
                    </div>
                    <div class="w-1/2">
                        <div class="flex items-center gap-1">
                            <InputLabel for="address" value="Address" />
                            <ValidateTransition>
                                <InputError :message="form.errors.address" />
                            </ValidateTransition>
                        </div>
                        <TextInput
                            id="address"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.address"
                            @input="form.clearErrors('address')"
                            required
                            autocomplete="address"
                        />
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex items-center gap-1">
                        <InputLabel for="position_id" value="Position" />
                        <ValidateTransition>
                            <InputError :message="form.errors.position_id" />
                        </ValidateTransition>
                    </div>
                    <SelectInput
                        v-model="form.position_id"
                        @change="form.clearErrors('position_id')"
                        required
                        id="position_id"
                        :value="positions"
                        nameProp="name"/>
                </div>
                <div class="flex flex-row gap-2 mt-4 mb-4">
                    <div class="w-1/2">
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
                            autocomplete="new-password"
                        />
                    </div>
                    <div class="w-1/2">
                        <div class="flex items-center gap-1">
                            <InputLabel for="password_confirmation" value="Confirm Password" />
                            <ValidateTransition>
                                <InputError :message="form.errors.password_confirmation" />
                            </ValidateTransition>
                        </div>
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password_confirmation"
                            @input="form.clearErrors('password_confirmation')"
                            required
                            autocomplete="new-password"
                        />
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <Link
                        :href="route('login')"
                        class="font-medium underline text-sm text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Already registered?
                    </Link>

                    <PrimaryButton type="submit">Sign Up</PrimaryButton>
                </div>
            </form>
        </div>
    </div>
    </GuestLayout>
</template>
