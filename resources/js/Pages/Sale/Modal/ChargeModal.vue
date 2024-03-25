<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import ValidateTransition from '@/Transitions/ValidateTransition.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { computed } from 'vue';

    const props = defineProps({
        currency_type : String,
        total_amount: Number,
        payment_methods: Object,
        total_tax_amount: Number,
        transaction_id: Number,
    })

    const page = usePage();
    const emit = defineEmits(['modal_close', 'reset_state']);
    const _received_amount = ref(props.total_amount);
    const form = useForm({
        received_amount: computed(() => _received_amount.value),
        currency_type: props.currency_type,
        change: computed(() => Number((_received_amount.value - props.total_amount).toFixed(2))),
        payment_method_id: null,
        total_tax_amount: props.total_tax_amount,
        total_amount: props.total_amount,
    });

    function submit(){
        form.patch(route('transaction.update', props.transaction_id), {
            onSuccess: () => {
                emit('modal_close');
                emit('reset_state');
                setTimeout(() => {
                    page.props.flash.message = null;
                }, 3000);
            }
        })
    }

</script>
<template>
    <div id="role_modal" tabindex="-1" aria-hidden="true" class="flex bg-black bg-opacity-50 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full inset-0 h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex items-center justify-between p-4 md:p-4 border-b rounded-t dark:border-gray-900 bg-purple-500 dark:bg-purple-600">
                    <h3 class="text-lg font-semibold text-white dark:text-gray-200">
                        Charge
                    </h3>
                </div>
                <form class="p-4 md:p-5" @submit.prevent="submit()">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <div class="flex items-center gap-1">
                                <p class="text-blue-500 dark:text-blue-600 text-sm font-semibold">Total Amount :
                                    <span class="text-gray-600 dark:text-blue-300">{{total_amount + ' ' + currency_type }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="flex items-center gap-1">
                                <InputLabel for="received_amount" :value="`Received Amount (${currency_type})`" />
                                <ValidateTransition>
                                    <InputError :message="form.errors.received_amount" />
                                </ValidateTransition>
                            </div>
                            <TextInput
                                type="number"
                                id="received_amount"
                                v-model="_received_amount"
                                class="mt-1 block w-full"
                                placeholder="Type received amount"
                                @input="form.clearErrors('received_amount')"
                                required
                                step="0.01"
                            />
                        </div>
                        <div class="col-span-2">
                            <div class="flex items-center gap-1">
                                <p class="text-blue-500 dark:text-blue-600 text-sm font-semibold">Change :
                                    <span class="text-gray-600 dark:text-blue-300">{{form.change + ' ' + currency_type }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col gap-2 items-center justify-center w-full">
                            <button v-for="payment in payment_methods" :key="payment.id" @click="form.payment_method_id = payment.id"
                                class="w-full p-1.5 text-white dark:text-gray-300 bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                {{ payment.name }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
