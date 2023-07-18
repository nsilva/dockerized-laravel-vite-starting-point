<script setup>
import { ref } from 'vue';
import { useRouter, RouterLink } from 'vue-router';
import { createAccount } from '@/services/api.js';
import api from '@/services/api.js';
import FormContaner from '@/components/form/FormContainer.vue';
import Form from '@/components/form/Form.vue';
import TextInput from '@/components/form/TextInput.vue';

const router = useRouter()
const requestError = ref("");
const accountCreated = ref(false);
const formErrors = ref({});
const formData = ref({
    name:                  '',
    email:                 '',
    password:              '',
    password_confirmation: '',
    disabled:              false
});

const handleRegister = async (data) => {
    formErrors.value = {}
    requestError.value = ""
    formData.value.disabled = true

    const response = await createAccount(data);
    
    if (response.status == 201) {
        accountCreated.value = true
    } else {
        requestError.value = response.data.message;
        formErrors.value = response.data.data.errors;

        formData.value.disabled = false
    }
};

</script>

<template>
    <div>
      <main>
        <section>
          <div class="main-container">

            <h1 class="text-center mt-11 text-7xl">ToDoist</h1>
            
            <FormContaner>
                <div class="form-error">
                    <p v-if="requestError" class="form-error-message">{{ requestError }}</p>
                </div>
                
                <div v-if="accountCreated">
                    <h2>Accunt created!!</h2>
                    <p>Go to the <RouterLink to="/">sing in</RouterLink> screen to start.</p>
                </div>

                <Form :initialFormData="formData" @formSubmitted="handleRegister" v-if="!accountCreated">
                    <div class="text-input-container">
                        <TextInput v-model="formData.name" label="Name" type="text" :disabled="formData.disabled" :error="formErrors?.name"/>
                    </div>
                    <div class="text-input-container">
                        <TextInput v-model="formData.email" label="Email" type="text" :disabled="formData.disabled" :error="formErrors?.email"/>
                    </div>
                    <div class="text-input-container">
                        <TextInput v-model="formData.password" label="Password" type="password" :disabled="formData.disabled" :error="formErrors?.password"/>
                    </div>
                    <div class="text-input-container">
                        <TextInput v-model="formData.password_confirmation" label="Confirm Password" type="password" :disabled="formData.disabled"/>
                    </div>
                    <div class="button-container">
                        <button
                            class="form-button"
                            type="submit"
                            :disabled="formData.disabled">
                            Sign Up
                        </button>
                    </div>
                </Form>

                <div class="form-footer">
                    <div class="w-1/2">
                        <RouterLink to="/">Log in</RouterLink>
                    </div>
                </div>
            </FormContaner>

          </div>
        </section>
      </main>
    </div>
</template>
  