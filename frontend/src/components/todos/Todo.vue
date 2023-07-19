<script setup>
import { ref, defineEmits } from 'vue';
import { Icon } from '@iconify/vue';
import TodoCreator from '@/components/todos/TodoCreator.vue';

const props = defineProps({
    todo: {
        type: Object,
        required: true,
    }
});

const icon = ref('la:angle-right')
const showSub = ref(false)
const showOptions = ref(false)
const emit = defineEmits(['todoCreated', 'todoUpdated']);

const toggleSubTaskInput = () => {
    showSub.value = !showSub.value
    icon.value = icon.value == 'la:angle-down' ? 'la:angle-right' : 'la:angle-down'
}

const toggleOptions = () => {
    showOptions.value = !showOptions.value
}

const handleUpdateStatus = async (status) => {
    toggleOptions()
    emit('todoUpdated', {id: props.todo.id, status});
};

// Redirect to parent
const handleAddSubtask = (todo) => {
    emit('todoCreated', todo);
};

const handleSubtaskUpdate = (data) => {
    
    emit('todoUpdated', data);
}

</script>

<template>

    <div class="todo-container" :class="{ 'py-2 my-2 px-4' : todo?.parent_id == null}">
        <div :class="{ 'ml-2 !text-lg' : todo?.parent_id != null}" class="todo-box">
            <div class="todo-title" :class="{ 'bg-gray-200' : showOptions}">{{ todo.title }}</div>




            <div class="todo-options">
                <div class="todo-options-icons" >
                    
                    <div v-if="todo.status == 'not started'" class="inline">
                        <Icon icon="material-symbols:not-started" class="status-icon"></Icon>
                    </div>

                    <div v-if="todo.status == 'in progress'" class="inline text-yellow-500">
                        <Icon icon="carbon:in-progress" class="status-icon"></Icon>
                    </div>

                    <div v-if="todo.status == 'complete'" class="inline text-green-500">
                        <Icon icon="pajamas:todo-done" class="status-icon"></Icon>
                    </div>

                    <a @click="toggleOptions" :class="{ 'text-amber-700' : showOptions}">
                        <Icon icon="quill:cog" class="options-trigger"></Icon>
                    </a>
                </div>

                <div v-if="showOptions" class="options-box" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                    <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                    <div class="options-title" role="menuitem" tabindex="-1" id="menu-item-0">Set as:</div>
                    
                    <a href="#" class="text-gray-500 status-option" role="menuitem" tabindex="-1" id="menu-item-1" @click="handleUpdateStatus('not started')">
                        <Icon icon="material-symbols:not-started" class="status-icon"></Icon><small>Not Started</small>
                    </a>

                    <a href="#" class="text-yellow-500 status-option" role="menuitem" tabindex="-1" id="menu-item-2" @click="handleUpdateStatus('in progress')">
                        <Icon icon="carbon:in-progress" class="status-icon"></Icon><small>In Progress</small>
                    </a>

                    <a href="#" class="text-green-500 status-option" role="menuitem" tabindex="-1" id="menu-item-2" @click="handleUpdateStatus('complete')">
                        <Icon icon="pajamas:todo-done" class="status-icon"></Icon><small>Complete</small>
                    </a>
                    
                    </div>
                </div>
            </div>





        </div>

        <a @click.prevent="toggleSubTaskInput()" href="#" v-if="todo?.parent_id == null" class="add-subtask px-4">
            <small>Add subtask <Icon :icon="icon" class="inline align-sub"/></small>
        </a>
        
        <div class="pl-5 mt-2 relative">
            <div v-if="showSub">
                <TodoCreator @todoCreated="handleAddSubtask" :parent-id="todo.id"/>
            </div>
            <ul v-if="todo.subtasks?.length > 0">
                <li v-for="subtask in todo.subtasks" :key="subtask.id">
                    <Todo :todo="subtask" @todoUpdated="handleSubtaskUpdate"/>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
.todo-container {
    @apply bg-gray-100 rounded-md;

    .todo-box {
        @apply text-gray-500 text-xl relative;

        .todo-title {
            @apply px-4 py-3 rounded;
        }
        .todo-options {
            @apply absolute inline-block text-left right-1 top-1;

            .todo-options-icons {
                @apply text-xl cursor-pointer;

                .status-icon {
                    @apply inline align-sub mr-2;
                }
                .options-trigger {
                    @apply inline align-sub cursor-pointer;
                }
            }

            .options-box {
                @apply absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none;
                .options-title {
                    @apply text-gray-700 block px-4 py-2 text-sm;
                }
                .status-option {
                    @apply block px-4 py-2 cursor-pointer;
                    .status-icon {
                        @apply inline align-text-bottom mr-2;
                    }
                }
                
            }

        }
    }
}









</style>
  