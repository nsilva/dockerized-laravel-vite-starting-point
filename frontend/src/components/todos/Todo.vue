<script setup>
const props = defineProps({
    text: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div>{{ text }}</div>
</template>
  