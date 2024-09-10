<template>
    <div class="max-w-md mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Login</h1>
        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input v-model="form.email" type="email" class="w-full border rounded p-2" required />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input v-model="form.password" type="password" class="w-full border rounded p-2" required />
            </div>

            <button type="submit" class="bg-blue-500 text-white rounded p-2">Login</button>
        </form>
        
        <p v-if="errorMessage" class="text-red-500 mt-4">{{ errorMessage }}</p>
    </div>
</template>
  
<script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  
  const form = ref({
    email: '',
    password: '',
  });
  
  const errorMessage = ref('');
  const router = useRouter();
  
  const submitForm = async () => {
    try {
      await axios.post('/api/login', form.value);

      router.push('/dashboard');
    } catch (error) {
      console.error('Login error:', error);
      errorMessage.value = 'Login failed. Please check your credentials and try again.';
    }
  };
</script>
  