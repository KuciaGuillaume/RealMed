<script lang="ts">

  export let item : {
    title: string;
    content: string;
    date: string;
    imgLink: string;
  };

  $: console.log(item);

</script>

<button class="flex flex-col bg-white shadow-md border rounded-xl h-42 p-4 z-0 min-w-[400px] gap-4 duration-200">
  <div class="w-full">
    <h3 class="font-poppins text-sm h-10"> {item.title} </h3>
  </div>
  <div class="flex flex-row w-full gap-4 pr-4">
    <div class="min-w-20 max-w-20 min-h-20 max-h-24"> 
      <img src={item.imgLink} alt="news_image" class="object-cover size-full rounded-md"/>
    </div>
    <p class="font-poppins text-xs text-gray-600">
      {item.content}
    </p>
  </div>
</button>