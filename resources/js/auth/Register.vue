<template>
    <div class="max-w-md mx-auto p-4 m-4 bg-white shadow-md rounded-lg">
        <h1 class="text-xl text-center font-semibold mb-4">Register Car Rental</h1>
        <form @submit.prevent="submitForm">
            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                  <input v-model="form.name" type="text" id="name" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-indigo-500 sm:text-sm" placeholder="Your name" required />
                </div>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                  <input v-model="form.email" type="email" id="email" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-indigo-500 sm:text-sm" placeholder="you@example.com" required />
                </div>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                  <input v-model="form.password" type="password" id="password" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-indigo-500 sm:text-sm" placeholder="Enter password" required />
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password:</label>
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                  <input v-model="form.password_confirmation" type="password" id="password_confirmation" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-indigo-500 sm:text-sm" placeholder="Confirm password" required />
                </div>
            </div>

            <!-- Alamat -->
            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat:</label>
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                  <input v-model="form.alamat" type="text" id="alamat" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-indigo-500 sm:text-sm" placeholder="Your address" required />
                </div>
            </div>

            <!-- No Telepon -->
            <div class="mb-4">
                <label for="no_telepon" class="block text-sm font-medium text-gray-700">No Telepon:</label>
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                  <input v-model="form.no_telepon" type="text" id="no_telepon" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-indigo-500 sm:text-sm" placeholder="Your phone number" required />
                </div>
            </div>

            <!-- No SIM -->
            <div class="mb-4">
                <label for="no_sim" class="block text-sm font-medium text-gray-700">No SIM:</label>
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                  <input v-model="form.no_sim" type="text" id="no_sim" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-indigo-500 sm:text-sm" placeholder="Your SIM number" required />
                </div>
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role:</label>
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                  <select v-model="form.role" id="role" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 focus:outline-none focus:ring-0 focus:border-indigo-500 sm:text-sm" required>
                    <option value="rental">Rental</option>
                    <option value="customer">Customer</option>
                  </select>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition-colors">Register</button>
        </form>

        <a href="/login" class="block mt-4 text-sm text-center text-gray-600 hover:text-gray-800">
            Sudah punya akun?
        </a>

        <!-- Error Message -->
        <p v-if="errorMessage" class="text-red-500 mt-4">{{ errorMessage }}</p>
    </div>
</template>
  
<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

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

const errorMessage = ref('');
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
  