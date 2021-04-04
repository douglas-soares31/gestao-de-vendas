<template>
  <inertia-link :href="'/'">
    <img
      :src="imageLogo"
      class="object-scale-down h-48 w-30 rounded-full flex items-center justify-center"
    />
  </inertia-link>
</template>

<script>
import imageLogo from "../../../public/img/ckstore_logomarca.jpeg";
export default {
  data: function () {
    return {
      imageLogo: imageLogo,
    };
  },
};
</script>