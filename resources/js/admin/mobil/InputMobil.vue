<template>
    <div class="p-6 bg-white m-5">
      <h2 class="text-2xl font-bold text-gray-700 mb-4">Tambah Mobil</h2>
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
            v-model="form.tarif_sewa_per_hari"
            type="number"
            step="0.01"
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
  import { ref } from 'vue';
  import axios from 'axios';
import router from '../../router';
  
  const form = ref({
    merek: '',
    model: '',
    nomor_plat: '',
    tarif_sewa_per_hari: '',
    ketersediaan: 'true'
  });
  
  const submitForm = async () => {
    try {
        form.value.ketersediaan = Boolean(form.value.ketersediaan);

        await axios.post('/api/mobil/create', form.value, {
            headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('authToken')}`
            }
        });

        form.value = {
            merek: '',
            model: '',
            nomor_plat: '',
            tarif_sewa_per_hari: '',
            ketersediaan: 'true'
        };

        router.push('/mobil');
    } catch (error) {
        console.error('Error adding mobil:', error);
    }
  };
</script>
  