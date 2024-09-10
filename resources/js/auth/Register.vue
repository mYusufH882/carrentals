<template>
<div class="max-w-md mx-auto p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-xl font-semibold mb-4">Register</h2>
    <form @submit.prevent="submitForm">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
            <input v-model="form.name" type="text" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
            <input v-model="form.email" type="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
            <input v-model="form.password" type="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Confirm Password</label>
            <input v-model="form.password_confirmation" type="password" class="w-full border rounded p-2" />
        </div>

        <div class="mb-4">
            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat:</label>
            <input v-model="form.alamat" type="text" id="alamat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
        </div>

        <div class="mb-4">
            <label for="no_telepon" class="block text-sm font-medium text-gray-700">No Telepon:</label>
            <input v-model="form.no_telepon" type="text" id="no_telepon" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
        </div>

        <div class="mb-4">
            <label for="no_sim" class="block text-sm font-medium text-gray-700">No SIM:</label>
            <input v-model="form.no_sim" type="text" id="no_sim" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
        </div>

        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Role:</label>
            <select v-model="form.role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="rental">Rental</option>
            <option value="customer">Customer</option>
            </select>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md">Register</button>
    </form>
    <p class="text-red-500 mt-4">{{ errorMessage }}</p>
</div>
</template>
  
<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  alamat: '',
  no_telepon: '',
  no_sim: '',
  role: 'rental',
});

const errorMessage = ref('')
const router = useRouter();

const submitForm = async () => {
    if (form.value.password !== form.value.password_confirmation) {
        errorMessage.value = 'Passwords do not match';
        return;
    }

    try {
        await axios.post('/api/register', form.value);

        router.push('/login');
    } catch (error) {
        console.error('Registration error:', error);
        errorMessage.value = 'Registration failed. Please try again.';
    }
};
</script>
  