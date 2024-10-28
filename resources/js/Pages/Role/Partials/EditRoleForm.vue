<script setup>
import {FwbCheckbox, FwbInput, FwbSelect} from "flowbite-vue";
import {useForm} from "@inertiajs/vue3";
import {onMounted} from "vue";

const props = defineProps({
    role: Object
})

const emit = defineEmits(['submitted'])

const roleForm = useForm({
    name: '',
    order: 0,
    is_super_admin: false
})

const createRole = () => {
    roleForm.post(route('roles.store'), {
        errorBag: 'createRole',
        preserveScroll: false,
        onSuccess: () => {
            roleForm.reset()
            roleForm.clearErrors()
            emit('submitted')
        }
    })
}

const updateRole = () => {
    roleForm.put(route('roles.update', props.role), {
        errorBag: 'updateRole',
        preserveScroll: false,
        onSuccess: () => {
            roleForm.reset()
            roleForm.clearErrors()
            emit('submitted')
        }
    })
}

const submitForm = () => {
    if (props.role) {
        updateRole()
    } else {
        createRole()
    }
}

onMounted(() => {
    if (props.role) {
        roleForm.name = props.role.name
        roleForm.order = props.role.order
        roleForm.is_super_admin = props.role.is_super_admin === 1
    }
})
</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="grid gap-4 mb-4 grid-cols-2">
            <div class="col-span-2">
                <fwb-input class="focus:ring-primary-500 focus:border-primary-500"
                           :validation-status="roleForm.errors.name?'error':''" v-model="roleForm.name"
                           label="Name" placeholder="Type role name">
                    <template v-if="roleForm.errors.name" #validationMessage>
                        {{ roleForm.errors.name }}
                    </template>
                </fwb-input>
            </div>
            <div class="col-span-2">
                <fwb-input type="number" class="focus:ring-primary-500 focus:border-primary-500"
                           :validation-status="roleForm.errors.order?'error':''" v-model="roleForm.order"
                           label="Order" placeholder="Type display order">
                    <template v-if="roleForm.errors.order" #validationMessage>
                        {{ roleForm.errors.order }}
                    </template>
                </fwb-input>
            </div>
            <div class="col-span-2">
                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Other</div>
                <fwb-checkbox v-model="roleForm.is_super_admin" label="Whether this role is super admin"/>
            </div>
        </div>
        <button :disabled="roleForm.processing" :class="{ 'opacity-25': roleForm.processing }" type="submit"
                class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            <svg v-if="role" class="me-1 -ms-1 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
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
            {{ role ? 'Save' : 'Add' }}
        </button>
    </form>
</template>
