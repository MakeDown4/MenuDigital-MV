<template>
    <div class="avo">
        <div class="about-us pai">
            <div class="div1">
                <h1 class="cor-azul-escuro">Criamos experiências culinárias únicas, aprimorando soluções personalizadas que satisfazem seus desejos.</h1>
            </div>
                <div class="div2">
                    <p>    
                        Nós preparamos pratos deliciosos e exclusivos para oferecer uma experiência gastronômica única aos nossos clientes. 
                        Nosso time trabalha com dedicação e paixão para entender suas preferências e necessidades, criando um menu personalizado com ingredientes frescos e de qualidade. 
                        Entregamos refeições incríveis que encantam os paladares mais exigentes, promovendo momentos memoráveis e duradouros. 
                        Oferecemos um ambiente aconchegante e acolhedor para que você possa desfrutar de momentos especiais com amigos e familiares. 
                        Somos o restaurante ideal para transformar seus momentos em momentos inesquecíveis.
                    </p>
                </div>
        </div>
    </div>
</template>
    
<script>
    export default {
        name: 'AboutUs'
    }
</script>

<style>

    .navbar-invisible {
    background-color: transparent !important;
    }

    .navbar-invisible .nav-link {
    color: #fff;
    animation: ease-in 1s;
    }

    .avo{
        margin-top: 6rem;
        margin-bottom: 6rem !important;
    }

    #title {
        color: rgba(75, 0, 130);
    }

    .div1 {
        border-top: 100px;
        width: 50%;
        justify-content: center;
        margin-right: 2rem;
    }

    .about-title {
        min-height: 80px;
    }

    .div2 {
        white-space: break-spaces;
        width: 50%;
        align-items: center;
        justify-content: center;
        margin-top: 10px;
    }
    .div2 p{
        font-size: 0.95rem !important;
    }
    .div1 h1{
        font-size: 2.2rem !important;
    }

    .pai {
        display: flex;
        justify-content: center;
        width: 70%;
        margin: auto auto;
        
    }

    @media (max-width:1100px) {
        
        .div1{
            width: 100%;
            margin-left: 0rem;

        }

        .div2{
            width: 100%;
            margin-left: 0rem;
        }

        .pai{
            display: block;
        }
    }
</style>