<script setup>
import { ref } from 'vue';
import TextInput from '@/components/form/TextInput.vue';

const newTodoText = ref('');

const createTodo = () => {
    if (newTodoText.value) {
        emit('todoCreated', newTodoText.value);
        newTodoText.value = '';
    }
};

const emit = defineEmits(['todoCreated']);
</script>

<template>
    <div>
        <TextInput v-model="newTodoText" placeholder="Enter a new todo" />
        <button @click="createTodo">Submit</button>
    </div>
</template>

  