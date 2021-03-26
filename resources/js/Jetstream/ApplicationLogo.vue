<template>
  <img
    :src="imageLogo"
    class="object-scale-down h-48 w-30 rounded-full h-48 w-30 flex items-center justify-center"
  />
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