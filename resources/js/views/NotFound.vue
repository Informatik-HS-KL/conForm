<template>
  <div class="error-container vertical-center">
    <div class="img-wrapper">
      <img class="img-light" src="../../assets/id_not_found.svg" />
      <img class="img-dark" src="../../assets/id_not_found_dark.svg" style="display: none" />
    </div>
    <div class="content-wrapper">
      <h1 class="has-text-centered is-bold">Ooops! {{ $t("404.notexist") }}</h1>
      <div class="btn-wrapper">
        <router-link to="/">
          <button class="btn btn-lg">{{ $t("404.home") }}</button>
        </router-link>
        <router-link to="/conceptPaperCreator">
          <button class="btn btn-lg">{{ $t("404.topapers") }}</button>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    error: {
      type: Object,
      default: () => {},
    },
  },
  layout: "empty",
};
</script>

<style lang="scss" scoped>
.error-container.vertical-center {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-flow: column;
  min-height: 100%;
  min-height: 100vh;

  .img-wrapper {
    display: flex;
    justify-content: center;

    img {
      max-width: 60%;
    }
  }

  .content-wrapper {
    display: flex;
    flex-flow: column;
    align-items: center;
    margin-top: 40px;

    .is-bold {
      font-size: 28px;
      font-weight: 700;
      color: #4a4a4a;
    }

    button {
      margin-top: 10px;
      background-color: #5c55ba;
      color: #fff;
    }
  }
}

.dark {
  .error-container.vertical-center {
    .img-wrapper {
      .img-light {
        display: none;
      }
      .img-dark {
        display: block !important;
      }
    }
    .is-bold {
      color: #ebedf0;
    }
  }
}
</style>
