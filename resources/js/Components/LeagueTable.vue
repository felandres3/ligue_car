<script setup>
import { ref } from 'vue';

const props = defineProps({
    teams: Array, // Lista de equipos con sus datos
    headers: Array // Encabezados de la tabla
});
</script>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-200">
                    <th class="text-center">#</th>
                    <th v-for="header in headers" :key="header.key" class="py-2 px-4 border-b text-center">
                        {{ header.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(team, index) in teams" :key="team.id" class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b text-gray-700">
                        {{ index + 1 }}
                    </td>
                    <td v-for="header in headers" :key="header.key" class="py-2 px-4 border-b text-gray-700">
                        {{ team[header.key] }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
