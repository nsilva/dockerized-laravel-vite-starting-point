<template>
    <div>
      <main>
        <section class="absolute w-full h-full">
          <div
              class="absolute top-0 w-full h-full bg-gray-900"></div>
          <div class="container mx-auto px-4 h-full">
            <div class="flex content-center items-center justify-center h-full">
              <div class="w-full lg:w-4/12 px-4">
                <div
                    class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0">
                  <div class="flex-auto px-4 lg:px-10 py-10">
  
                    <p v-if="errorMessage">{{ errorMessage }}</p>
  
                    <Form :initialFormData="formData" @formSubmitted="handleFormSubmission">
                        <div class="relative w-full mb-3">
                            <TextInput v-model="formData.email" label="Email" type="text"/>
                        </div>
                        <div class="relative w-full mb-3">
                            <TextInput v-model="formData.password" label="Password" type="password"/>
                        </div>
                        <div class="text-center mt-6">
                            <button
                                class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full"
                                type="submit">
                                Sign In
                            </button>
                        </div>
                    </Form>
                  </div>
                </div>
                <div class="flex flex-wrap mt-6">
                  <div class="w-1/2">
                    <a href="" class="text-white">
                        <small>Forgot password?</small>
                    </a>
                  </div>
                  <div class="w-1/2 text-right">
                    <a href="" class="text-white">
                        <small>Create new account</small>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import { useRouter } from 'vue-router';
    import api from '../../services/api.js';
    import Form from '../../components/form/Form.vue';
    import TextInput from '../../components/form/TextInput.vue';
    
    const router = useRouter()
    const formData = ref({
        email:    '',
        password: ''
    });
    
    const errorMessage = ref('')

    const handleFormSubmission = (data) => {
      errorMessage.value = ''

      api
          .post('/api/login', formData.value)
          .then((response) => {
            // Assuming the API response contains an access token
            const accessToken = response.data.access_token;
            localStorage.setItem('accessToken', accessToken);
            router.push('/todos');
          })
          .catch((error) => {
            console.log(error)
            errorMessage.value = error.response.data.message;
          });
    };
</script>
  