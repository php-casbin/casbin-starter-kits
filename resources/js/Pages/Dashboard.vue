<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import OverviewCard from '@/Components/OverviewCard.vue';
import NotificationList from '@/Components/NotificationList.vue';
import {FwbButton} from "flowbite-vue";

const props = defineProps({
    overviewData: Object,
    notifications: Array
})

defineOptions({
    layout: (h, page) => {
        return h(AppLayout, {
            title: 'Dashboard',
        }, () => h(page))
    }
})
</script>

<template>
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden p-4">
        <header class="text-2xl font-bold text-gray-800">Dashboard Workspace</header>
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <OverviewCard title="User Count" :value="overviewData.userCount"/>
            <OverviewCard title="Role Count" :value="overviewData.roleCount"/>
            <OverviewCard title="Permission Count" :value="overviewData.permissionCount"/>
            <OverviewCard title="Active User Count" :value="overviewData.activeUserCount"/>
        </section>

        <section class="space-y-3">
            <h2 class="text-xl font-semibold text-gray-700">Quick Actions</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <fwb-button color="light" size="xl">
                    <template #prefix>
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        New User
                    </template>
                </fwb-button>
                <fwb-button color="light" size="xl">
                    <template #prefix>
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                  d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                        </svg>
                        New Role
                    </template>
                </fwb-button>
                <fwb-button color="light" size="xl">
                    <template #prefix>
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                             viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                  d="M11.644 3.066a1 1 0 0 1 .712 0l7 2.666A1 1 0 0 1 20 6.68a17.694 17.694 0 0 1-2.023 7.98 17.406 17.406 0 0 1-5.402 6.158 1 1 0 0 1-1.15 0 17.405 17.405 0 0 1-5.403-6.157A17.695 17.695 0 0 1 4 6.68a1 1 0 0 1 .644-.949l7-2.666Zm4.014 7.187a1 1 0 0 0-1.316-1.506l-3.296 2.884-.839-.838a1 1 0 0 0-1.414 1.414l1.5 1.5a1 1 0 0 0 1.366.046l4-3.5Z"
                                  clip-rule="evenodd"/>
                        </svg>
                        Set Permission
                    </template>
                </fwb-button>
                <fwb-button color="light" size="xl">
                    <template #prefix>
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                  d="M6 4v10m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v2m6-16v2m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v10m6-16v10m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v2"/>
                        </svg>
                        System Settings
                    </template>
                </fwb-button>
            </div>
        </section>

        <section class="space-y-3">
            <h2 class="mt-3 text-xl font-semibold text-gray-700">Notifications</h2>
            <NotificationList :notifications="notifications"/>
        </section>
    </div>
</template>
