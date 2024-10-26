<script setup>
import { onMounted, ref } from 'vue';
import {FwbInput} from "flowbite-vue";

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <fwb-input
        ref="input"
        class="focus:border-primary-500 focus:ring-primary-500"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    />
</template>
