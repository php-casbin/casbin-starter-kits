<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group bg-gray-100 dark:text-white dark:hover:bg-gray-700'
        : 'flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
