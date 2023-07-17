<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Todo from '@/components/todos/Todo.vue';
import TodoCreator from '@/components/todos/TodoCreator.vue';
import { fetchTodos, addTodo } from '@/services/api.js';

const router = useRouter()
const todos = ref([]);

onMounted(async () => {
    todos.value = await fetchTodos();
});

const handleAddTodo = async (title) => {
    const newTodo = await addTodo(title);
    todos.value.push(newTodo);
};

</script>

<template>
    <div>
        <h1>Todos</h1>
        <TodoCreator @todoCreated="handleAddTodo" />
        <ul>
            <li v-for="todo in todos" :key="todo.id">
                <Todo :title="todo.title" />

                <ul v-if="todo.subtasks?.length > 0">
                    <li v-for="subtask in todo.subtasks" :key="subtask.id">
                        <Todo :title="subtask.title" :is-subtask="true"/>
                    </li>
                </ul>
            </li>
        
        </ul>
    </div>
</template>
