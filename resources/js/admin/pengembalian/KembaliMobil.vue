<template>
    <div class="p-6 bg-white m-5">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-gray-700 text-2xl font-semibold">Data Pengembalian Mobil</h2>
        </div>
        <div>
            <table id="pengembalianTable" class="display responsive">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Merek Mobil</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Jumlah Total Sewa</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick, render } from 'vue';
import axios from 'axios';
import $ from 'jquery';
import 'datatables.net';
import 'datatables.net-dt/css/datatables.dataTables.css';
import { formatDate, formatRupiah } from '../../helpers/formatHelper';

const dataPengembalian = ref([]);
let dataTable = null;

const fetchDataPengembalian = async () => {
    const token = localStorage.getItem('authToken');
    try {
        const response = await axios.get('/api/pengembalian', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
        dataPengembalian.value = response.data.data;
        await nextTick();
        initializeDataTable();
    } catch (error) {
        console.error('Error fetching pengembalian data:', error);
    }
};

const initializeDataTable = () => {
    if (dataTable) {
        dataTable.destroy();
    }

    dataTable = $('#pengembalianTable').DataTable({
        data: dataPengembalian.value,        
        columns: [
            { 
                data: 'peminjaman.user.name', 
                title: 'Customer' 
            },
            { 
                data: 'peminjaman.mobil.merek', 
                title: 'Merek Mobil' 
            },
            {
                data: 'peminjaman.tgl_mulai',
                title: 'Tanggal Mulai',
                render: (data) => formatDate(data) 
            },
            {
                data: 'peminjaman.tgl_selesai',
                title: 'Tanggal Selesai',
                render: (data) => formatDate(data) 
            },
            { 
                data: 'tgl_pengembalian', 
                title: 'Tanggal Pengembalian',
                render: (data) => formatDate(data) 
            },
            { 
                data: 'jumlah_total_sewa', 
                title: 'Jumlah Total Sewa',
                render: (data) => formatRupiah(data) 
            }
        ]
    });
};

onMounted(() => {
    fetchDataPengembalian();
});

onBeforeUnmount(() => {
    if (dataTable) {
        dataTable.destroy();
    }
});
</script>
