<template>
  <svg
    xmlns="http://www.w3.org/2000/svg"
    xmlns:xlink="http://www.w3.org/1999/xlink"
    style="margin: auto; background: none repeat scroll 0% 0%; display: block"
    :width="width"
    :height="height"
    viewBox="0 0 100 100"
    preserveAspectRatio="xMidYMid"
  >
    <path
      fill="none"
      stroke="currentColor"
      stroke-width="5"
      stroke-dasharray="182.17813903808593 74.41078918457032"
      d="M24.3 30C11.4 30 5 43.3 5 50s6.4 20 19.3 20c19.3 0 32.1-40 51.4-40 C88.6 30 95 43.3 95 50s-6.4 20-19.3 20C56.4 70 43.6 30 24.3 30z"
      stroke-linecap="round"
      style="transform: scale(0.8); transform-origin: 50px 50px"
    >
      <animate
        attributeName="stroke-dashoffset"
        repeatCount="indefinite"
        dur="1.6949152542372878s"
        keyTimes="0;1"
        values="0;256.58892822265625"
      ></animate>
    </path>
  </svg>
</template>

<script setup>
defineProps({
  width: {
    type: String,
    default: "200px",
  },
  height: {
    type: String,
    default: "200px",
  },
});
</script>
