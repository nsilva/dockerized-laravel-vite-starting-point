/**
 * @vitest-environment happy-dom
 */

import { describe, it, expect } from "vitest";
import { mount } from "@vue/test-utils";
import Form from "@/components/form/Form.vue"

describe ('Form tests', () => {
    it ('should render form', () => {
        const wrapper = mount(Form)

        // Has form tag
        expect(wrapper.find('form').exists()).toBeTruthy()
    })
})