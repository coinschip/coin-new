<template>
	<span :class="color">
		<TrendingUpIcon v-if="updown" class="h-5 w-5"/>

		<TrendingDownIcon v-if="!updown" class="h-5 w-5"/>

		<span class="ml-2">{{ rate }}</span>
	</span>
</template>

<script>
    import { defineComponent } from 'vue'

	import { TrendingUpIcon, TrendingDownIcon } from '@heroicons/vue/solid'

    export default defineComponent({
		components: {
			TrendingUpIcon,
			TrendingDownIcon,
		},

        props: [
			'today',
			'yesterday',
		],

        computed: {
			updown() {
				return (this.today > this.yesterday)
			},
            color() {
				const statusColor = [
					'bg-gray-100 text-gray-800', // Pending
					'bg-green-100 text-green-800', // Active
					'bg-blue-100 text-blue-800', // Completed
					'bg-yellow-100 text-yellow-800', // Outstanding
					'bg-red-100 text-red-800', // Expired
				]

				let code = (this.today > this.yesterday) ? 1 : 4

                return 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full ' + statusColor[code]
            },
			message() {
				const statusText = [
					'Pending',
					'Active',
					'Completed',
					'Outstanding',
					'Expired',
				]

				return statusText[this.code]
			},
			rate() {
				let rate = this.today / this.yesterday

				return (rate * 100) + '%'
			},
        }
    })
</script>
