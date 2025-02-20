<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ResultForm from '@/Components/ResultForm.vue';
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
            <div class="w-full mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 flex gap-6">
                    <!-- Tabla de Liga -->
                    <div class="w-full">
                        <h3 class="text-lg font-bold text-gray-700 mb-4">Liga de Competición</h3>
                        <LeagueTable :teams="league.cars" :headers="[
                            { key: 'car_name', label: 'Equipo' },
                            { key: 'points', label: 'Puntos' },
                        ]" />
                    </div>

                    <!-- Componente de Resultados -->
                    <div class="w-full bg-gray-100 p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-bold text-gray-700 mb-4">Resultados</h3>
                        <ResultForm :cars="league.cars" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
