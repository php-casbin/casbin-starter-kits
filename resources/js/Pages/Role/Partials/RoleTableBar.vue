<script setup>
import {FwbInput} from "flowbite-vue";
import debounce from "@/Utils/debounce.js";
import {provide, ref} from "vue";
import {router} from "@inertiajs/vue3";

const queryWords = ref('');

const isShowCreateRoleModal = ref(false);
const isShowEditRoleModal = ref(false);
const isShowDeleteRoleModal = ref(false);

const searchRoles = debounce(() => {
    console.log('searchRoles', queryWords.value)
    router.get(route('roles.index'), {
        q: queryWords.value
    })
}, 1000)

provide('showModal', {
    isShowCreateRoleModal,
    isShowEditRoleModal,
    isShowDeleteRoleModal,
});
</script>

<template>
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="w-full md:w-1/2">
                <form class="flex items-center">
                    <div class="relative w-full">
                        <fwb-input type="text" v-model="queryWords" @input="searchRoles"
                                   class="focus:ring-primary-500 focus:border-primary-500" placeholder="Search"
                                   size="sm">
                            <template #prefix>
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                     fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </template>
                        </fwb-input>
                    </div>
                </form>
            </div>
            <div
                class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                <button @click="isShowCreateRoleModal = true" type="button"
                        class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    <svg class="h-5 w-5 mr-1.5" fill="currentColor" viewbox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                              d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                    </svg>
                    New
                </button>
            </div>
        </div>
        <slot />
    </div>
</template>
