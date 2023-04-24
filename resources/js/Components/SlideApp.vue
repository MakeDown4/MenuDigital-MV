<template>
  <SlideShow :images="imagePaths" />
</template>

<script>
import SlideShow from './sub-components/SlideShow.vue'

export default {
  name: 'SlideApp',
  components: {
    SlideShow
  },
  data() {
    return {
      imagePaths: [
        'image.jpg',
        'image2.jpg',
        'image3.jpg',
      ]
    }
  }
}
</script>

<style></style>
