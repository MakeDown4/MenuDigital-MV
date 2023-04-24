<template>
  <div class="slide-show">
    <img v-for="(image, index) in images" :src="(`../../../../images/${image}`)" :key="index"
      :class="{ active: index === currentIndex }">
    <!-- <div class="controls">
      <button class="control-button" @click="previous">&lt;</button>
      <button class="control-button" @click="next">&gt;</button>
    </div> -->
    <div class="slide-indicators">
      <span v-for="(image, index) in images" :key="index" :class="{ active: index === currentIndex }"
        @click="goTo(index)"></span>
    </div>
  </div>
</template>

<script>
export default {
    name: "SlideShow",
    props: {
        images: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            currentIndex: 0,
        };
    },
    methods: {
        previous() {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        },
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
        },
        goTo(index) {
            this.currentIndex = index;
        },
  
    },
    mounted() {
        setInterval(() => {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
        }, 6000);
    },
}
</script>

<style>
.slide-show {
  position: relative;
  width: 100%;
  height: 50rem;
  background-color: black;
  display: flex;
  align-items: center;
}

.slide-show img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0;
  transition: opacity 0.5s ease-in-out;
}

.slide-show img.active {
  opacity: 1;
}

.slide-show .controls {
  position: absolute;
  top: 50%;
  display: flex;
  justify-content: space-between;
  width: 100%;
  transform: translateY(-50%);
}

.slide-show .controls .control-button {
  background-color: transparent;
  border: none;
  color: aliceblue;
  font-size: 2.5rem;
  padding: 10px;
  margin: 0 10px;
  cursor: pointer;
  display: flex;
}


.slide-show .slide-indicators {
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 2rem;
}

.slide-show .slide-indicators span {
  width: 0.5rem;
  height: 0.5rem;
  border-radius: 50%;
  margin: 0 0.5rem;
  background-color: #ccc;
  cursor: pointer;
}

.slide-show .slide-indicators span.active {
  background-color: white;
}
</style>
