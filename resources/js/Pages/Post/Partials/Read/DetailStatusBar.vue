<template>
	<span :class="color">
		<span class="mr-2">{{ rate }}</span>

		<TrendingUpIcon v-if="updown" class="h-5 w-5"/>

		<TrendingDownIcon v-if="!updown" class="h-5 w-5"/>
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
					'text-green-800', // Active
					'bg-blue-100 text-blue-800', // Completed
					'bg-yellow-100 text-yellow-800', // Outstanding
					'text-red-800', // Expired
				]

				let code = (this.today > this.yesterday) ? 1 : 4

                return 'inline-flex text-xl leading-5 font-bold rounded-full ' + statusColor[code]
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
