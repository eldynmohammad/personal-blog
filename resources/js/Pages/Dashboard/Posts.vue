<template>
    <app-layout title="Posts">
        <template #header>
			<div class="flex">
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Posts 
				</h2>
				<inertia-link :href="route('createPostPage')" class="bg-accentcolor px-3 py-1 ml-3 rounded-lg text-white text-xs hover:bg-accentcolor-light transition-colors duration-300">Create a new post</inertia-link>
			</div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
					<h2 class="text-2xl mb-6 ml-2">List of Post</h2>

					<!-- This example requires Tailwind CSS v2.0+ -->
					<!-- <div class="bg-green-100 border-t-4 border-green-500 rounded-lg text-green-900 px-4 py-3 shadow-md my-4">
						<div class="flex">
							<div>
								<p class="text-sm">{{ $page.props.success.message }}</p>
							</div>
						</div>
					</div> -->
					<div class="flex flex-col">
						<div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
							<div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
								<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
									<table class="min-w-full divide-y divide-gray-200">
										<thead class="bg-gray-50">
											<tr>
												<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													Title
												</th>
												<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													Author
												</th>
												<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													Published
												</th>
												<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													Status
												</th>
												<th scope="col" class="relative px-6 py-3">
													<span class="sr-only">Edit</span>
												</th>
											</tr>
										</thead>
										<tbody class="bg-white divide-y divide-gray-200">
											<tr v-for="post in posts.data" :key="post.id">
												<td class="px-6 py-4 whitespace-nowrap">
													<div class="text-sm font-medium text-gray-900">
														{{ post.title }}
													</div>
												</td>
												<td class="px-6 py-4 whitespace-nowrap">
													<div class="text-sm text-gray-900">{{ post.user.name }}</div>
												</td>
												<td class="px-6 py-4 whitespace-nowrap">
													<div class="text-sm text-gray-600">{{ post.published_at }}</div>
												</td>
												<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
													<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
													Active
													</span>
												</td>
												<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
													<button @click="this.$inertia.visit(`/admin/single_post/${post.id}`)" class="bg-gray-400 rounded-md px-3 py-1 text-white hover:bg-gray-300">Edit</button>
													<button @click="showDeleteModal(post)" class="bg-red-500 rounded-md ml-2 px-3 py-1 text-white hover:bg-red-300">Delete</button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<pagination class="mt-6" :links="posts.links"/>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>

		<!-- Delete modal -->
		<v-tailwind-modal v-model="modalDelete">
			<template v-slot:title>Delete Category</template>
			<div class="mt-3 text-center sm:mt-0 sm:text-left mb">
				<label class="block text-sm font-medium text-gray-700">Are you sure want to delete this category?</label>
				</div>
			<div class="flex-shrink-0 flex justify-center items-center pt-4">
				<button class="bg-gray-200 px-3 py-2 text-sm rounded-lg" @click="modalDelete = false">cancel</button>
				<button class="bg-red-400 text-white px-3 py-2 text-sm rounded-lg ml-2" @click="deletePost">confirm</button>
			</div>
		</v-tailwind-modal>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
	import Pagination from '../Shared/Pagination.vue'
	import Button from '../../Jetstream/Button.vue'
	import VTailwindModal from '../../Layouts/VTailwindModal.vue';
	import { useToast } from "vue-toastification";

    export default defineComponent({
		props: ['posts'],
        components: {
            AppLayout,
			Pagination,
			Button,
			VTailwindModal
        },
		data() {
			return {
				post: {
					id: null
				},
				modalDelete: false
			}
		},
		methods: {
			showDeleteModal(post) {
				let obj = {
					id: post.id
				}
				this.post = obj
				this.modalDelete = true
			},

			deletePost() {
				this.$inertia.post(`/admin/delete_post/${this.post.id}`, this.post, {
					onSuccess: () => {
						useToast().success('Post successfully deleted')
						this.modalDelete = false
					},
					onError: (e) => useToast().error(e)
				})
			},
		}
    })
</script>
