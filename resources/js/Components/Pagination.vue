<template>
	<div class="bg-white px-4 py-3 flex items-stretch justify-between border-t border-gray-200 sm:px-6 w-full">
		<div class="flex-1 flex justify-between sm:hidden">
			<a preserve-state preserve-scroll :href="links.prev_page_url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
				Previous
			</a>
			<a preserve-state preserve-scroll :href="links.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
				Next
			</a>
		</div>
		<div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
			<div>
				<p class="text-sm text-gray-700">
					Showing
					{{ ' ' }}
					<span class="font-medium">{{ links.from }}</span>
					{{ ' ' }}
					to
					{{ ' ' }}
					<span class="font-medium">{{ links.to }}</span>
					{{ ' ' }}
					of
					{{ ' ' }}
					<span class="font-medium">{{ links.total }}</span>
					{{ ' ' }}
					results
				</p>
			</div>
			<div>
				<nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
					<Link preserve-state preserve-scroll :href="links.prev_page_url" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
						<span class="sr-only">Previous</span>
						<ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
					</Link>

					<div v-for="(link, index) in links.links" :key="index">
						<Link preserve-state preserve-scroll v-if="(index > 0) && (link.url !== null) && (index < (links.links.length - 1))" :href="link.url" :class="{ 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600': link.active }" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
							{{ link.label }}
						</Link>
						<span v-if="(index > 0) && (link.url === null) && (index < (links.links.length - 1))" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
							{{ link.label }}
						</span>
					</div>

					<Link preserve-state preserve-scroll :href="links.next_page_url" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
						<span class="sr-only">Next</span>
						<ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
					</Link>
				</nav>
			</div>
		</div>
	</div>
</template>

<script>
	import { defineComponent } from 'vue'
	import { Link } from '@inertiajs/inertia-vue3'
	import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/solid'

	export default defineComponent({
		components: {
			ChevronLeftIcon,
			ChevronRightIcon,
			Link
		},
		props: {
			links: Object
		}
	})
</script>
