<template>
	<blog-layout >
		<div class="container mx-auto flex flex-wrap py-6 lg:mt-4">
			<section class="w-full md:w-2/3 flex flex-col items-center px-3">
				<!-- Page content -->
				<article v-for="post in posts" :key="post.id" class="relative w-full flex flex-col lg:grid md:gtc-1-2 bg-white shadow-xl my-3 rounded-3xl overflow-hidden">
					<!-- Article Image -->
					<a href="#" class="hover:opacity-75 transition-all duration-300 md:p-6">
						<img class="w-full md:h-full md:rounded-xl object-cover" src="https://source.unsplash.com/collection/1346951/1000x500?sig=1">
					</a>
					<div class="flex flex-col justify-start px-6 py-2">
						<inertia-link :href="`/${post.slug}`" class="text-3xl font-semibold hover:text-gray-700 pb-4 transition-all duration-300 custom-truncate-title capitalize">{{ post.title }}</inertia-link>
						<p class="text-xs pb-3 text-gray-700">
							Published in
							<span v-for="(cat, i) in post.categories" :key="cat.id">
									<span v-if="i > 0">, </span>
									<inertia-link :href="`/${cat.slug}`" class="font-semibold hover:text-gray-800 transition-all duration-300" > {{ cat.name }} </inertia-link>
							</span>
								<!-- </span> -->
							, on {{ post.published_at }}
						</p>
						<p class="pb-6 custom-truncate-body" v-html="post.body"></p>
						<inertia-link :href="`/${post.slug}`" class="text-right uppercase my-4 text-accentcolor-dark hover:text-black">Continue Reading <i class="fas fa-arrow-right"></i></inertia-link>
					</div>
				</article>

			</section>
			<!-- Sidebar Section -->
			<aside class="w-full md:w-1/3 flex flex-col items-center px-3">
				<div class="w-full bg-white flex flex-col my-3 p-6 rounded-3xl shadow-xl">
					<p class="text-xl font-semibold pb-5">Categories</p>
					<div class="grid gap-y-2 ">
						<inertia-link :href="`/category/${category.slug}`" v-for="(category, i) in categories" :key="i" class="p-3 rounded-xl bg-gray-50 hover:bg-accentcolor hover:text-white transition-all duration-300">{{ category.name }}</inertia-link>
					</div>
				</div>
				<div class="w-full bg-white flex flex-col my-3 p-6 rounded-3xl shadow-xl">
					<p class="text-xl font-semibold pb-5">Tags</p>
					<div class="flex flex-wrap gap-2 text-sm">
						<!-- <div v-for="(tag, i) in tags" :key="i"> -->
							<inertia-link :href="`/tag/${tag.slug}`" v-for="(tag, i) in tags" :key="i" class="px-2 py-1 rounded-full bg-accentcolor hover:bg-accentcolor-dark text-white transition-all duration-300">{{ tag.name }}</inertia-link>
						<!-- </div> -->
					</div>
				</div>
				<div class="w-full bg-white flex flex-col my-3 p-6 rounded-3xl shadow-xl">
					<p class="text-xl font-semibold pb-5">About Us</p>
					<p class="pb-2">
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas
						mattis est eu odio sagittis tristique. Vestibulum ut finibus leo. In
						hac habitasse platea dictumst.
					</p>
					<a href="#" class="w-full bg-accentcolor text-white font-bold text-sm uppercase rounded-xl hover:bg-accentcolor-light flex items-center justify-center px-2 py-3 mt-4 transition-all duration-300">
						Get to know us
					</a>
				</div>
			</aside>
		</div>
	</blog-layout>
</template>

<script>
import { defineComponent } from "vue";
import BlogLayout from "@/Layouts/BlogLayout.vue";
import axios from 'axios';

export default defineComponent({
	props: ['posts'],
	components: {
		BlogLayout,
	},
	data() {
		return {
			categories: [],
			tags: []
		}
	},
	created() {
		const cat = axios.get('/get_categories')
		const tag = axios.get('/get_tags')
		axios
			.all([cat, tag])
			.then(axios.spread((...responses) =>{
				const catResponse = responses[0].data
				const tagResponse = responses[1].data

				this.categories = catResponse
				this.tags = tagResponse
				// console.log(catResponse, tagResponse)
			}))
			.catch(errors => {
				console.error(errors);
			});
	}
});
</script>

<style scoped>
.gtc-1-2 {
	grid-template-columns: 220px 1fr;
}

.custom-truncate-title {
	overflow: hidden;
	max-width: 25ch;
	text-overflow: ellipsis;
	white-space: nowrap;
}

.custom-truncate-body {
	display: -webkit-box;
	overflow: hidden;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
}
</style>