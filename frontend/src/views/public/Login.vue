<template>
  <div>
    <main>
      <section class="absolute w-full h-full">
        <div
            class="absolute top-0 w-full h-full bg-gray-900"
            style="background-size: 100%; background-repeat: no-repeat;"></div>
        <div class="container mx-auto px-4 h-full">
          <div class="flex content-center items-center justify-center h-full">
            <div class="w-full lg:w-4/12 px-4">
              <div
                  class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0"
              >
                <div class="flex-auto px-4 lg:px-10 py-10">

                  <p v-if="errorMessage">{{ errorMessage }}</p>

                  <form @submit.prevent="login">
                    <div class="relative w-full mb-3">
                      <label
                          class="block uppercase text-gray-700 text-xs font-bold mb-2"
                          for="grid-password"
                      >Email</label
                      ><input
                        type="email"
                        class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full"
                        placeholder="Email"
                        v-model="email" required
                        style="transition: all 0.15s ease 0s;"
                    />
                    </div>
                    <div class="relative w-full mb-3">
                      <label
                          class="block uppercase text-gray-700 text-xs font-bold mb-2"
                          for="grid-password"
                      >Password</label
                      ><input
                        type="password"
                        class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full"
                        placeholder="Password"
                        style="transition: all 0.15s ease 0s;"
                        v-model="password" required
                    />
                    </div>
                    <div>
                      <label class="inline-flex items-center cursor-pointer"
                      ><input
                          id="customCheckLogin"
                          type="checkbox"
                          class="form-checkbox border-0 rounded text-gray-800 ml-1 w-5 h-5"
                          style="transition: all 0.15s ease 0s;"
                      /><span class="ml-2 text-sm font-semibold text-gray-700"
                      >Remember me</span
                      ></label
                      >
                    </div>
                    <div class="text-center mt-6">
                      <button
                          class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full"
                          type="submit"
                          style="transition: all 0.15s ease 0s;"
                      >
                        Sign In
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="flex flex-wrap mt-6">
                <div class="w-1/2">
                  <a href="#pablo" class="text-gray-300"
                  ><small>Forgot password?</small></a
                  >
                </div>
                <div class="w-1/2 text-right">
                  <a href="#pablo" class="text-gray-300"
                  ><small>Create new account</small></a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
</template>

<script>

import api from '../../services/api.js';

export default {
  data() {
    return {
      email: 'nahuns@gmail.com',
      password: '1234567',
      errorMessage: '',
    };
  },
  methods: {
    login() {
      const { email, password } = this;
      api
          .post('/api/login', { email, password })
          .then((response) => {
            // Assuming the API response contains an access token
            const accessToken = response.data.access_token;
            localStorage.setItem('accessToken', accessToken);
            this.$router.push('/todos');
          })
          .catch((error) => {
            console.log(error)
            this.errorMessage = error.response.data.message;
          });
    },
  },
};
</script>