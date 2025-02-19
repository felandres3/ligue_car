<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from '@/Components/Table.vue';
import { ref } from 'vue';
import LeagueTable from '@/Components/LeagueTable.vue';

const props = defineProps({
    league: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 flex gap-6">
                    <!-- Tabla de Liga -->
                    <div class="w-2/3">
                        <h3 class="text-lg font-bold text-gray-700 mb-4">Liga de Competición</h3>
                        <LeagueTable :teams="league.cars" :headers="[
                            { key: 'car_name', label: 'Equipo' },
                        ]" />
                    </div>

                    <!-- Componente de Resultados -->
                    <div class="w-1/3 bg-gray-100 p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-bold text-gray-700 mb-4">Resultados</h3>
                        <p class="text-gray-600">Aquí irán los resultados en vivo y las estadísticas actualizadas.</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
