<template>
	<vue-final-modal
		v-slot="{ params }"
		:z-index-auto="true"
		:z-index-base="1000"
		:z-index="9999999999"
		v-bind="$attrs"
		classes="flex justify-center items-center"
		content-class="relative flex flex-col max-h-full mx-4 p-6 border rounded-xl bg-white"
	>
		<span class="mr-8 text-xl font-bold mb-4">
			<slot name="title"></slot>
		</span>
		<div class="flex-grow overflow-y-auto">
			<slot :params="params"></slot>
		</div>
	</vue-final-modal>
</template>

<script>
	import { VueFinalModal } from 'vue-final-modal'

export default {
	components: {
		VueFinalModal
	},
	name: 'VTailwindModal',
	inheritAttrs: false,
}

</script>
