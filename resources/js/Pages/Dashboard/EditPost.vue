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
				<div class="bg-white shadow-xl sm:rounded-lg p-8 flex flex-col">
					<h2 class="text-2xl mb-6 ml-2">Edit post</h2>
					
					<!-- Form -->
					<div class="grid grid-cols-3-1">
						<div class="px-2">
							<div class="mb-4">
								<label class="ml-2 mb-2 block text-sm">Title</label>
								<input type="text" v-model="post.title" class="w-full px-3 py-2.5 border bg-white shadow-lg border-gray-200 outline-none rounded-lg" placeholder="Post's title">
							</div>
							<div class="mb-4">
								<label class="ml-2 mb-2 block text-sm">Content</label>
								<QuillEditor v-model:content="post.body" contentType="html" toolbar="full" theme="snow" class="border bg-white shadow-md border-gray-200"/>
							</div>
						</div>
						<div class="px-2">
							<!-- <div class="mb-4">
								<label class="ml-2 mb-2 block text-sm">Title</label>
								<input type="text" class="w-full px-3 py-2 border bg-white shadow-lg border-gray-200 outline-none rounded-lg">
							</div> -->
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
		props: ['singlePost', 'categories', 'tags'],
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
				},
				listCategory: [],
				listTag: []
			}
		},
		methods: {
			save() {
				if (this.post.title.trim() == '') return useToast().warning('Title can not be empty');
				if (this.post.body.trim() == '') useToast().warning('Content can not be empty');
				if (this.post.tagSelected.length == 0) useToast().warning('Tag can not be empty');
				if (this.post.categorySelected.length == 0) useToast().warning('Category can not be empty');

				this.$inertia.post(`/admin/edit_post/${this.singlePost.id}`, this.post, {
					onSuccess: () => {
						this.toast.success('Post successfully edited')
						this.title = ''
						this.body = ''
						this.tagSelected = []
						this.categorySelected = []
					},
					onError: (e) => useToast().error(e)
				})
				
			}
		},
		created() {
			this.categories.forEach(cat => {
				this.listCategory.push(cat.name)
			});
			this.tags.forEach(tag => {
				this.listTag.push(tag.name)
			});
			this.post.title = this.singlePost.title
			this.post.body = this.singlePost.body
			console.log(this.post.categorySelected);

			this.singlePost.categories.forEach(cats => this.post.categorySelected.push(cats.name))
			this.singlePost.tags.forEach(tags => this.post.tagSelected.push(tags.name))
			// this.post.categorySelected = this.singlePost.categories
			// this.post.tagSelected = this.singlePost.tags

		}
    })
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
<style scoped>
	.grid-cols-3-1 {
		grid-template-columns: 2fr 1fr;
	}
</style>
