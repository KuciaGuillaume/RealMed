<script lang="ts">
  import * as d3 from "d3";

  let width = 450;
  let height = 450;
  let margin = 40;

  // Le rayon du diagramme est la moitié de la largeur ou de la hauteur (la plus petite). On soustrait une marge.
  let radius = Math.min(width, height) / 2 - margin;

  // Données avec la propriété 'color' utilisée pour la couleur des segments
  export let data = [
    { name: "a", value: 30, color: "#32de84" },
    { name: "b", value: 35, color: "#ff5c00" },
  ];
  export let notDisplayScore = false;

  // Calculer la position de chaque groupe dans le pie chart
  interface DataItem {
    name: string;
    value: number;
  }

  const pie = d3
    .pie<DataItem>()
    .sort(null) // Ne pas trier les groupes par taille
    .value((d) => d.value);
  const data_ready = pie(data);

  // Générateur d'arc
  const arc = d3
    .arc()
    .innerRadius(radius * 0.5) // Taille du trou du donut
    .outerRadius(radius * 0.8);

  // Un autre arc pour positionner les étiquettes (non dessiné)
  const outerArc = d3
    .arc()
    .innerRadius(radius * 0.9)
    .outerRadius(radius * 0.9);

  // Calcul du score à afficher (par exemple, la somme des valeurs)
  let score = data[0].value;
</script>

<svg
  {width}
  {height}
  viewBox="{-width / 2} {-height / 2} {width} {height}"
  style:max-width="100%"
  style:height="auto"
>
  <g class="chart-inner">
    {#each data_ready as slice}
      <path
        d={arc(slice)}
        fill={slice.data["color"]}
        stroke="white"
      />
    {/each}

    {#if !notDisplayScore}
      <text
        x="0"
        y="0"
        text-anchor="middle"
        alignment-baseline="middle"
        font-size="48"
        fill="#333"
        class="font-poppins"
      >
        {score}
      </text>
    {/if}
  </g>
</svg>

<style>
  :global(body) {
    margin: 0;
  }
</style>