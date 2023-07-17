<script setup>
import { ref } from 'vue';
import TextInput from '@/components/form/TextInput.vue';

const emit = defineEmits(['todoCreated']);
const newTodoTitle = ref('');

const createTodo = () => {
    if (newTodoTitle.value) {
        emit('todoCreated', newTodoTitle.value);
        newTodoTitle.value = '';
    }
};

</script>

<template>
    <div>
        <TextInput v-model="newTodoTitle" placeholder="Enter a new todo" type="text" @keydown.enter="createTodo"/>
        <button @click="createTodo">Submit</button>
    </div>
</template>

  