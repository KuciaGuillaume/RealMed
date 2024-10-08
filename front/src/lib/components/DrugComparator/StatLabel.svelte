<script lang="ts">

  export let label: string;
  export let value: string;

</script>

<div class="w-full h-10 border rounded-lg flex items-center bg-white gap-4 overflow-hidden">
  <div class="h-full min-w-[10rem] max-w-[10rem] bg-gray-100 flex items-center px-2">
    <span class="font-poppins text-xs"> {label} </span>
  </div>
  <div class="h-full flex items-center justify-center pr-4">
    <span class="text-xs"> {value} </span>
  </div>
</div>