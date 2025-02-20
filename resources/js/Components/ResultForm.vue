<script setup>
import { computed, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import LeagueTable from './LeagueTable.vue';

const props = defineProps({
    cars: {
        type: Array,
        required: true
    }
});

const form = useForm({
    results: {}
});

// 🔹 Crear una copia de `cars` con `originalPoints` sin afectar los tests
const carsWithPoints = ref(props.cars.map(car => ({
    ...car,
    originalPoints: car.points || 0, // Puntaje inicial
    newPoints: 0, // Puntaje basado en los resultados ingresados
    rankingPoints: 0, // Puntos asignados según la posición
    finalPoints: car.points || 0 // Puntaje final tras sumar `rankingPoints`
})));

// 🔹 Distribución de puntos según la posición
const pointsDistribution = [30, 25, 21, 18, 15, 12, 10, 8, 6, 4, 2, 1];

// 🔹 Función para calcular `newPoints` solo con los test
const calculateScore = (carId) => {
    const punta = form.results[carId]?.resultado1 || 0;
    const promedio = form.results[carId]?.resultado2 || 0;
    return (0.6 * punta) + (0.4 * promedio);
};

// 🔹 Función para actualizar `newPoints`
const updateResult = (carId, field, event) => {
    if (!form.results[carId]) {
        form.results[carId] = {};
    }
    form.results[carId][field] = parseFloat(event.target.value) || 0;

    const carToUpdate = carsWithPoints.value.find(car => car.id === carId);
    if (carToUpdate) {
        carToUpdate.newPoints = calculateScore(carId);
    }
};

// 🔹 Computed para ordenar los carros según `newPoints`, asignar puntos y ordenar por `finalPoints`
const sortedCars = computed(() => {
    let rankedCars = [...carsWithPoints.value].sort((a, b) => b.newPoints - a.newPoints);

    // 🔹 Asignamos `rankingPoints` según la posición
    rankedCars.forEach((car, index) => {
        car.rankingPoints = pointsDistribution[index] || 0;
        car.finalPoints = car.originalPoints + car.rankingPoints; // Puntaje final
    });

    // 🔹 Finalmente, ordenamos la tabla según `finalPoints`
    return rankedCars.sort((a, b) => b.finalPoints - a.finalPoints);
});

// 🔹 Función para enviar los resultados al controlador con Inertia.js
const submitResults = () => {
    form.post(route('update.results', { results: prepareResultsForSubmission.value }), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Puntajes actualizados correctamente');
        },
        onError: (errors) => {
            console.error('Error al actualizar los puntajes', errors);
        }
    });
};

// 🔹 Preparar datos para enviar solo ID y finalPoints
const prepareResultsForSubmission = computed(() => {
    return sortedCars.value.map(car => ({
        id: car.id,
        finalPoints: car.finalPoints
    }));
});
</script>

<template>
    <div class="flex gap-6">
        <!-- Formulario -->
        <div class="bg-gray-100 p-6 rounded-lg shadow-md w-1/2">
            <form>
                <div v-for="car in cars" :key="car.id" class="mb-4 bg-white p-4 rounded shadow">
                    <p class="text-gray-800 font-semibold mb-2">{{ car.car_name }}</p>

                    <div class="flex gap-4">
                        <div>
                            <label :for="'result1-' + car.id" class="block text-gray-700 text-sm font-bold mb-1">
                                Resultado 1 (Punta)
                            </label>
                            <input :id="'result1-' + car.id" :value="form.results[car.id]?.resultado1 || ''"
                                @input="updateResult(car.id, 'resultado1', $event)" type="number"
                                class="border rounded p-2 w-24">
                        </div>

                        <div>
                            <label :for="'result2-' + car.id" class="block text-gray-700 text-sm font-bold mb-1">
                                Resultado 2 (Promedio)
                            </label>
                            <input :id="'result2-' + car.id" :value="form.results[car.id]?.resultado2 || ''"
                                @input="updateResult(car.id, 'resultado2', $event)" type="number"
                                class="border rounded p-2 w-24">
                        </div>

                        <p class="text-gray-600 self-end font-semibold">
                            Puntaje Test: {{ calculateScore(car.id).toFixed(2) }}
                        </p>
                    </div>
                </div>
            </form>

            <!-- Botón para enviar los resultados -->
            <button @click="submitResults"
                class="mt-4 bg-blue-600 text-white py-2 px-4 rounded shadow hover:bg-blue-700">
                Guardar Resultados
            </button>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto w-1/2">
            <LeagueTable :teams="sortedCars" :headers="[
                { key: 'car_name', label: 'Equipo' },
                { key: 'originalPoints', label: 'Puntos Iniciales' },
                { key: 'newPoints', label: 'Puntaje de Test' },
                { key: 'rankingPoints', label: 'Puntos por Posición' },
                { key: 'finalPoints', label: 'Puntos Finales' }
            ]" />
        </div>
    </div>
</template>
