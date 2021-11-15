<template>
    <app-layout title="Coins">
        <template #header>
			<div class="flex justify-between">
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
	                Add New Coins
	            </h2>
				<Link :href="route('coin.list')" class="text-sm text-gray-500 hover:text-gray-600 duration-100 font-bold">Back</Link>
            </div>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
					<coin-form :customers="customer" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import CoinForm from '@/Pages/Coin/Partials/Create/Coin.vue'
	import { Link } from '@inertiajs/inertia-vue3'

    export default defineComponent({
        components: {
            AppLayout,
            CoinForm,
			Link
        },

		props: {
			customer: Object
		},
    })
</script>
