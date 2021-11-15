<template>
	<span :class="color">
		{{ message }}
	</span>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: ['code'],

        computed: {
            color() {
				const statusColor = [
					'bg-gray-100 text-gray-800', // Pending
					'bg-green-100 text-green-800', // Active
					'bg-blue-100 text-blue-800', // Completed
					'bg-yellow-100 text-yellow-800', // Outstanding
					'bg-red-100 text-red-800', // Expired
				]

                return 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full ' + statusColor[this.code]
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
			}
        }
    })
</script>
