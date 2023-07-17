<script setup>
import { ref } from 'vue';
import TextInput from '@/components/form/TextInput.vue';

const props = defineProps({
    parentId: {
        type: Number,
        required: false,
        default: 0
    }
});

const emit = defineEmits(['todoCreated']);
const newTodoTitle = ref('');

const createTodo = () => {
    if (newTodoTitle.value) {
        const todo = {title: newTodoTitle.value};
        if (props.parentId !== 0) {
            todo.parent_id = props.parentId
        }

        emit('todoCreated', todo);
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

  