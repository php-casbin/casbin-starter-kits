<script setup>
import {router} from "@inertiajs/vue3";
import {ref} from "vue";

const emit = defineEmits(['submitted', 'cancel'])

const props = defineProps({
    role: Object
})

const processing = ref(false)

const deleteRole = () => {
    processing.value = true
    router.delete(route('roles.destroy', props.role), {
        preserveScroll: false,
        onSuccess: () => {
            processing.value = false
            emit('submitted')
        }
    })
}
</script>

<template>
    <form @submit.prevent="deleteRole">
        <div class="p-4 md:p-5 text-center">
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure delete this role?
            </h3>
            <button type="button" @click="emit('cancel')"
                    class="py-2.5 px-5 me-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                No
            </button>
            <button :disabled="processing" :class="{ 'opacity-25': processing }" type="submit"
                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                Yes
            </button>
        </div>
    </form>
</template>
