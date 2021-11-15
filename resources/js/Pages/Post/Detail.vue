<template>
    <app-layout title="Coins">
		<template #header>
			<div class="flex justify-between">
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
	                Coin Detail
	            </h2>
				<Link :href="route('dashboard')" class="text-sm text-gray-500 hover:text-gray-600 duration-100 font-bold">Back</Link>
            </div>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="w-full grid grid-cols-6 gap-6">
					<div class="col-span-4">
						<div @click="vote(coin.id)" class="py-2 text-center bg-gray-900 hover:bg-gray-800 text-white border text-md font-medium rounded-md">
							{{ coin.votes.length }} votes
						</div>
					</div>
					<div class="col-span-2">

					</div>
					<div class="col-span-4 px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md">
						<div class="flex items-center">
							<div class="flex-shrink-0 h-16 w-16">
								<img class="h-16 w-16 rounded-full object-cover" v-if="coin.logo" :src="coin.logo" alt="" />
								<span class="inline-block h-16 w-16 rounded-full overflow-hidden bg-gray-100" v-if="!coin.logo">
									<svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
										<path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
									</svg>
								</span>
							</div>
							<div class="ml-4">
								<div class="text-xl font-bold text-gray-900">
									{{ coin.name }}
								</div>
								<div class="text-lg text-gray-500">
									{{ coin.symbol }}
								</div>
							</div>
						</div>
						<div v-if="coin.description" class="flex flex-col text-md pl-4 mt-8">
							<span class="font-semibold">What is {{ coin.name }}</span>
							<span>{{ coin.description }}</span>
						</div>
					</div>
					<div class="col-span-2 px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md">
						<div class="flex flex-col">
							<span class="font-medium text-md">Price</span>
							<span class="font-bold text-xl text-gray-900">
								<detail-status-bar :today="coin.price" :yesterday="coin.yesterday">{{ coin.yesterday }}</detail-status-bar>
							</span>
						</div>
						<div class="flex flex-col">
							<span class="font-medium text-md">Market cap</span>
							<span class="font-bold text-xl text-gray-900">{{ coin.capital }}</span>
						</div>
						<div class="flex flex-col">
							<span class="font-medium text-md">Launch date</span>
							<span class="font-bold text-xl text-gray-900">{{ coin.launched_at }}</span>
						</div>
					</div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
	import DetailStatusBar from '@/Pages/Coin/Partials/Read/DetailStatusBar.vue'

    export default defineComponent({
        props: [
			'coin'
		],

		methods: {
			vote(id) {
				this.$inertia.post(route('coin.vote', id), {
                    errorBag: 'voteItem',
                    preserveScroll: true,
                });
			}
		},

        components: {
            AppLayout,
			DetailStatusBar,
            JetSectionBorder,
        },
    })
</script>
