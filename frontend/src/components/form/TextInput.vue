<script setup>
import { Icon } from '@iconify/vue';

const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: false,
        default: ''
    },
    type: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        required: false,
        default: ''
    },
    icon: {
        type: String,
        required: false,
        default: ''
    },
    disabled: {
        type: Boolean,
        required: false,
        default: false
    },
    error: {
        type: Array,
        required: false,
        default: []
    },
});
</script>

<template>
  <div class="relative">

    <label v-if="label != ''" class="text-input-label">{{ label }}</label>
    <div class="absolute inset-y-0 right-1 flex items-center pl-2 text-4xl text-stone-300" v-if="icon != ''">
        <Icon :icon="icon" />
    </div>
    <input :type="type" 
        :value="modelValue" 
        @input="$emit('update:modelValue', $event.target.value)"
        class="text-input"
        :disabled="disabled"
        :class="{ 'bg-gray-200	' : disabled}" 
        :placeholder="placeholder">
    <small v-if="error !== ''" class="text-red-700">{{ error[0] }}</small>
  </div>
</template>

<style scoped>
    .text-input-label {
        @apply block uppercase text-gray-700 text-xs font-bold mb-2
    }

    .text-input {
        @apply border-0 px-3 py-3 placeholder-gray-400 text-gray-500 rounded text-xl shadow focus:outline-none focus:ring w-full
    }
</style>

