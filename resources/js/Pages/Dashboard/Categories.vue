<template>
    <app-layout title="Categories">
        <template #header>
            <div class="flex">
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Categories 
				</h2>
				<button @click="modalAdd = true" class="bg-accentcolor px-4 py-1 ml-3 rounded-lg text-white text-sm hover:bg-accentcolor-light transition-colors duration-300">+</button>
			</div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
					<h2 class="text-2xl mb-6 ml-2">List of Category</h2>
				
					<!-- This example requires Tailwind CSS v2.0+ -->
					<div class="flex flex-col">
						<div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
							<div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
								<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
									<table class="min-w-full divide-y divide-gray-200">
										<thead class="bg-gray-50">
											<tr>
												<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													Category Name
												</th>
												<th scope="col" class="relative px-6 py-3">
													<span class="sr-only">Edit</span>
												</th>
											</tr>
										</thead>
										<tbody class="bg-white divide-y divide-gray-200">
											<tr v-for="category in categories" :key="category.id">
												<td class="px-6 py-4 whitespace-nowrap">
													<div class="text-sm font-medium text-gray-900">
														{{ category.name }}
													</div>
												</td>
												<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
													<button @click="showEditModal(category)" class="bg-gray-400 rounded-md px-3 py-1 text-white hover:bg-gray-300">Edit</button>
													<button @click="showDeleteModal(category)" class="bg-red-500 rounded-md ml-2 px-3 py-1 text-white hover:bg-red-300">Delete</button>
												</td>
											</tr>

											<!-- More people... -->
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

            </div>
        </div>

		<!-- Modals -->
		<!-- Create -->
		<v-tailwind-modal v-model="modalAdd">
			<template v-slot:title>Add category</template>
			<div class="mt-3 text-center sm:mt-0 sm:text-left mb">
				<label class="block text-sm font-medium text-gray-700">Name</label>
				<input type="text" v-model="data.categoryName" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-2 pr-12 sm:text-sm border-gray-300 rounded-md mt-2" placeholder="New category name">
			</div>
			<div class="flex-shrink-0 flex justify-center items-center pt-4">
				<button class="bg-gray-200 px-3 py-2 text-sm rounded-lg" @click="modalAdd = false">cancel</button>
				<button class="bg-accentcolor text-white px-3 py-2 text-sm rounded-lg ml-2" @click="save">confirm</button>
			</div>
		</v-tailwind-modal>

		<!-- Edit -->
		<v-tailwind-modal v-model="modalEdit">
			<template v-slot:title>Edit category</template>
			<div class="mt-3 text-center sm:mt-0 sm:text-left mb">
				<label class="block text-sm font-medium text-gray-700">Name</label>
				<input type="text" v-model="editData.categoryName" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-2 pr-12 sm:text-sm border-gray-300 rounded-md mt-2">
			</div>
			<div class="flex-shrink-0 flex justify-center items-center pt-4">
				<button class="bg-gray-200 px-3 py-2 text-sm rounded-lg" @click="modalEdit = false">cancel</button>
				<button class="bg-accentcolor text-white px-3 py-2 text-sm rounded-lg ml-2" @click="edit">confirm</button>
			</div>
		</v-tailwind-modal>

		<v-tailwind-modal v-model="modalDelete">
			<template v-slot:title>Delete Category</template>
			<div class="mt-3 text-center sm:mt-0 sm:text-left mb">
				<label class="block text-sm font-medium text-gray-700">Are you sure want to delete this category?</label>
				</div>
			<div class="flex-shrink-0 flex justify-center items-center pt-4">
				<button class="bg-gray-200 px-3 py-2 text-sm rounded-lg" @click="modalDelete = false">cancel</button>
				<button class="bg-red-400 text-white px-3 py-2 text-sm rounded-lg ml-2" @click="deleteCategory">confirm</button>
			</div>
		</v-tailwind-modal>
                
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
	import { useToast } from "vue-toastification";
	import VTailwindModal from '../../Layouts/VTailwindModal.vue';
	import Modal from '../../Jetstream/Modal.vue';

    export default defineComponent({
		components: {
			AppLayout,
			VTailwindModal,
			Modal
		},
		data() {
			return {
				modalAdd: false,
				modalEdit: false,
				modalDelete: false,
				data: {
					categoryName: '',
				},
				editData: {
					categoryName: ''
				}
			}
		},
		props: ['categories'],
		methods: {
			save() {
				if (this.data.categoryName.trim() == '') return useToast().warning('Category name is required')

				this.$inertia.post('/admin/create_category', this.data, {
					onSuccess: () => {
						useToast().success('Category successfully created')
						this.data.categoryName = ''
						this.modalAdd = false
					},
					onError: (e) => useToast().error(e)
				})
			},
			edit() {
				if (this.editData.categoryName.trim() == '') return useToast().warning('Category name is required')

				this.$inertia.post(`/admin/edit_category/${this.editData.id}`, this.editData, {
					onSuccess: () => {
						useToast().success('Category successfully created')
						this.editData.categoryName = ''
						this.modalEdit = false
					},
					onError: (e) => useToast().error(e)
				})
			},
			deleteCategory() {
				this.$inertia.post(`/admin/delete_category/${this.editData.id}`, this.editData, {
					onSuccess: () => {
						useToast().success('Category successfully deleted')
						this.modalDelete = false
					},
					onError: (e) => useToast().error(e)
				})
			},
			// Edit pop-up modal
			showEditModal(category) {
				let obj ={
					id: category.id,
					categoryName: category.name
				}
				this.editData = obj
				this.modalEdit = true
			},
			showDeleteModal(category) {
				let obj ={
					id: category.id,
				}
				this.editData = obj
				this.modalDelete = true
			}
		},
    })
</script>
