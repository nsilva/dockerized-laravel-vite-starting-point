<template>
  <div>
    <label>{{ label }}</label>
    <input type="text" :value="modelValue" @input="updateModelValue($event.target.value)">
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  modelValue: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
});

const emit = defineEmits(['update:modelValue']);

const updateModelValue = (newValue) => {
  emit('update:modelValue', newValue);
};
</script>
