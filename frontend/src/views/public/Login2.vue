<template>
    <div>
      <Form :initialFormData="formData" @formSubmitted="handleFormSubmission">
        <TextInput v-model="formData.email" label="Email" />
        <button type="submit">Submit</button>
      </Form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import Form from '../../components/form/Form.vue';
  import TextInput from '../../components/form/TextInput.vue';
  
  const formData = ref({
    email: '',
  });
  
  const handleFormSubmission = (data) => {
    // Handle the form submission
    console.log(data);
  };
  </script>
  