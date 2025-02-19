<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    data: Object,
    headers: Array,
    paginate: Boolean
});


const currentPage = ref(props.data?.current_page);
</script>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th v-for="header in headers" :key="header.key" class="py-2 px-4 border-b">
                        {{ header.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in data.data" :key="row.id" class="hover:bg-gray-50">
                    <td v-for="header in headers" :key="header.key" class="py-2 px-4 border-b text-gray-700">
                        <div v-if="header.relation">
                            {{ row[header.relation][header.key] }}
                        </div>
                        <div v-else>
                            {{ row[header.key] }}
                        </div>
                        <div class="flex  items-center justify-center gap-x-4" v-if="header.actions">
                            <div v-for="action in header.actions" v-bind:key="action.label">
                                <Link :href="route(action.route, row[action.parameter])">{{ action.label }}</Link>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination controls -->
        <div v-if="paginate ?? false" class="flex justify-between items-center mt-4">
            <div>
                <button @click="$inertia.get(data.prev_page_url)" :disabled="!data.prev_page_url"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded disabled:opacity-50">
                    &laquo; Anterior
                </button>
            </div>
            <div class="flex items-center space-x-2">
                <span v-for="link in data.links" :key="link.label">
                    <button v-if="link.url" @click="$inertia.get(link.url)" :class="[
                        'px-3 py-1 border rounded',
                        { 'bg-blue-500 text-white': link.active, 'bg-gray-300 text-gray-700': !link.active }
                    ]">
                        {{ link.label }}
                    </button>
                    <span v-else class="px-3 py-1 text-gray-400">
                        {{ link.label }}
                    </span>
                </span>
            </div>
            <div>
                <button @click="$inertia.get(data.next_page_url)" :disabled="!data.next_page_url"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded disabled:opacity-50">
                    Siguiente &raquo;
                </button>
            </div>
        </div>
    </div>
</template>
