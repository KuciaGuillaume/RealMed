<script lang="ts">

  export let color : 'green' | 'red' | 'orange' = 'green';

  const classColor = {
    green: 'bg-green-500/40 border border-green-500/40',
    red: 'bg-red-500/20 border border-red-500/40',
    orange: 'bg-orange-500/40 border border-orange-500/40'
  }

</script>

<span class="{classColor[color]} rounded-md px-1 text-xs font-poppins">
  <slot/>
</span>