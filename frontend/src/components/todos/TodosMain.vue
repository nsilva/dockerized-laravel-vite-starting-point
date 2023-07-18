<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { Icon } from '@iconify/vue';
import Todo from '@/components/todos/Todo.vue';
import TodoCreator from '@/components/todos/TodoCreator.vue';
import { fetchTodos, addTodo, updateTodo } from '@/services/api.js';

const router = useRouter()
const todos = ref([]);
const selectedTodo = ref(0);

onMounted(async () => {
    todos.value = await fetchTodos();
});

const handleAddTodo = async (todo) => {
    console.log(todo)
    const newTodo = await addTodo(todo);
    if (!todo.parent_id) {
        todos.value.unshift(newTodo);
    } else {
        const parentTodo = todos.value.find(item => item.id == newTodo.parent_id)
        parentTodo.subtasks.unshift(newTodo)
    }
};

const handleUpdateTodo = async (data) => {
    const updatedTodo = await updateTodo(data.id, data.status)
    
    if (!updatedTodo.parent_id) {
        let affectedIndex = null
        todos.value.find((item, index) => {
            if (item.id == updatedTodo.id) {
                affectedIndex = index    
                return true;
            }
        })

        // Fully replace todo in case subtasks are affected
        if (affectedIndex !== null) {
            todos.value[affectedIndex] = updatedTodo
        }
    } else {
        let affectedTodo = null

        todos.value.some((todo) => {
            affectedTodo = todo.subtasks.find((subtask) => subtask.id === updatedTodo.id)
            return affectedTodo
        });
        
        if (affectedTodo !== null) {
            affectedTodo.status = updatedTodo.status
        }
    }
};

</script>

<template>
    <div>
        
        <TodoCreator @todoCreated="handleAddTodo" />
        
        <ul>
            <li v-for="todo in todos" :key="todo.id">
                <Todo :todo="todo" @todoCreated="handleAddTodo" @todoUpdated="handleUpdateTodo"/>
            </li>
        
        </ul>
    </div>
</template>
