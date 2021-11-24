<template>
	<blog-layout>
		<div class="container px-4 mx-auto lg:grid t3 lg:mt-4 py-6 gap-5">
			<!-- Profile -->
			<div class="relative">
				<div class="lg:fixed profile flex flex-col text-centermd:text-left rounded-3xl bg-white shadow-xl p-6 lg:mt-8">
					<div class="w-full md:w-12 flex justify-center md:justify-start mb-2">
						<img src="https://source.unsplash.com/collection/1346951/150x150?sig=1" class="rounded-full h-12 w-12">
					</div>
					<div class="flex flex-col justify-center md:justify-start">
						<p class="font-semibold text-xl">{{ post.user.name }}</p>
						<p class="text-xs">Happy gurl </p>
						<div class="flex items-center justify-center md:justify-start text-2xl no-underline text-blue-800 pt-4">
							<a class="" href="#">
								<box-icon type='logo' name='facebook'></box-icon>
							</a>
							<a class="pl-4" href="#">
								<box-icon name='instagram' type='logo' ></box-icon>
							</a>
							<a class="pl-4" href="#">
								<box-icon name='twitter' type='logo' ></box-icon>
							</a>
							<a class="pl-4" href="#">
								<box-icon name='linkedin' type='logo' ></box-icon>
							</a>
						</div>
					</div>
				</div>
			</div>

			<!-- Content -->
			<article class="order flex flex-col">
				<div class="px-4 mb-8 opacity-80">
					<h3 class="text-4xl font-bold mb-4 capitalize">{{ post.title }}</h3>
					<p class="text-sm">
						Published in
						<span v-for="(cat, i) in post.categories" :key="cat.id">
							<span v-if="i > 0">, </span>
							<inertia-link :href="`/${cat.slug}`" class="font-semibold hover:text-gray-800 transition-all duration-300" > {{ cat.name }} </inertia-link>
						</span>
						, on {{ post.published_at }}
					</p>
				</div>
				<!-- Article Image -->
				<div class="hover:opacity-75">
					<img class="rounded-3xl" src="https://source.unsplash.com/collection/1346951/1000x500?sig=1">
				</div>
				<div class="flex flex-col justify-start p-6">
					<div class="body">
						<div v-html="post.body"></div>	
					</div>	
					<div class="text-sm pt-8">
						<template v-for="(tag, i) in post.tags" :key="i">
							<inertia-link :href="`/tag/${tag.slug}`" class="bg-accentcolor rounded-full px-2 py-1 text-white mr-1 hover:opacity-80">
								{{ tag.name }}
							</inertia-link>
						</template>
					</div>
				</div>
				<div class="w-full flex pt-6 border-t-2">
					<inertia-link v-if="prevPost" v-show="prevPost" :href="`/${prevPost.slug}`" class="w-1/2 text-left p-6">
						<p class="text-lg text-accentcolor font-bold flex items-center"><box-icon name='left-arrow-alt' class="text-accentcolor"></box-icon> Previous</p>
						<p class="pt-2">{{ prevPost.title }}</p>
					</inertia-link>
					<inertia-link v-if="nextPost" :href="`/${nextPost.slug}`" class="w-1/2 text-right p-6">
						<p class="text-lg text-accentcolor font-bold flex items-center justify-end">Next <box-icon name='right-arrow-alt' ></box-icon></p>
						<p class="pt-2">{{ nextPost.title }}</p>
					</inertia-link>
				</div>
			</article>

			<!-- Posts -->
			<div>
				<p class="text-xl mb-6 px-4">Latest Post</p>
				<div class="grid gap-y-2">
					<inertia-link :href="`/${post.slug}`" v-for="post in posts" :key="post.id" class="flex hover:bg-white hover:shadow-lg transition-all duration-300 p-4 rounded-2xl">
						<img class="rounded-md w-14 h-14" src="https://source.unsplash.com/collection/1346951/500x500?sig=1">
						<div class="text-sm ml-2">
							<p>{{ post.title }}</p>
							<p class="text-xs opacity-50">{{ post.published_at }}</p>
						</div>
					</inertia-link>
				</div>
			</div>
		</div>
	</blog-layout>
</template>

<script>
import 'boxicons'
import { defineComponent } from "vue";
import BlogLayout from "@/Layouts/BlogLayout.vue";
import axios from 'axios'

export default defineComponent({
	data() {
		return {
			posts: []
		}
	},
	props: ['post', 'prevPost', 'nextPost'],
	components: {
		BlogLayout,
	},
	created() {
		axios
			.get('/get_posts')
			.then(response => 
			this.posts = response.data.slice(0, 4)
			
			)
	},
	computed: {
		// limitedList() {
		// 	if (this.showShortList) {
		// 		return this.items.slice(0, this.default_limit)
		// 	}
		// 	return this.Items
		// }
	}

});
</script>

<style>
.t3 {
	grid-template-columns: 220px 2fr 1fr;
}

.profile {
	width: 220px;
}

@media screen and (max-width: 1024px) {
	.order:nth-child(1) {
		order: 2;
	}
	
	.order:nth-child(2) {
		order: 1;
	}
	
	.order:nth-child(3) {
		order: 3;
	}
}
</style>