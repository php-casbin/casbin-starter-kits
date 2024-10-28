<script setup>
import {computed} from "vue";

const props = defineProps({
    color: String,
    desc: String
})

const wrapperClasses = computed(() => {
    return props.color === 'green' ? 'h-2.5 w-2.5 rounded-full bg-green-500 me-2' : 'h-2.5 w-2.5 rounded-full bg-red-500 me-2'
})
</script>

<template>
    <div class="flex items-center">
        <div :class="wrapperClasses"></div>{{desc}}
    </div>
</template>
