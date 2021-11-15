<template>
	<jet-form-section @submitted="createCoinInformation">
        <template #title>
            Coin Information
        </template>

        <template #description>
            Use a detailed information where we could prevent revisions.
        </template>

        <template #form>
			<!-- Currency Logo -->
			<div class="col-span-6">
				<!-- Currency Logo File Input -->
                <input type="file" class="hidden"
                            ref="logo"
                            @change="updateLogoPreview">

                <jet-label for="logo" value="Currency Logo" />

				<div class="mt-1 flex items-center">
					<!-- New Currency Logo Preview -->
	                <div v-show="logoPreview">
	                    <span class="block rounded-full w-12 h-12 bg-cover bg-no-repeat bg-center"
	                          :style="'background-image: url(\'' + logoPreview + '\');'">
	                    </span>
	                </div>

					<span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100" v-show="!logoPreview">
						<svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
							<path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
						</svg>
					</span>
					<button @click.prevent="selectNewLogo" type="button" class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
						Change
					</button>
				</div>

				<jet-input-error :message="form.errors.logo" class="mt-2" />
			</div>

			<!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Currency Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

			<!-- Symbol -->
            <div class="col-span-6 sm:col-span-2">
                <jet-label for="symbol" value="Symbol" />
                <jet-input id="symbol" type="text" class="mt-1 block w-full" v-model="form.symbol" />
                <jet-input-error :message="form.errors.symbol" class="mt-2" />
            </div>

			<!-- Description -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="description" value="Description" />
                <jet-input id="description" type="text" class="mt-1 block w-full" v-model="form.description" />
                <jet-input-error :message="form.errors.description" class="mt-2" />
            </div>

			<!-- Launch Date -->
            <div class="col-span-6 sm:col-span-2">
                <jet-label for="launched_at" value="Launch Date" />
                <jet-input id="launched_at" type="date" class="mt-1 block w-full" v-model="form.launched_at" />
                <jet-input-error :message="form.errors.launched_at" class="mt-2" />
            </div>

			<!-- Price -->
            <div class="col-span-6 sm:col-span-3">
                <jet-label for="price" value="Current Price" />
                <jet-input id="price" type="text" class="mt-1 block w-full" v-model="form.price" />
                <jet-input-error :message="form.errors.price" class="mt-2" />
            </div>

			<!-- Last 24H Price -->
            <div class="col-span-6 sm:col-span-3">
                <jet-label for="yesterday" value="Last 24H Price" />
                <jet-input id="yesterday" type="text" class="mt-1 block w-full" v-model="form.yesterday" />
                <jet-input-error :message="form.errors.yesterday" class="mt-2" />
            </div>

			<!-- Market Capitalization -->
            <div class="col-span-6 sm:col-span-3">
                <jet-label for="capital" value="Market Capitalization" />
                <jet-input id="capital" type="text" class="mt-1 block w-full" v-model="form.capital" />
                <jet-input-error :message="form.errors.capital" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
	import { defineComponent } from 'vue'
	import JetActionSection from '@/Jetstream/ActionSection.vue'
	import JetFormSection from '@/Jetstream/FormSection.vue'
	import JetButton from '@/Jetstream/Button.vue'
	import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetActionMessage from '@/Jetstream/ActionMessage.vue'

	export default defineComponent({
		components: {
			JetActionSection,
			JetFormSection,
			JetButton,
			JetInput,
			JetInputError,
			JetLabel,
			JetActionMessage,
		},

		data() {
            return {
                form: this.$inertia.form({
                    _method: 'POST',
                    name: null,
                    symbol: null,
                    description: '',
                    price: 0,
                    capital: 0,
                    yesterday: 0,
					logo: null,
                    launched_at: new Date().toISOString().slice(0, 10),
					_token: this.$page.props.csrf_token,
                }),
            }
        },

		methods: {
            createCoinInformation() {
                this.form.post(route('coin.add'), {
                    errorBag: 'createCoinInformation',
                    preserveScroll: true,
                });
            },
			updatePricing: function(ev) {
				ev = (ev) ? ev : window.event;
				var charCode = (ev.which) ? ev.which : ev.keyCode;
				if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
					ev.preventDefault();;
				} else {
					return true;
				}
			},
			selectNewLogo() {
                this.$refs.logo.click();
            },

            updateLogoPreview() {
                const logo = this.$refs.logo.files[0];

                if (! logo) return;

                const reader = new FileReader();

                reader.onload = (e) => {
                    this.logoPreview = e.target.result;
                };

                reader.readAsDataURL(logo);
            },

            deleteLogo() {
                this.$inertia.delete(route('current-user-logo.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.logoPreview = null;
                        this.clearLogoFileInput();
                    },
                });
            },

            clearLogoFileInput() {
                if (this.$refs.logo?.value) {
                    this.$refs.logo.value = null;
                }
            },
        },
	})
</script>
