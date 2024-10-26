<script setup>
import {FwbCheckbox, FwbInput} from "flowbite-vue";
import {provide, ref} from "vue";
import debounce from "@/Utils/debounce.js";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    queryWords: String,
    rolesFilter: Array
})

const queryWords = ref('');

const isShowCreateUserModal = ref(false);
const isShowEditUserModal = ref(false);
const isShowResetPasswordModal = ref(false);
const isShowDeleteUserModal = ref(false);

const searchRoles = debounce(() => {
    router.get(route('users.index'), {
        q: queryWords.value
    })
}, 1000)

let roleSelectedFilters = [];
const roleSelected = (role) => {
    if (roleSelectedFilters.includes(role)) {
        roleSelectedFilters = roleSelectedFilters.filter(item => item !== role)
    } else {
        roleSelectedFilters.push(role)
    }
    router.visit(route('users.index', {role: roleSelectedFilters.join(',')}), {
        only: ['list'],
    })
}

provide('showModal', {
    isShowCreateUserModal,
    isShowEditUserModal,
    isShowResetPasswordModal,
    isShowDeleteUserModal
})
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
                <button @click="isShowCreateUserModal = true" type="button"
                        class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    <svg class="h-5 w-5 mr-1.5" fill="currentColor" viewbox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                              d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                    </svg>
                    New
                </button>
                <div class="flex items-center space-x-3 w-full md:w-auto">
                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown"
                            class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                            type="button">
                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                        Actions
                    </button>
                    <div id="actionsDropdown"
                         class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="actionsDropdownButton">
                            <li>
                                <a href="#"
                                   class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass
                                    Delete</a>
                            </li>
                        </ul>
                        <div class="py-1">
                            <a href="#"
                               class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete
                                all</a>
                        </div>
                    </div>
                    <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                            class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                            type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                             class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                  clip-rule="evenodd"/>
                        </svg>
                        Filter
                        <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </button>
                    <div id="filterDropdown"
                         class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                        <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose role</h6>
                        <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                            <li v-for="role in rolesFilter" class="flex items-center">
                                <fwb-checkbox @change="roleSelected(role.value)" :label="role.name+'('+role.count+')'"/>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <slot/>
    </div>
</template>
