<template>
<MenuHome />
    <div class="text-center border-top container-items">
        <h1 class="text-white" style="margin-bottom: 5vh; font-size: 2rem; font-weight: bold; text-shadow: 5px 10px 15px rgba(255, 0, 0, 1); letter-spacing: 0.1em;">Cardápio</h1>
        <div class="menu-cards">
            <div v-for="menuItem in menuItems" :key="menuItem.id" class="menu-card">
                <div class="menu-card-image">
                    <img :src="'/storage/menuImg/' + menuItem.upload_img" alt="">
                </div>
                <div class="menu-card-content" style="background-color: #f2f2f2">
                    <h2>{{ menuItem.name }}</h2>
                    <p>{{ menuItem.description }}</p>
                    <p>{{ menuItem.category.name }}</p>
                    <p>Preço: R$ {{ menuItem.price }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.menu-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  grid-gap: 20px;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.menu-card {
    display: flex;
    flex-direction: column;
    background-color: #fff;
    border: 1px solid rgba(204, 204, 204, 0.363);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
    transition: box-shadow 0.2s ease-in-out;
    z-index: 1;
}

.menu-card-content h2 {
  font-style: italic;
  font-weight: bold;
}

.menu-card-content p.category-name {
  font-style: italic;
}

.menu-card:hover {
    box-shadow: 5px 5px 30px rgba(255, 0, 0, 1);
}

.menu-card-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    background-color: #eee;
    box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.1);
}

.border-top{
    padding-top: 10vh;
}

.container-items{
    margin: 0 auto;
    width: 90% !important;
}

body {
  background-image: url('images/image5.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

</style>

<script>
import MenuHome from '../../Components/MenuHome.vue';

export default {
    props: {
        menuItems: Array,
    },
    components: {
        MenuHome
    }
};
</script>