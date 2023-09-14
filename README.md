<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

# **Passos para a Criação Inicial do Projeto**

1. **Inicializando o Projeto:**
   
`composer create-project –prefer-dist laravel=8.5.9 FeirasLivres`


2. **Instalando o Pacote UI:**
   
`composer require laravel/ui:^3.2.1`


3. **Gerando o Esqueleto do Projeto com Vue.JS e Autenticação Web Nativa (Scaffold):**
   
`php artisan ui vue --auth`


4. **Baixando Dependências do Front-end:**
   
`npm install`


5. **Rodando o Vue.js:**
   
`npm run dev` + `php artisan serve`

[Em caso de problemas após o último passo, rode novamente o Passo 4 e repita o Passo 5]()


---

## **Pacotes Instalados pelo Composer**

### **fakerphp/faker@1.23.0**
*Descrição*: Gera dados falsos para testes e desenvolvimento.

---

## **Pacotes Instalados pelo Npm**

### **jquery@3.7.1**
Uma biblioteca JavaScript rápida, pequena e rica em recursos, utilizada para manipular o DOM e simplificar a interação com o HTML.



---


## Learning Laravel.[^1]
[^1]: Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Contributing.[^2]
[^2]Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## License.[^3]
[^3]The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
