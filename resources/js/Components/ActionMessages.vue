<script setup>
import {FwbToast} from "flowbite-vue";
import {computed, onMounted, watch} from "vue";

const props = defineProps({
    flash: Object
})

const toastText = computed(() => {
    return props.flash.success || props.flash.error
})

watch(toastText, (newValue) => {
    if (newValue) {
        setTimeout(() => {
            props.flash.success = null
            props.flash.error = null
        }, 3000)
    }
})
</script>

<template>
    <transition
        enter-active-class="ease-in duration-500"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="ease-in duration-1000"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0">
        <fwb-toast v-if="flash.success" class="shadow-md" type="success">
            {{ flash.success }}
        </fwb-toast>
    </transition>
    <transition
        enter-active-class="ease-in duration-500"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="ease-in duration-1000"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0">
        <fwb-toast v-if="flash.error" class="shadow-md" type="danger">
            {{ flash.error }}
        </fwb-toast>
    </transition>
</template>
