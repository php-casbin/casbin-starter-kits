<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import StatusDot from "@/Components/StatusDot.vue";
import BadgeLine from "@/Components/BadgeLine.vue";
import EditUserForm from "@/Pages/User/Partials/EditUserForm.vue";
import ResetPasswordForm from "@/Pages/User/Partials/ResetPasswordForm.vue";
import DeleteUserForm from "@/Pages/User/Partials/DeleteUserForm.vue";
import {inject, onMounted, ref} from "vue";
import {initDropdowns, initFlowbite} from "flowbite";
import {FwbModal} from "flowbite-vue";
import UserTableBar from "@/Pages/User/Partials/UserTableBar.vue";

const props = defineProps({
    list: Object,
    rolesFilter: Array
})

const {
    isShowCreateUserModal,
    isShowEditUserModal,
    isShowResetPasswordModal,
    isShowDeleteUserModal
} = inject('showModal')
const userToOperate = ref(null)

const showUserDeleteModal = (user) => {
    isShowDeleteUserModal.value = true
    userToOperate.value = user
}

const showUserEditModal = (user) => {
    isShowEditUserModal.value = true
    userToOperate.value = user
}

const showResetPasswordModal = (user) => {
    isShowResetPasswordModal.value = true
    userToOperate.value = user
}

const refreshList = () => {
    isShowCreateUserModal.value = false
    isShowEditUserModal.value = false
    isShowResetPasswordModal.value = false
    isShowDeleteUserModal.value = false

    initDropdowns()
}

defineOptions({
    layout: (h, page) => {
        return h(AppLayout, {
            title: 'Users',
        }, () => h(UserTableBar, () => page))
    }
})

onMounted(() => {
    initFlowbite()
});
</script>

<template>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <input id="checkbox-all" type="checkbox"
                               class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-all" class="sr-only">checkbox</label>
                    </div>
                </th>
                <th scope="col" class="px-4 py-3">Name</th>
                <th scope="col" class="px-4 py-3">Organization</th>
                <th scope="col" class="px-4 py-3">Role</th>
                <th scope="col" class="px-4 py-3">Status</th>
                <th scope="col" class="px-4 py-3">Created</th>
                <th scope="col" class="px-4 py-3">
                    <span class="sr-only">Actions</span>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in list.data" class="border-b dark:border-gray-700">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input id="checkbox-table-1" type="checkbox"
                               class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-table-1" class="sr-only">checkbox</label>
                    </div>
                </td>
                <th scope="row"
                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                    <img class="w-10 h-10 rounded-full" :src="item.profile_photo_url" alt="Jese image">
                    <div class="ps-3">
                        <div class="text-base font-semibold">{{ item.name }}</div>
                        <div class="font-normal text-gray-500">{{ item.email }}</div>
                    </div>
                </th>
                <td class="px-4 py-3">
                    <BadgeLine :id="item.id" :list="item.organizations" :capacity="2"></BadgeLine>
                </td>
                <td class="px-4 py-3">
                    <BadgeLine :id="item.id" :list="item.roles" :capacity="2"></BadgeLine>
                </td>
                <td class="px-4 py-3">
                    <StatusDot v-if="item.disabled" color="red" desc="Inactive"/>
                    <StatusDot v-else color="green" desc="Active"/>
                </td>
                <td class="px-4 py-3">{{ item.created_at }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-center">
                        <button :id="item.id + '-dropdown-button'" :data-dropdown-toggle="item.id + '-dropdown'"
                                class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                type="button">
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                            </svg>
                        </button>
                        <div :id="item.id + '-dropdown'"
                             class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                :aria-labelledby="item.id + '-dropdown-button'">
                                <li>
                                    <a @click="showUserEditModal(item)" href="#"
                                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                </li>
                                <li>
                                    <a @click="showResetPasswordModal(item)" href="#"
                                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reset
                                        Password</a>
                                </li>
                            </ul>
                            <div class="py-1">
                                <a @click="showUserDeleteModal(item)" href="#"
                                   class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <Pagination :total="list.total" :currentLength="list.data.length" :currentPage="list.current_page"
                :lastPage="list.last_page" :perPage="list.per_page" :prevPageUrl="list.prev_page_url"
                :nextPageUrl="list.next_page_url"/>
    <fwb-modal v-if="isShowCreateUserModal" @close="isShowCreateUserModal = false">
        <template #header>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Create New User
            </h3>
        </template>
        <template #body>
            <EditUserForm :roles="rolesFilter" @submitted="refreshList"/>
        </template>
    </fwb-modal>
    <fwb-modal v-if="isShowEditUserModal" @close="isShowEditUserModal = false">
        <template #header>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Edit User
            </h3>
        </template>
        <template #body>
            <EditUserForm :user="userToOperate" :roles="rolesFilter" @submitted="refreshList"/>
        </template>
    </fwb-modal>
    <fwb-modal v-if="isShowResetPasswordModal" @close="isShowResetPasswordModal = false">
        <template #header>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Reset Password
            </h3>
        </template>
        <template #body>
            <ResetPasswordForm :user="userToOperate" @submitted="refreshList"/>
        </template>
    </fwb-modal>
    <fwb-modal size="xl" v-if="isShowDeleteUserModal" @close="isShowDeleteUserModal = false">
        <template #header>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Delete User
            </h3>
        </template>
        <template #body>
            <DeleteUserForm :user="userToOperate" @submitted="refreshList" @cancel="isShowDeleteUserModal = false"/>
        </template>
    </fwb-modal>
</template>
