<template>
    <div class="max-w-md mx-auto mt-20 p-4 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl text-center font-bold mb-4">Login Car Rental</h1>
        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                  <input v-model="form.email" type="email" id="email" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-indigo-500 sm:text-sm" placeholder="you@example.com" required />
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                  <input v-model="form.password" type="password" id="password" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-indigo-500 sm:text-sm" placeholder="Enter password" required />
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition-colors">Login</button>
        </form>
        
        <a href="/register" class="block mt-4 text-sm text-center text-gray-600 hover:text-gray-800">
            Belum punya akun?
        </a>

        <p v-if="errorMessage" class="text-red-500 mt-4">{{ errorMessage }}</p>
    </div>
</template>
  
<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
  
  const form = ref({
    email: '',
    password: '',
  });
  
  const errorMessage = ref('');
  const router = useRouter();
  
  const submitForm = async () => {
    try {
        const response = await axios.post('/api/login', form.value);

        const token = response.data.token;
        const name = response.data.name;
        const role = response.data.role;

        localStorage.setItem('authToken', token);
        localStorage.setItem('userName', name);
        localStorage.setItem('userRole', role);

        if (role === 'rental') {
            console.log('Admin Rental');

            router.push('/dashboard');
        } else if (role === 'customer') {
            console.log('User Customer');

            router.push('/home');
        }
    } catch (error) {
        console.error('Login error:', error);
        errorMessage.value = 'Login failed. Please check your credentials and try again.';
    }
  };
</script>
  