<script setup>
import { ref, onMounted } from 'vue';
import Todo from '@/components/todos/Todo.vue';
import TodoCreator from '@/components/todos/TodoCreator.vue';
import { fetchTodos, addTodo } from '@/services/api.js';

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
        <Todo :text="todo.title" />
      </li>
    </ul>
  </div>
</template>
