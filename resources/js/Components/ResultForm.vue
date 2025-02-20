<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

defineProps({
    cars: {
        type: Array,
        required: true
    }
});

const form = useForm({
    results: {}
});

// Función para actualizar dinámicamente los valores
const updateResult = (carId, field, event) => {
    if (!form.results[carId]) {
        form.results[carId] = {}; // Inicializa el objeto si no existe
    }
    form.results[carId][field] = parseFloat(event.target.value) || 0; // Convierte a número o 0
};

// Función para calcular el puntaje con la fórmula dada
const calculateScore = (carId) => {
    const punta = form.results[carId]?.resultado1 || 0;
    const promedio = form.results[carId]?.resultado2 || 0;
    return (0.6 * punta) + (0.4 * promedio);
};
</script>

<template>
    <div class="bg-gray-100 p-6 rounded-lg shadow-md">
        <form>
            <div v-for="car in cars" :key="car.id" class="mb-4 bg-white p-4 rounded shadow">
                <p class="text-gray-800 font-semibold mb-2">{{ car.car_name }}</p>

                <div class="flex gap-4">
                    <div>
                        <label :for="'result1-' + car.id" class="block text-gray-700 text-sm font-bold mb-1">
                            Resultado 1 (Punta)
                        </label>
                        <input :id="'result1-' + car.id"
                            :value="form.results[car.id]?.resultado1 || ''"
                            @input="updateResult(car.id, 'resultado1', $event)"
                            type="number"
                            class="border rounded p-2 w-24">
                    </div>

                    <div>
                        <label :for="'result2-' + car.id" class="block text-gray-700 text-sm font-bold mb-1">
                            Resultado 2 (Promedio)
                        </label>
                        <input :id="'result2-' + car.id"
                            :value="form.results[car.id]?.resultado2 || ''"
                            @input="updateResult(car.id, 'resultado2', $event)"
                            type="number"
                            class="border rounded p-2 w-24">
                    </div>

                    <p class="text-gray-600 self-end font-semibold">
                        Puntaje: {{ calculateScore(car.id).toFixed(2) }}
                    </p>
                </div>
            </div>
        </form>
    </div>
</template>
