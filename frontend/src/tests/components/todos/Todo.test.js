/**
 * @vitest-environment happy-dom
 */

import { describe, it, expect } from "vitest";
import { mount } from "@vue/test-utils";
import Todo from "@/components/todos/Todo.vue"

describe ('Todo tests', () => {
    it ('should render todo', async () => {
        const wrapper = mount(Todo, {
            propsData: {
                todo: {
                    id: 1,
                    title: 'Todo title',
                    status: 'in progress',
                    subtasks: [
                        {
                            id: 2,
                            title: "Subtask title",
                            status: "complete"
                        }
                    ]
                }
            }
        })

        // Has form tag
        expect(wrapper.text()).toContain('Todo title')
        expect(wrapper.text()).toContain('Subtask title')

        // Subtask input
        expect(wrapper.find('input').exists()).toBeFalsy()
        
        const subtaskLink = wrapper.find('a.add-subtask')
        await subtaskLink.trigger('click')
        expect(wrapper.find('input').exists()).toBeTruthy()
    })
})