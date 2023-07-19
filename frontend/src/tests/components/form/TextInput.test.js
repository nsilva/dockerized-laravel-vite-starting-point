/**
 * @vitest-environment happy-dom
 */

import { describe, it, expect } from "vitest";
import { mount } from "@vue/test-utils";
import TextInput from "@/components/form/TextInput.vue"

describe ('Test input tests', () => {
    it ('should render input elements', () => {
        const wrapper = mount(TextInput, {
            propsData: {
                label: '',
                modelValue: '',
                type: 'input'
            },
        })

        expect(wrapper.find('label').exists()).toBeFalsy()
        expect(wrapper.find('input').exists()).toBeTruthy()

        it("emits input value when changed", async () => {
            // Assert input value gets the new value
            await wrapper.find("input").setValue("New Test Value");
            expect(wrapper.props("modelValue")).toBe("New Test Value");
        });

        const labelWrapper = mount(TextInput, {
            propsData: {
                label: 'Input lable',
                modelValue: '',
                type: 'input'
            }
        })

        expect(labelWrapper.find('label').exists()).toBeTruthy()
    })
})