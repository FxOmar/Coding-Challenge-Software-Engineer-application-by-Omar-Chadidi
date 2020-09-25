<template>
<div>
    <div class="form-grp">
        <label>Name*</label>
        <input type="text" v-model="name" placeholder="Oculus Quest 2"/>
    </div>
    <div class="form-grp">
      <label class="typo__label">Category</label>
      <multiselect v-model="value" :options="options" :multiple="true"  placeholder="Type to search" track-by="id" label="name"><span slot="noResult">Oops! No elements found. Consider changing the search query.</span></multiselect>
    </div>
    <div class="form-grp">
        <label>Description*</label>
        <textarea type="text" v-model="description" placeholder="Earth"/>
    </div>
    <div class="form-grp">
        <label>Price</label>
        <input type="number" v-model="price" min="0.00" max="10000.00" step="0.01" placeholder="99.99" />
    </div>
    <div class="form-grp">
        <label>Image*</label>
        <input type="file" accept="image/*" ref="file" v-on:change="onChangeFileUpload()" name="image">
    </div>
    <div class="form-grp">
        <input @click="submit" type="submit" value="Add New Product"/>
    </div>
</div>
</template>

<script>
import Axios from 'axios'
import Multiselect from 'vue-multiselect'


export default {
  props: {
    options: {
      type: Array,
      default: function () { return [] }
    },
    product: {
      type: Object,
    }
  },

  data () {
    return {
      name:  (!this.product? '' : this.product.name),
      description: (!this.product? '' : this.product.description), 
      price: (!this.product? 0 : this.product.price),
      image: null,
      value: (!this.product? [] : this.product.categories),
      categories: []
    }
  },

  components: {
    Multiselect
  },
  
  methods: {
    async submit () {
      
      let formData = new FormData()
      formData.append('name', this.name)
      formData.append('description', this.description)
      formData.append('price', this.price)
      formData.append('image', this.image)

      this.value.map(category => (this.categories.push(category.id)))
      formData.append('categories', this.categories)

      await Axios.post('http://store.test/api/products', formData, 
      {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      this.$emit('close')
      this.$emit('update')
    },
    onChangeFileUpload(){
      this.image = this.$refs.file.files[0];
    }
  }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style lang="scss" scoped>
$dark: #212121;
$input-border-radius: 4px;
$input-border-width: .063rem;
$input-border-color: #b0bec5;
$input-padding: .75rem .875rem;
$input-submit-bg: #2196f3;
$input-submit-bg-hover: lighten($input-submit-bg, 5%);
$input-submit-padding: .75rem 1.5rem;

.form-grp {
  margin: 0 2rem 1rem;
  
  label {
    display: block;
    margin: 0 0 .5rem;
    font-weight: 700;
    letter-spacing: .2px;
    font-size: .875rem;
    color: $dark;
    
    &.inline {
      display: inline-block;
      width: 100px;
    }
    
    &.inline.right {
      text-align: right;
      padding-right: .5rem;
    }
  }
}

input[type="text"],
input[type="Number"],
textarea {
  padding: $input-padding;
  border-radius: $input-border-radius;
  outline: 0;
  color: $dark;
  font-size: .875rem;
  width: 100%;
  border: $input-border-width solid $input-border-color;
  
}

input[type="submit"] {
  padding: $input-submit-padding;
  margin: .5rem 0 0;
  outline: 0;
  border: 0;
  background: $input-submit-bg;
  border-radius: $input-border-radius;
  color: #FFF;
  font-weight: 700;
  font-size: .875rem;
  letter-spacing: .25px;
  transition: background .3s ease;
  
  &:hover {
    background: $input-submit-bg-hover;
  }
}
</style>