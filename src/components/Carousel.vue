<template>
<div class="card-carousel-wrapper">
    <div class="card-carousel--nav__left" @click="moveCarousel(-1)" :disabled="atHeadOfList"></div>
    <div class="card-carousel">
      <div class="card-carousel--overflow-container">
        <div class="card-carousel-cards" :style="{ transform: 'translateX' + '(' + currentOffset + 'px' + ')' }">
          <div class="card-carousel--card" v-for="item in items" :key="item.id">
            <slot :item="item"></slot>
          </div>
        </div>
      </div>
    </div>
    <div class="card-carousel--nav__right" @click="moveCarousel(1)" v-if="!atEndOfList" :disabled="atEndOfList"></div>
    <div class="card-carousel--nav__right_plus" @click="moveCarousel(1)" v-else>+</div>
</div>
</template>

<script>
export default {
  props: ['items'],
  data: () => ({
    currentOffset: 0,
    windowSize: 4,
    paginationFactor: 220
  }),
  computed: {
    atEndOfList() {
      return this.currentOffset <= (this.paginationFactor * -1) * (this.items.length - this.windowSize);
    },
    atHeadOfList() {
      return this.currentOffset === 0;
    },
  },
  methods: {
    moveCarousel(direction) {
      // Find a more elegant way to express the :style. consider using props to make it truly generic
      if (direction === 1 && !this.atEndOfList) {
        this.currentOffset -= this.paginationFactor;
      } else if (direction === -1 && !this.atHeadOfList) {
        this.currentOffset += this.paginationFactor;
      }
    },
  }

}
</script>

<style lang="scss">
$vue-navy: #2c3e50;
$vue-navy-light: #3a5169;
$vue-teal: #42b883;
$vue-teal-light: #42b983;
$gray: #666a73;
$light-gray: #f8f8f8;

.card-carousel-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  color: $gray;
}

.card-carousel {
  display: flex;
  justify-content: center;
  width: 640px;
  
  &--overflow-container {
    overflow: hidden;
  }
  
  &--nav__left,
  &--nav__right {
    display: inline-block;
    width: 15px;
    height: 15px;
    padding: 10px;
    box-sizing: border-box;
    border-top: 2px solid $vue-teal;
    border-right: 2px solid $vue-teal;
    cursor: pointer;
    margin: 0 20px;
    transition: transform 150ms linear;
    &[disabled] {
      opacity: 0.2;
      border-color: black;
    }
  }
  
  &--nav__left {
    transform: rotate(-135deg);
    &:active {
      transform: rotate(-135deg) scale(0.9);
    }
  }
  
  &--nav__right {
    transform: rotate(45deg);
    &:active {
      transform: rotate(45deg) scale(0.9);
    }
  }
  &--nav__right_plus {
    font-size: 2em;
    width: 3em;
    background-color: #fff;
    box-shadow: 0px 0px 1px 0px #eee;
    border-radius: 100%;
  }
}

.card-carousel-cards {
  display: flex;
  transition: transform 150ms ease-out;
  transform: translatex(0px);
  padding: 2em;
 
  .card-carousel--card {
    margin-left: 2rem;
    cursor: pointer;
    box-shadow: 0 0px 14px 5px rgba(40, 44, 53, 0.08), 0 0px 0px 0px rgba(40, 44, 53, 0.08);
    border-radius: 4px;
    z-index: 99;
    
    &:first-child {
      margin-left: 0;
    }
    
    &:last-child {
      margin-right: 0;
    }
    
    img {
      vertical-align: bottom;
      border-top-left-radius: 4px;
      border-top-right-radius: 4px;
      transition: opacity 150ms linear;
      user-select: none;
      
      &:hover {
        opacity: 0.5;
      }
    }
    
    &--footer {
      border-top: 0;
      padding: 7px 15px;
      
      p {
        padding: 3px 0;
        margin: 0;
        margin-bottom: 2px;
        font-size: 19px;
        font-weight: 500;
        color: $vue-navy;
        user-select: none;
        
        &.tag {
          font-size: 11px;
          font-weight: 300;
          padding: 4px;
          background: rgba(40,44,53,.06);
          display: inline-block;
          position: relative;
          margin-left: 4px;
          color: $gray;
          
          &:before {
            content:"";
            float:left;
            position:absolute;
            top:0;
            left: -12px;
            width:0;
            height:0;
            border-color:transparent rgba(40,44,53,.06) transparent transparent;
            border-style:solid;
            border-width:8px 12px 12px 0;
        }
          &.secondary {
            margin-left: 0;
            border-left: 1.45px dashed white;
            &:before {
              display: none !important;
            }
          }
        
          &:after {
            content:"";
            position:absolute;
            top:8px;
            left:-3px;
            float:left;
            width:4px;
            height:4px;
            border-radius: 2px;
            background: white;
            box-shadow:-0px -0px 0px #004977;
          }
        }
      }
    }
  }
}
</style>