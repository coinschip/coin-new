<template>
    <app-layout title="Posts">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
					<!-- <div class="bg-white shadow-sm sm:rounded-md p-2">
						<img src="" alt="">
						<div class="">
							Title
						</div>
						<span>summary</span>
					</div> -->
					<div class="flex flex-col justify-center items-center">
						<img class="w-72 h-72" :src="image" alt="Coming Soon">
						<span class="text-2xl text-center font-semibold	">Coming Soon</span>
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

    export default defineComponent({
        props: [
			'posts',
			'keyword',
			'image',
		],

        components: {
            AppLayout,
            JetSectionBorder,
        },
    })
</script>
