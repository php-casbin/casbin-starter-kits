<script setup>
import {FwbInput, FwbSelect} from "flowbite-vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    user: Object,
})

const emit = defineEmits(['submitted'])

const userForm = useForm({
    password: '',
})

const resetPassword = () => {
    userForm.put(route('users.update', props.user), {
        errorBag: 'updateUser',
        preserveScroll: false,
        onSuccess: () => {
            userForm.reset()
            userForm.clearErrors()
            emit('submitted')
        }
    })
}

const submitForm = () => {
    resetPassword()
}
</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="grid gap-4 mb-4 grid-cols-2">
            <div class="col-span-2">
                <fwb-input class="focus:ring-primary-500 focus:border-primary-500"
                           :validation-status="userForm.errors.password?'error':''" v-model="userForm.password"
                           label="Password" type="password" placeholder="Type user password">
                    <template v-if="userForm.errors.password" #validationMessage>
                        {{ userForm.errors.password }}
                    </template>
                </fwb-input>
            </div>
        </div>
        <button :disabled="userForm.processing" :class="{ 'opacity-25': userForm.processing }" type="submit"
                class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            <svg class="me-1 -ms-1 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                 height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
            </svg>
            Save
        </button>
    </form>
</template>
