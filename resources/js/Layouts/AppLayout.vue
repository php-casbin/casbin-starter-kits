<script setup>
import Navbar from "@/Components/Navbar.vue";
import Sidebar from "@/Components/Sidebar.vue";
import MenuLink from "@/Components/MenuLink.vue";
import ActionMessages from "@/Components/ActionMessages.vue";
import {onMounted} from "vue";
import {initFlowbite} from "flowbite";
import {router, Head} from "@inertiajs/vue3";

const props = defineProps({
    title: String
});

console.log(props.title)

const logout = () => {
    router.post(route('logout'));
};

onMounted(() => {
    initFlowbite();
});
</script>

<template>
    <Head :title="props.title"/>
    <div class="min-h-screen bg-gray-100">
        <div class="fixed bottom-8 left-1/2 z-50">
            <ActionMessages :flash="$page.props.flash"/>
        </div>
        <Navbar>
            <template #user-menu>
                <li>
                    <a @click="logout" href="#"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                       role="menuitem">Sign out</a>
                </li>
            </template>
        </Navbar>
        <Sidebar>
            <template v-for="item in $page.props.initialData.menu">
                <li v-if="item.children.length > 0">
                    <button type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            :aria-controls="'dropdown-' + item.id" :data-collapse-toggle="'dropdown-' + item.id">
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ item.title }}</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <ul :id="'dropdown-' + item.id" class="py-2 space-y-2">
                        <li v-for="child in item.children">
                            <MenuLink :href="route(child.identifier)" :active="route().current(child.identifier)">
                                {{ child.title }}
                            </MenuLink>
                        </li>
                    </ul>
                </li>
            </template>
        </Sidebar>
        <main>
            <div class="p-4 sm:ml-64 mt-14">
                <slot/>
            </div>
        </main>
    </div>
</template>
