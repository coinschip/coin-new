<template>
    <app-layout title="Coins">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Coins
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
					<coin-search :serverKeyword="keyword" />

                    <coin-table :coins="coins" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import CoinTable from '@/Pages/Coin/Partials/Read/CoinTable.vue'
	import CoinSearch from '@/Pages/Coin/Partials/Read/CoinSearch.vue'
    import JetSectionBorder from '@/Jetstream/SectionBorder.vue'

    export default defineComponent({
        props: [
			'coins',
			'keyword',
		],

        components: {
            AppLayout,
            CoinTable,
			CoinSearch,
            JetSectionBorder,
        },
    })
</script>
