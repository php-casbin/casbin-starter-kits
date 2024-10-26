<script setup>
import {computed} from "vue";

const props = defineProps({
    color: String
});

const wrapperClasses = computed(() => {
    let base = 'text-xs font-medium me-2 px-2.5 py-0.5 rounded';
    switch (props.color) {
        case 'default':
            return `${base} bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300`;
        case 'dark':
            return `${base} bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300`;
        case 'red':
            return `${base} bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300`;
        case 'green':
            return `${base} bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300`;
        case 'yellow':
            return `${base} bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300`;
        case 'indigo':
            return `${base} bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300`;
        case 'purple':
            return `${base} bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300`;
        case 'pink':
            return `${base} bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-300`;
        default:
            return `${base} bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300`;
    }
});
</script>

<template>
    <span :class="wrapperClasses">
        <slot/>
    </span>
</template>
