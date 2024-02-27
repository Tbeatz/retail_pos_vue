<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    positions: {
        type: Array,
    },
});
const user = usePage().props.auth.user;
const preview_url = ref('');

const form = useForm({
    avatar: user.avatar,
    name: user.name,
    email: user.email,
    phone: user.phone,
    address: user.address,
    position_id: user.position_id,
});

function upload(e){
    form.avatar = e.target.files[0];
    preview_url.value = URL.createObjectURL(form.avatar);
}

function form_submit(){
    form.post(route('profile.update'), {
        preserveScroll: true,
        _method: 'patch'
    });
    URL.revokeObjectURL(preview_url.value);
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-blue-600 dark:text-blue-500 uppercase">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-700 dark:text-gray-200">
                Update your account's profile information.
            </p>
        </header>
            <form
                @submit.prevent="form_submit"
                class="mt-6 space-y-6"
            >
            <img class="w-20 h-20 rounded-full shadow-md dark:shadow-blue-600 shadow-blue-500" :src="preview_url ? preview_url : (form.avatar ? 'file/' + form.avatar : 'style_images/user.png')" alt="">
            <div class="flex flex-col gap-2 items-start">
                <div class="w-1/2">
                    <InputLabel for="avatar" value="Avatar" />
                    <input accept=".jpg, .png" @input="upload" class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white dark:text-gray-200 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file">
                    <InputError class="mt-2" :message="form.errors.avatar" />
                </div>
            </div>
            <div class="flex flex-row gap-2 items-center justify-center">
                <div class="w-1/2">
                    <InputLabel for="name" value="Name" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div class="w-1/2">
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
            </div>

            <div class="flex flex-row gap-2 items-center justify-center">
                <div class="w-1/2">
                    <InputLabel for="position_id" value="Position" />
                    <SelectInput
                        id="position_id"
                        v-model="form.position_id"
                        :value="positions"
                        nameProp="name"
                        disabled
                        autocomplete="position_id"
                    />
                    <InputError class="mt-2" :message="form.errors.position_id" />
                </div>
                <div class="w-1/2">
                    <InputLabel for="phone" value="Phone" />
                    <TextInput
                        id="phone"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.phone"
                        required
                        autocomplete="phone"
                    />
                    <InputError class="mt-2" :message="form.errors.phone" />
                </div>
            </div>

            <div class="w-1/2">
                <InputLabel for="address" value="Address" />

                <TextInput
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address"
                    required
                    autocomplete="address"
                />

                <InputError class="mt-2" :message="form.errors.address" />
            </div>



            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600 dark:text-green-400"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-3">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="inline-block px-3 py-1 text-sm font-semibold leading-none text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800 rounded-full">
                        Success...
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
