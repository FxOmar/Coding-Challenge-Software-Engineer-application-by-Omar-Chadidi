<template>
<transition name="modal">
  <div class="modal-mask">
    <div class="modal-wrapper">
      <button class="modal-close-button" @click="$emit('close')">
        <i class="fas fa-times"></i>
      </button>
      <div class="modal-container">
        <slot></slot>
      </div>
    </div>
  </div>
</transition>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
  .modal-close-button {
    position: absolute;
    top: 0;
    right: 0;
    padding-top: 1.5em;
    padding-right: 2em;
    font-size: 1.5em;
    color: #fff;
  }
  .modal-container {
    width: 500px;
    margin: 0px auto;
    padding: 30px 30px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
  }
}


.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

</style>