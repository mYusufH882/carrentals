<template>
    <div class="p-6 bg-white m-5">
      <h2 class="text-2xl font-bold text-gray-700 mb-4">Edit Mobil</h2>
      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label for="merek" class="block text-gray-600 mb-2">Merek</label>
          <input
            id="merek"
            v-model="form.merek"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded"
            required
          />
        </div>
        <div class="mb-4">
          <label for="model" class="block text-gray-600 mb-2">Model</label>
          <input
            id="model"
            v-model="form.model"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded"
            required
          />
        </div>
        <div class="mb-4">
          <label for="nomor_plat" class="block text-gray-600 mb-2">Nomor Plat</label>
          <input
            id="nomor_plat"
            v-model="form.nomor_plat"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded"
            required
          />
        </div>
        <div class="mb-4">
          <label for="tarif_sewa_per_hari" class="block text-gray-600 mb-2">Tarif Sewa per Hari</label>
          <input
            id="tarif_sewa_per_hari"
            v-model.number="form.tarif_sewa_per_hari"
            type="number"
            class="w-full px-3 py-2 border border-gray-300 rounded"
            required
          />
        </div>
        <div class="mb-4">
          <label for="ketersediaan" class="block text-gray-600 mb-2">Ketersediaan</label>
          <select
            id="ketersediaan"
            v-model="form.ketersediaan"
            class="w-full px-3 py-2 border border-gray-300 rounded"
            required
          >
            <option :value="true">Tersedia</option>
            <option :value="false">Tidak Tersedia</option>
          </select>
        </div>
        <button
          type="submit"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        >
          Simpan
        </button>
      </form>
    </div>
</template>
  
<script setup>
  import { ref, onMounted } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import axios from 'axios';
  
  const route = useRoute();
  const router = useRouter();
  const id = route.params.id; 
  
  const form = ref({
    merek: '',
    model: '',
    nomor_plat: '',
    tarif_sewa_per_hari: '',
    ketersediaan: true
  });
  
  const fetchMobil = async () => {
    try {
      const token = localStorage.getItem('authToken');
      const response = await axios.get(`/api/mobil/detail/${id}`, {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      });
      form.value = response.data.data;
    } catch (error) {
      console.error('Error fetching mobil data:', error);
    }
  };
  
  const submitForm = async () => {
    try {
      const token = localStorage.getItem('authToken');
      await axios.put(`/api/mobil/edit/${id}`, form.value, {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json'
        }
      });
      router.push('/mobil');
    } catch (error) {
      console.error('Error updating mobil:', error);
    }
  };
  
  onMounted(() => {
    fetchMobil();
  });
</script>
  