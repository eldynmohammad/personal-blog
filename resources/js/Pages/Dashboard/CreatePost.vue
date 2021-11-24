<template>
    <app-layout title="Posts">
        <template #header>
			<div class="flex">
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Posts 
				</h2>
				<!-- <inertia-link :href="`route('createPostPage')`" class="bg-accentcolor px-3 py-1 ml-3 rounded-lg text-white text-xs hover:bg-accentcolor-light transition-colors duration-300">Create a new post</inertia-link> -->
			</div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white shadow-xl sm:rounded-lg p-8 flex flex-col editor h-full">
					<h2 class="text-2xl mb-6 ml-2">Create a new post</h2>
					
					<!-- Form -->
					<div class="grid grid-cols-3-1 ">
						<div class="px-2  overflow-auto">
							<div class="mb-4">
								<label class="ml-2 mb-2 block text-sm">Title</label>
								<input type="text" v-model="post.title" class="w-full px-3 py-2.5 border bg-white shadow-lg border-gray-200 outline-none rounded-lg" placeholder="Post's title">
								<p v-if="$page.props.error.title" class="text-sm">{{ $page.props.error.title[0] }}</p>
							</div>
							<div class="mb-4 max-h-full">
								<label class="ml-2 mb-2 block text-sm border-0">Content</label>
								<QuillEditor v-model:content="post.body" contentType="html" toolbar="full" theme="snow" class="border bg-white shadow-md border-gray-200"/>
							</div>
						</div>
						<div class="px-2 h-full">
							<div class="mb-4">
								<label class="ml-2 mb-2 block text-sm">Featured Image</label>
								<div class="flex items-center justify-center w-full">
									<label class="flex flex-col w-full h-32 border-4 border-dashed hover:bg-gray-100 hover:border-gray-300 cursor-pointer">
										<div class="flex flex-col items-center justify-center pt-7">
											<svg xmlns="http://www.w3.org/2000/svg"
												class="w-12 h-12 text-gray-400 group-hover:text-gray-600" viewBox="0 0 20 20"
												fill="currentColor">
												<path fill-rule="evenodd"
													d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
													clip-rule="evenodd" />
											</svg>
											<p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">
												Select a photo</p>
										</div>
										<input type="file" class="opacity-0" @change="onImageChange" />
									</label>
								</div>
							</div>
							<div class="mb-4">
								<label class="ml-2 mb-2 block text-sm">Category</label>
								<Multiselect 
									:classes="{
										container: 'relative mx-auto p-2 w-full flex items-center justify-end box-border cursor-pointer border bg-white shadow-lg rounded-lg text-base leading-snug outline-none',
										placeholder: 'flex text-sm items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-400',
										dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-lg',
										dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
										dropdownHidden: 'hidden',
										tag: 'bg-accentcolor text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap',
										tagDisabled: 'pr-2 opacity-50',
									}"
									v-model="post.categorySelected" 
									mode="tags" 
									:closeOnSelect="false" 
									:createTag="true" 
									:options="listCategory"
									placeholder="Choose category" />
							</div>
							<div class="mb-4">
								<label class="ml-2 mb-2 block text-sm">Tags</label>
								<Multiselect 
									:classes="{
										container: 'relative mx-auto p-2 w-full flex items-center justify-end box-border cursor-pointer border bg-white shadow-lg rounded-lg text-base leading-snug outline-none',
										placeholder: 'flex text-sm items-center h-full absolute left-0 top-0 pointer-events-none bg-transparent leading-snug pl-3.5 text-gray-400',
										dropdown: 'max-h-60 absolute -left-px -right-px bottom-0 transform translate-y-full border border-gray-300 -mt-px overflow-y-scroll z-50 bg-white flex flex-col rounded-lg',
										dropdownTop: '-translate-y-full top-px bottom-auto flex-col-reverse rounded-b-none rounded-t',
										dropdownHidden: 'hidden',
										tag: 'bg-accentcolor text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap',
										tagDisabled: 'pr-2 opacity-50',
									}"
									v-model="post.tagSelected" 
									mode="tags" 
									:closeOnSelect="false" 
									:createTag="true"
									:options="listTag"
									placeholder="Choose tag" />
							</div>
						</div>
					</div>
					<button class="bg-accentcolor rounded-lg text-white px-3 py-2 text-center text-sm w-max self-end justify-self-center" @click="save">Save</button>
				</div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
	import Multiselect from '@vueform/multiselect'
	import { QuillEditor } from '@vueup/vue-quill'
	import '@vueup/vue-quill/dist/vue-quill.snow.css';
	import { useToast } from "vue-toastification";

    export default defineComponent({
		props: ['categories', 'tags'],
        components: {
            AppLayout,
			Multiselect,
			QuillEditor
        },
		data() {
			return {
				post: {
					title: '',
					body: '<h1><b>Hello</b>, dunia</h1>',
					tagSelected: [],
					categorySelected: [],
					image: null
				},
				listCategory: [],
				listTag: []
			}
		},
		methods: {
			save() {
				if (this.post.title.trim() == '') return useToast().warning('Title can not be empty');
				if (this.post.body.trim() == '') return useToast().warning('Content can not be empty');
				if (this.post.tagSelected.length == 0) return useToast().warning('Tag can not be empty');
				if (this.post.categorySelected.length == 0) return useToast().warning('Category can not be empty');

				this.$inertia.post('/admin/post_new', this.post, {
					onSuccess: () => {
						useToast().success('Post successfully created')
						this.title = ''
						this.body = ''
						this.tagSelected = []
						this.categorySelected = []
					},
					onError: (e) => useToast().error(e)
				})
			},
			onImageChange(e) {
				e.preventDefault();
				this.post.image = null
				this.post.image = e.target.files[0]
				console.log(this.post)
			}
		},
		created() {
			this.categories.forEach(cat => {
				this.listCategory.push(cat.name)
			});
			this.tags.forEach(tag => {
				this.listTag.push(tag.name)
			});
		}
    })
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
<style scoped>
	.editor {
		min-height: 600px;
	}

	.grid-cols-3-1 {
		grid-template-columns: 2fr 1fr;
	}
</style>
