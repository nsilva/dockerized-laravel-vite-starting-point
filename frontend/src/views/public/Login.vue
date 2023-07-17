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
                            class="form-button"
                            type="submit"
                            :disabled="formData.disabled">
                            Sign In
                        </button>
                    </div>
                </Form>

                <div class="form-footer">
                    <div class="w-1/2">
                        <RouterLink to="/register">Create account</RouterLink>
                    </div>
                    
                </div>
            </FormContaner>

          </div>
        </section>
      </main>
    </div>
</template>
 
<style scoped>
    
</style>