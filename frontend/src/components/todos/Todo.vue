<script setup>

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    isSubtask: {
        type: Boolean,
        required: false,
        default: false
    }
});
</script>

<template>
    <div :class="{ 'ml-2' : isSubtask}">{{ title }}</div>
</template>
  