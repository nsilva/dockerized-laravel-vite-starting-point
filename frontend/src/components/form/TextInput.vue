<script setup>
import { defineProps } from 'vue';

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
  <div>
    <label v-if="label != ''" class="block uppercase text-gray-700 text-xs font-bold mb-2">{{ label }}</label>
    <input :type="type" 
        :value="modelValue" 
        @input="$emit('update:modelValue', $event.target.value)"
        class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 rounded text-sm shadow focus:outline-none focus:ring w-full"
        :disabled="disabled"
        :class="{ 'bg-gray-200	' : disabled}">
    <small v-if="error !== ''" class="text-red-700">{{ error[0] }}</small>
  </div>
</template>

