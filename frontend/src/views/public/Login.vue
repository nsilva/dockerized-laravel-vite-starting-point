<script setup>
import { ref } from 'vue';
import { useRouter, RouterLink } from 'vue-router';
import { login } from '@/services/api.js';
import FormContaner from '@/components/form/FormContainer.vue';
import Form from '@/components/form/Form.vue';
import TextInput from '@/components/form/TextInput.vue';

const router = useRouter()
const formData = ref({
    email:    'nahuns@gmail.com',
    password: '12345678',
    disabled: false
});

const errorMessage = ref('')

const handleLogin = async (data) => {
    errorMessage.value = ''
    formData.value.disabled = true

    const response = await login(data);
    
    if (response.status == 200) {
        console.log("sucecsss")
        const accessToken = response.data.data.access_token;
        localStorage.setItem('accessToken', accessToken);
        router.push('/todos');
    } else {
        errorMessage.value = response.data.message;
        formData.value.disabled = false
    }
};

</script>
<template>
    <div>
      <main>
        <section>
          <div class="main-container">
            <FormContaner>
                <div class="form-error">
                    <p v-if="errorMessage" class="form-error-message">{{ errorMessage }}</p>
                </div>

                <Form :initialFormData="formData" @formSubmitted="handleLogin">
                    <div class="text-input-container">
                        <TextInput v-model="formData.email" label="Email" type="text" :disabled="formData.disabled"/>
                    </div>
                    <div class="text-input-container">
                        <TextInput v-model="formData.password" label="Password" type="password" :disabled="formData.disabled"/>
                    </div>
                    <div class="button-container">
                        <button
                            class="login-button"
                            type="submit"
                            :disabled="formData.disabled">
                            Sign In
                        </button>
                    </div>
                </Form>

                <div class="form-footer">
                    <div class="w-1/2">
                        <RouterLink to="/register"><small>Create account</small></RouterLink>
                    </div>
                    
                </div>
            </FormContaner>

          </div>
        </section>
      </main>
    </div>
</template>
 
<style scoped>
    section {
        @apply absolute w-full h-full
    }

    .main-container {
        @apply container mx-auto px-4 h-full
    }

    .form-error {
        @apply relative w-full mb-3
    }

    .form-error-message {
        @apply text-red-700
    }

    .text-input-container {
        @apply relative w-full mb-3
    }

    .button-container {
        @apply text-center mt-6
    }

    .login-button {
        @apply bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full
    }
    
    .form-footer {
        @apply flex flex-wrap mt-6
    }
</style>