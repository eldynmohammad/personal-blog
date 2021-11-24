<template >
	<div class="bg-gray-100">

		<!-- Top Bar Nav -->
		<nav class="w-full">
			<div class="w-full container mx-auto flex flex-wrap items-center justify-between px-4 border-b-2 py-3">
				<inertia-link href="/" class="text-5xl font-bold">e.</inertia-link>
				
			</div>
		</nav>

		<div class="mx-auto ">
			<!-- Posts Section -->
			<main>
				<slot></slot>
			</main>
		</div>

		<footer class="w-full bg-accentcolor text-white p-8 text-center">
			ell &copy; 2021. All Rights Reserved.
		</footer>
	</div>
</template>
