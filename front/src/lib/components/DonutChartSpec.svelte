<script lang="ts">
	import { slide } from 'svelte/transition';
	import { onMount } from 'svelte';

	export let label: string | null = 'Label name';
	export let data: { category: string; value: number; color: string }[] = [
		{ category: 'Category A', value: 50, color: '#baf8d0' },
		{ category: 'Category B', value: 25, color: '#fde68a' },
		{ category: 'Category C', value: 25, color: '#fecaca' }
	];

	let total = data.reduce((acc, { value }) => acc + value, 0.000001);
	let cumulativePercentage = 0;
	let hoveredCategory: string | null = null;
	let donutViewer: HTMLDivElement;
	let donutViewerVisible = false;
	let displayValue: number | undefined = undefined;
	let donut: HTMLDivElement;
	let isMouseMoved = false;

	const calculatePath = (value: number, total: number) => {
		const outerRadius = 100;
		const innerRadius = 60;
		const startAngle = cumulativePercentage * 2 * Math.PI;
		cumulativePercentage += value / total;
		const endAngle = cumulativePercentage * 2 * Math.PI;

		const startXOuter = outerRadius + outerRadius * Math.cos(startAngle);
		const startYOuter = outerRadius + outerRadius * Math.sin(startAngle);

		const endXOuter = outerRadius + outerRadius * Math.cos(endAngle);
		const endYOuter = outerRadius + outerRadius * Math.sin(endAngle);

		const endXInner = outerRadius + innerRadius * Math.cos(endAngle);
		const endYInner = outerRadius + innerRadius * Math.sin(endAngle);

		const startXInner = outerRadius + innerRadius * Math.cos(startAngle);
		const startYInner = outerRadius + innerRadius * Math.sin(startAngle);

		const largeArcFlag = value / total > 0.5 ? 1 : 0;

		let path = `M ${startXOuter},${startYOuter} A ${outerRadius},${outerRadius} 0 ${largeArcFlag} 1 ${endXOuter},${endYOuter}`;
		path += `L ${endXInner},${endYInner}`;
		path += `A ${innerRadius},${innerRadius} 0 ${largeArcFlag} 0 ${startXInner},${startYInner}`;
		path += 'Z';
		return path;
	};

	const handleMouseEnter = (category: string) => {
		const categoryData = data.find((d) => d.category === category);
		if (categoryData !== undefined) {
			hoveredCategory = category;
			displayValue = categoryData.value;
			donutViewerVisible = true;
		}
	};

	const handleMouseLeave = () => {
		hoveredCategory = null;
		donutViewerVisible = false;
	};

	const handleMouseMove = (e: MouseEvent) => {
		if (donutViewerVisible) {
			if (donutViewer) {
				donutViewer.style.top = `${e.clientY - donut.getBoundingClientRect().y - 50}px`;
				donutViewer.style.left = `${e.clientX - donut.getBoundingClientRect().x}px`;
			}
			isMouseMoved = true;
		}
	};

	onMount(() => {
		document.addEventListener('mousemove', handleMouseMove);
		return () => {
			document.removeEventListener('mousemove', handleMouseMove);
		};
	});
</script>

<div bind:this={donut} class="h-full w-full flex flex-col relative overflow-hidden space-y-4">
	{#if label}
		<div class="font-medium text-grayscale-700 shrink-0">{label}</div>
	{/if}
	<div class="flex flex-grow overflow-hidden flex-row px-2">
		<div class="relative w-1/2 h-full">
			<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white w-[60%] max-w-[180px] aspect-square rounded-full flex justify-center items-center z-10" />
			<svg class="relative w-full h-full overflow-visible" viewBox="0 0 200 200">
				{#each data as { category, value, color }, index}
					<g on:mouseenter={() => handleMouseEnter(category)} on:mouseleave={handleMouseLeave}>
						<path
							class="{hoveredCategory === category ? 'opacity-80' : 'opacity-100'} duration-200"
							d={calculatePath(value, total)}
							fill={color}
							stroke-linejoin="round"
							stroke-linecap="round"
							style="transition: stroke-width 0.2s ease, stroke 0.2s ease;"
						/>
					</g>
				{/each}
			</svg>
		</div>
		<div class="w-1/2 h-full flex flex-col items-start justify-center space-y-2 pl-4">
			{#each data as { category, color }, index}
				<div class="flex flex-row items-center space-x-2">
					<div class="w-4 h-4 rounded-full" style={`background-color: ${color};`} />
					<div class="text-grayscale-700 text-sm">{category}</div>
				</div>
			{/each}
		</div>
	</div>
	{#if donutViewerVisible && isMouseMoved}
		<div
			in:slide={{ duration: 300, delay: 200 }}
			bind:this={donutViewer}
			class="absolute h-8 rounded-md flex flex-row items-center bg-white overflow-hidden border drop-shadow-md text-sm z-40 whitespace-nowrap"
		>
			<div class="h-full px-2 flex justify-center items-center bg-gray-200">
				<span> {displayValue} </span>
			</div>
			<span class="px-2"> {hoveredCategory} </span>
		</div>
	{/if}
</div>
