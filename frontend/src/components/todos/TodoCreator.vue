<script setup>
import { ref } from 'vue';
import { Icon } from '@iconify/vue';
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
    <div class="pb-3">
        <TextInput v-model="newTodoTitle" placeholder="Enter a new to-do..." type="text" @keydown.enter="createTodo" icon="mi:enter"/>
        <small class="text-gray-500">Type and hit enter <Icon icon="mi:enter" class="inline align-sub"/></small>
    </div>
</template>

  