<template>
<div id="container">
  <section id="categories-section">
    <template>
      <button @click="showCategoryPopUp = true" class="learn-more">
        <span class="circle" aria-hidden="true">
          <i class="fas fa-plus"></i>
        </span>
      </button>
      <pop-up-form v-if="showCategoryPopUp" @close="showCategoryPopUp = false">
          <category-form @close="showCategoryPopUp = false" @update="FetchCategorys" />
      </pop-up-form>
      <div style="width: 50%;">
        <template v-for="category in categories.data">
          <div :key="category.id" class="ks-cboxtags">
              <input type="checkbox" :id="category.id" :value="category.name">
              <label :for="category.id">{{ category.name }}</label>
          </div>
        </template>
      </div>
    </template>
  </section>
  <section id="products-section">
    <div>
      <button style="position: fixed;" @click="showPopUp = true" class="learn-more">
        <span class="circle" aria-hidden="true">
          <i class="fas fa-plus"></i>
        </span>
      </button>
      <pop-up-form v-if="showPopUp" @close="showPopUp = false">
          <product-form @close="showPopUp = false" :options="categories.data" @update="FetchProducts" />
      </pop-up-form>
      <template v-for="product in products.data">
        <div style="position: relative;" :key="product.id">
          <product-card  @edit="FetchProduct(product.id)" :product="product" />
          <button @click="DeleteProduct(product.id)" class="card--dalate-button"><i class="fas fa-times"></i></button>
        </div>
      </template>
      <pop-up-form v-if="showEdit" @close="showEdit = false">
        <product-form @close="showEdit = false" :product="product.data" :options="categories.data" @update="FetchProducts" />
      </pop-up-form>
    </div>
    <loading
     :show="show"
     :label="label"
     :overlay="overlay">
  </loading>
  </section>
</div>
</template>

<script>
import ProductCard from './components/ProductCard.vue'
import Carousel from './components/Carousel.vue'
import CategoryForm from './components/CategoryForm.vue'
import ProductForm from './components/ProductForm.vue'
import PopUpForm from './components/PopUpForm.vue'
import Axios from 'axios'
import loading from 'vue-full-loading'

export default {
  name: 'App',
  components: {
    ProductCard,
    Carousel,
    CategoryForm,
    ProductForm,
    PopUpForm,
    loading
  },
  data: () => ({
    showPopUp: false,
    showCategoryPopUp: false,
    showEdit: false,
    categories: [],
    products: [],
    product: null,
    show: false,
    label: 'Loading...',
    overlay: true
  }),
  methods: {
    async DeleteProduct (id) {
      if (confirm('Are you sure you want to delete this product?')){
        this.show = true
        await Axios.delete(`http://store.test/api/products/${id}`)
        this.FetchProduct()
        this.show = false
      }
    },
    async FetchProduct (id) {
      this.show = true
      this.product =  await Axios.get(`http://store.test/api/products/${id}`)
      this.show = false
      this.showEdit = true
    },
    async FetchCategory () {
      this.categories = await Axios.get('http://store.test/api/categories')
    },
    async FetchProducts () {
      this.products = await Axios.get('http://store.test/api/products')
    }
  },
  created () {
    this.FetchCategory()
    this.FetchProducts()
  }
}
</script>

<style lang="scss">
$bg: #f3f8fa;
$white: #fff;
$black: #282936;
$red: #e04f62;

.card--dalate-button {
    color:$black;
    font-size: 1.0rem;
    font-weight: 600;
    display: block;
    position: absolute;
    top: 1.5rem;
    right: 2rem;
    &:hover {
      color: $red;
    }
}

* {
  box-sizing: border-box;
  &::before, &::after {
    box-sizing: border-box;
  }
}

body {
  font-family: 'Roboto', sans-serif;
  font-weight: 400;
  font-size: 0.9375rem;
  min-height: 100vh;
  margin: 0;
  line-height: 1.6;
  text-rendering: optimizeLegibility;
}

button {
  position: absolute;
  right: 15em;
  display: inline-block;
  cursor: pointer;
  outline: none;
  border: 0;
  vertical-align: middle;
  text-decoration: none;
  background: transparent;
  padding: 0;
  font-size: inherit;
  font-family: inherit;
  &.learn-more {
    height: auto;
    .circle {
      position: relative;
      display: block;
      margin: 0;
      width: 3rem;
      height: 3rem;
      background: $black;
      border-radius: 1.625rem;
      .fas {
        position: absolute;
        top: 0;
        bottom: 0;
        margin: auto;
        color: $white;
        &.fa-plus {
          left: 0.625rem;
          width: 1.125rem;
          height: 0.125rem;
          background: none;
          &::before {
            position: absolute;
            content: '\f067';
            top: -0.28rem;
            right: 0.0628rem;
            width: 0.625rem;
            height: 0.625rem;
          }
        }
      }
    }
  }
}
#categories-section {
  display: flex;
  justify-content: center;
  align-items: center;
  div.ks-cboxtags {
      list-style: none;
      padding: 5px;
  }
  div.ks-cboxtags {
    display: inline;
  }
  div.ks-cboxtags label{
      display: inline-block;
      background-color: rgba(255, 255, 255, .9);
      border: 2px solid rgba(139, 139, 139, .3);
      color: #adadad;
      border-radius: 25px;
      white-space: nowrap;
      margin: 3px 0px;
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      -webkit-tap-highlight-color: transparent;
      transition: all .2s;
  }

  div.ks-cboxtags  label {
      padding: 8px 12px;
      cursor: pointer;
  }

  div.ks-cboxtags label::before {
      display: inline-block;
      font-style: normal;
      font-variant: normal;
      text-rendering: auto;
      -webkit-font-smoothing: antialiased;
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      font-size: 12px;
      padding: 2px 6px 2px 2px;
      content: "\f067";
      transition: transform .3s ease-in-out;
  }

  div.ks-cboxtags input[type="checkbox"]:checked + label::before {
      content: "\f00c";
      transform: rotate(-360deg);
      transition: transform .3s ease-in-out;
  }

  div.ks-cboxtags input[type="checkbox"]:checked + label {
      border: 2px solid #1bdbf8;
      background-color: #12bbd4;
      color: #fff;
      transition: all .2s;
  }

  div.ks-cboxtags input[type="checkbox"] {
    display: absolute;
  }
  div.ks-cboxtags input[type="checkbox"] {
    position: absolute;
    opacity: 0;
  }
  div.ks-cboxtags input[type="checkbox"]:focus + label {
    border: 2px solid #e9a1ff;
  }
}

#products-section {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 8em;
}
</style>
