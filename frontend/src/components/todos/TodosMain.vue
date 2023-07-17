<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { Icon } from '@iconify/vue';
import Todo from '@/components/todos/Todo.vue';
import TodoCreator from '@/components/todos/TodoCreator.vue';
import { fetchTodos, addTodo } from '@/services/api.js';

const router = useRouter()
const todos = ref([]);
const selectedTodo = ref(0);
const icon = ref('la:angle-right')

onMounted(async () => {
    todos.value = await fetchTodos();
});

const handleAddTodo = async (todo) => {
    const newTodo = await addTodo(todo);
    if (!todo.parent_id) {
        todos.value.unshift(newTodo);
    } else {
        const parentTodo = todos.value.find(item => item.id == newTodo.parent_id)
        parentTodo.subtasks.unshift(newTodo)
    }
};

const showSelected = (selectedId) => {
    icon.value = (icon.value == 'la:angle-right') ? 'la:angle-down' : 'la:angle-right'
    selectedTodo.value = selectedId != selectedTodo.value ? selectedId : 0
}

</script>

<template>
    <div>
        
        <TodoCreator @todoCreated="handleAddTodo" />
        
        <ul>
            <li v-for="todo in todos" :key="todo.id">
                <Todo :title="todo.title" />
                <a @click.prevent="showSelected(todo.id)" href="#">
                    <small>Add subtask <Icon :icon="icon" class="inline align-sub"/></small>
                </a>
                
                <div>
                    <div v-if="selectedTodo == todo.id">
                        <TodoCreator @todoCreated="handleAddTodo" :parent-id="todo.id"/>
                    </div>
                    <ul v-if="todo.subtasks?.length > 0">
                        <li v-for="subtask in todo.subtasks" :key="subtask.id">
                            <Todo :title="subtask.title" :is-subtask="true"/>
                        </li>
                    </ul>
                </div>
            </li>
        
        </ul>
    </div>
</template>
