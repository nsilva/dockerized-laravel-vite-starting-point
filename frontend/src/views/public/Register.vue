<script setup>
    import { ref } from 'vue';
    import { useRouter, RouterLink } from 'vue-router';
    import api from '@/services/api.js';
    import FormContaner from '@/components/form/FormContainer.vue';
    import Form from '@/components/form/Form.vue';
    import TextInput from '@/components/form/TextInput.vue';
    
    const router = useRouter()
    const requestError = ref("");
    const formErrors = ref({});
    const formData = ref({
        name:                  '',
        email:                 '',
        password:              '',
        password_confirmation: '',
        disabled:              false
    });
    
    const handleFormSubmission = (data) => {
        formErrors.value = {}
        requestError.value = ""
        formData.value.disabled = true
        
        api
            .post('/api/users', data)
            .then((response) => {
                // Assuming the API response contains an access token
                //const accessToken = response.data.access_token;
                //localStorage.setItem('accessToken', accessToken);
                router.push('/todos');
            })
            .catch((error) => {
                console.log(error)
                requestError.value = error.response.data.message;
                formErrors.value = error.response.data.data.errors;

                formData.value.disabled = false
            });
    };
</script>

<template>
    <div>
      <main>
        <section class="absolute w-full h-full">
          <div class="container mx-auto px-4 h-full">
            <FormContaner>
                <div class="relative w-full mb-3">
                    <p v-if="requestError" class="text-red-700">{{ requestError }}</p>
                </div>

                <Form :initialFormData="formData" @formSubmitted="handleFormSubmission">
                    <div class="relative w-full mb-3">
                        <TextInput v-model="formData.name" label="Name" type="text" :disabled="formData.disabled" :error="formErrors?.name"/>
                    </div>
                    <div class="relative w-full mb-3">
                        <TextInput v-model="formData.email" label="Email" type="text" :disabled="formData.disabled" :error="formErrors?.email"/>
                    </div>
                    <div class="relative w-full mb-3">
                        <TextInput v-model="formData.password" label="Password" type="password" :disabled="formData.disabled" :error="formErrors?.password"/>
                    </div>
                    <div class="relative w-full mb-3">
                        <TextInput v-model="formData.password_confirmation" label="Confirm Password" type="password" :disabled="formData.disabled"/>
                    </div>
                    <div class="text-center mt-6">
                        <button
                            class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full"
                            type="submit"
                            :disabled="formData.disabled">
                            Sign Up
                        </button>
                    </div>
                </Form>

                <div class="flex flex-wrap mt-6">
                    <div class="w-1/2">
                        <RouterLink to="/"><small>Log in</small></RouterLink>
                    </div>
                </div>
            </FormContaner>

          </div>
        </section>
      </main>
    </div>
</template>
  