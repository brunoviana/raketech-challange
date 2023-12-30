<template>
    <div class="container mx-auto">
        <table class="table-auto w-full">
            <thead>
            <tr>
                <th class="px-4 py-2 text-gray-900 dark:text-white">Country</th>
                <th class="px-4 py-2 text-gray-900 dark:text-white">Flag</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="flag in flags" :key="flag.country_name">
                <td class="border px-4 py-2 text-gray-600 dark:text-gray-400 text-sm">{{ flag.country_name }}</td>
                <td class="border px-4 py-2 text-gray-600 dark:text-gray-400 text-sm">
                    <img :src="flag.url" :alt="flag.country_name" class="h-8">
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { onMounted, ref } from 'vue';

export default {
    name: 'FlagsTable',

    setup() {
        const flags = ref([]);

        onMounted(async () => {
            const response = await fetch('http://localhost:8000/api/flags');
            const data = await response.json();

            flags.value = data.map(flag => ({
                country_name: flag.country_name,
                url: flag.url
            }));
        });

        return {
            flags: flags
        };
    }
};
</script>
