<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {inject, onMounted, ref} from "vue";
import {initDropdowns, initFlowbite} from "flowbite";
import Pagination from "@/Components/Pagination.vue";
import {FwbModal} from "flowbite-vue";
import Badge from "@/Components/Badge.vue";
import EditRoleForm from "@/Pages/Role/Partials/EditRoleForm.vue";
import DeleteRoleForm from "@/Pages/Role/Partials/DeleteRoleForm.vue";
import RoleTableBar from "@/Pages/Role/Partials/RoleTableBar.vue";

const props = defineProps({
    list: Object
})

const {isShowCreateRoleModal, isShowEditRoleModal, isShowDeleteRoleModal} = inject('showModal');
const roleToOperate = ref(null);

const showCreateRoleModal = () => {
    isShowCreateRoleModal.value = true;
}

const showEditRoleModal = (role) => {
    isShowEditRoleModal.value = true;
    roleToOperate.value = role;
}

const showDeleteRoleModal = (role) => {
    isShowDeleteRoleModal.value = true;
    roleToOperate.value = role;
}

const refreshList = () => {
    isShowCreateRoleModal.value = false;
    isShowEditRoleModal.value = false;
    isShowDeleteRoleModal.value = false;

    initDropdowns();
}

defineOptions({
    layout: (h, page) => {
        return h(AppLayout, {
            title: 'Roles',
        },() => h(RoleTableBar, () => page))
    }
})

onMounted(() => {
    initFlowbite();
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
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-all" class="sr-only">checkbox</label>
                    </div>
                </th>
                <th scope="col" class="px-4 py-3">Name</th>
                <th scope="col" class="px-4 py-3">Identifier</th>
                <th scope="col" class="px-4 py-3">Order</th>
                <th scope="col" class="px-4 py-3">Special</th>
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
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-table-1" class="sr-only">checkbox</label>
                    </div>
                </td>
                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                        item.name
                    }}
                </td>
                <td class="px-4 py-3">{{ item.identifier }}</td>
                <td class="px-4 py-3">{{ item.order }}</td>
                <td class="px-4 py-3">
                    <Badge color="purple" v-if="item.is_super_admin">Super Admin</Badge>
                    <Badge v-else>Normal</Badge>
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
                                    <a @click="showEditRoleModal(item)" href="#"
                                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                </li>
                            </ul>
                            <div class="py-1">
                                <a @click="showDeleteRoleModal(item)" href="#"
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
    <fwb-modal v-if="isShowCreateRoleModal" @close="isShowCreateRoleModal = false">
        <template #header>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Create Role</h3>
        </template>
        <template #body>
            <EditRoleForm @submitted="refreshList"/>
        </template>
    </fwb-modal>
    <fwb-modal v-if="isShowEditRoleModal" @close="isShowEditRoleModal = false">
        <template #header>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Edit Role</h3>
        </template>
        <template #body>
            <EditRoleForm :role="roleToOperate" @submitted="refreshList"/>
        </template>
    </fwb-modal>
    <fwb-modal v-if="isShowDeleteRoleModal" @close="isShowDeleteRoleModal = false">
        <template #header>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Delete Role</h3>
        </template>
        <template #body>
            <DeleteRoleForm :role="roleToOperate" @cancel="isShowDeleteRoleModal = false" @submitted="refreshList"/>
        </template>
    </fwb-modal>
</template>
