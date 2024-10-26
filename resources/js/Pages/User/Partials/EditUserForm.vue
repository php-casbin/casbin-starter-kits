<script setup>
import {FwbInput, FwbSelect} from "flowbite-vue";
import {useForm} from "@inertiajs/vue3";
import {onMounted} from "vue";

const props = defineProps({
    user: Object,
    roles: Array
})

const emit = defineEmits(['submitted'])

const userForm = useForm({
    name: '',
    email: '',
    role: '',
})

const createUser = () => {
    userForm.post(route('users.store'), {
        errorBag: 'createUser',
        preserveScroll: false,
        onSuccess: () => {
            userForm.reset()
            userForm.clearErrors()
            emit('submitted')
        }
    })
}

const updateUser = () => {
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
    if (props.user) {
        updateUser()
    } else {
        createUser()
    }
}

onMounted(() => {
    if (props.user) {
        userForm.name = props.user.name
        userForm.email = props.user.email
        userForm.role = props.user.roles.length > 0 ? props.user.roles[0].id : ''
    }
})
</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="grid gap-4 mb-4 grid-cols-2">
            <div class="col-span-2">
                <fwb-input class="focus:ring-primary-500 focus:border-primary-500"
                           :validation-status="userForm.errors.name?'error':''" v-model="userForm.name"
                           label="Name" placeholder="Type user name">
                    <template v-if="userForm.errors.name" #validationMessage>
                        {{ userForm.errors.name }}
                    </template>
                </fwb-input>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <fwb-input class="focus:ring-primary-500 focus:border-primary-500"
                           :validation-status="userForm.errors.email?'error':''" v-model="userForm.email"
                           label="Email" placeholder="Type user email">
                    <template v-if="userForm.errors.email" #validationMessage>
                        {{ userForm.errors.email }}
                    </template>
                </fwb-input>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <fwb-select :validation-status="userForm.errors.role?'error':''" :options="roles"
                            v-model="userForm.role" label="Role" placeholder="Select role">
                    <template v-if="userForm.errors.role" #validationMessage>
                        {{ userForm.errors.role }}
                    </template>
                </fwb-select>
            </div>
        </div>
        <button :disabled="userForm.processing" :class="{ 'opacity-25': userForm.processing }" type="submit"
                class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            <svg v-if="user" class="me-1 -ms-1 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                 height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
            </svg>
            <svg v-else class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                      d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                      clip-rule="evenodd"></path>
            </svg>
            {{ user ? 'Save' : 'Add' }}
        </button>
    </form>
</template>
