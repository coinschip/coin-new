<template>
	<div class="flex flex-col">
		<div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
			<div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
				<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
					<table class="min-w-full divide-y divide-gray-200">
						<thead class="bg-gray-50">
							<tr>
								<th scope="col" class="relative px-6 py-3">
									<span class="sr-only">Currency Name</span>
								</th>
								<th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
									Price
								</th>
								<th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
									24H
								</th>
								<th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
									Market Cap
								</th>
								<th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
									Launch Date
								</th>
								<th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
									Votes
								</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
							<tr v-for="currency in coins.data">
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
									<Link :href="route('coin.detail', currency.id)">
										<div class="flex items-center">
											<div class="flex-shrink-0 h-10 w-10">
												<img class="h-10 w-10 rounded-full object-cover" v-if="currency.logo" :src="currency.logo" alt="" />
												<span class="inline-block h-10 w-10 rounded-full overflow-hidden bg-gray-100" v-if="!currency.logo">
													<svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
														<path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
													</svg>
												</span>
											</div>
											<div class="ml-4">
												<div class="text-sm font-medium text-gray-900">
													{{ currency.name }}
												</div>
												<div class="text-sm text-gray-500">
													{{ currency.symbol }}
												</div>
											</div>
										</div>
									</Link>
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
									{{ currency.price }}
								</td>

								<td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
									<status-bar :today="currency.price" :yesterday="currency.yesterday">{{ currency.yesterday }}</status-bar>
								</td>

								<td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
									{{ currency.capital }}
								</td>

								<td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
									{{ formatDate(currency.launched_at) }}
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-500 hover:text-gray-900">
									<div @click="vote(currency.id)" class="text-center bg-gray-900 hover:bg-gray-800 text-white border text-md font-medium rounded-md p-1">
										{{ currency.votes.length }} votes
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<pagination :links="coins"/>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import { defineComponent } from 'vue'
	import Pagination from '@/Components/Pagination'
	import StatusBar from '@/Pages/Coin/Partials/Read/StatusBar.vue'
	import { Link } from '@inertiajs/inertia-vue3'

	import moment from 'moment'

	const emitter = require('tiny-emitter/instance')

	export default defineComponent({
		components: {
			Pagination,
			StatusBar,
			Link,
		},
		props: ['coins'],
		data() {
			return {
				coinKeyword: {}
			}
		},
		methods: {
			updateCoin(keyword) {
				this.$inertia.get(this.route('dashboard'), keyword, { preserveState: true })
			},
			formatDate(date) {
				return moment(String(date)).format('MM-DD-YYYY')
			},
			formatCurrency(price) {
				const formatter = new Intl.NumberFormat('en-US', {
					style: 'currency',
					currency: 'IDR',
					minimumFractionDigits: 2
				})

				return formatter.format(price)
			},
			calculatePrice(today, yesterday) {
				let rate = today / yesterday

				return rate * 100
			},
			vote(id) {
				this.$inertia.post(route('coin.vote', id), {
                    errorBag: 'voteItem',
                    preserveScroll: true,
                });
			}
		},
		mounted() {
			emitter.on('coinSearch', (keyword) => {
				this.updateCoin(keyword)
			})
		}
	})
</script>
