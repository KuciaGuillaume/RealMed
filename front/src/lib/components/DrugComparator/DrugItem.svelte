<script lang="ts">
  import DonutChart from "./DonutChart.svelte";

  export let isSelected: boolean = false;

  export let drug: {
    name: string,
    description: string,
    imgLink: string,
    score: number,
  };

</script>

<button on:click class="{isSelected ? "border-cblue" : "hover:bg-gray-50"}  flex flex-row gap-4 w-full min-h-40 h-40 max-h-40 shadow-md border-2 rounded-lg bg-white p-4">
  <div class="min-h-full max-h-full aspect-square rounded-lg overflow-hidden rounded-r-none">
    <img src={drug.imgLink} alt="" class="size-full object-cover">
  </div>
  <div class="flex flex-col gap-2 h-full">
    <h2 class="font-poppins text-sm text-left">{drug.name}</h2>
    <p class="font-poppins text-xs text-gray-600 text-left">{drug.description}</p>
  </div>
  <div class="h-full aspect-square">
    <DonutChart data={[
        {
          name: drug.name,
          value: drug.score,
          color: drug.score >= 50 ? '#32de84' : drug.score > 25 ? '#f7b52b' : '#f54242'
        },
        {
          name: 'gray',
          value: 100 - drug.score,
          color: '#F5F3F3'
        }
      ]}
    />
  </div>
</button>