<template>
  <div class="w-50 mx-auto mt-5">
    <h1 class="mb-5 text-center">Форма обратной связи</h1>
    <form class="feedback-form p-4" ref="feedBackForm">
      <div class="form-group mb-4">
        <label class="h3" for="exampleInputEmail1">Имя</label>
        <input
          type="text"
          name="name"
          class="form-control"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
          v-on:click="dropValidationMessage"
        />
        <div
          class="invalid-feedback"
          v-bind:class="{ 'invalid-active': validity.name }"
        >
          {{ validity.name }}
        </div>
      </div>
      <div class="form-group mb-4">
        <label class="h3" for="exampleInputPassword1">Тема обращения</label>
        <input
          type="text"
          name="heading"
          class="form-control"
          id="exampleInputPassword1"
          v-on:click="dropValidationMessage"
        />
        <div
          class="invalid-feedback"
          v-bind:class="{ 'invalid-active': validity.heading }"
        >
          {{ validity.heading }}
        </div>
      </div>
      <div class="form-group mb-4">
        <label class="h3" for="exampleFormControlTextarea1">Текст</label>
        <textarea
          class="form-control"
          name="message"
          id="exampleFormControlTextarea1"
          rows="3"
          v-on:click="dropValidationMessage"
        ></textarea>
        <div
          class="invalid-feedback"
          v-bind:class="{ 'invalid-active': validity.message }"
        >
          {{ validity.message }}
        </div>
      </div>
      <button type="button" v-on:click="feedBackSend()" class="btn btn-primary">
        Отправить
      </button>
    </form>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      validity: {
        name: false,
        heading: false,
        message: false,
      },
    };
  },
  methods: {
    dropValidationMessage(input) {
      let changedField = input.target.name;
      this.validity[changedField] = false;
    },
    updateValidity(errors) {
      for (let key in errors) {
        this.validity[key] = errors[key][0];
      }
    },
    async feedBackSend() {
      let ref = this.$refs.feedBackForm;
      var formData = new FormData(ref);
      await window.axios
        .post("/references/store", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          if (response.data.toastr_error) {
            toastr.error(response.data.toastr_error);
          }
          if (response.data.toastr_success) {
            toastr.success(response.data.toastr_success);
            ref.reset();
          }
          if (response.data.errors) {
            this.updateValidity(response.data.errors);
          }
        })
        .catch((error) => {
          // /*
          // * Handle 2xx errors
          // */
          if (error.response) {
            toastr.error("Не удалось получить ответ от сервера.");
            console.log(error.response.data);
          }
          // /*
          // * Handle no response errors
          // */
          if (error.request) {
            toastr.error("Не удалось связаться с сервером.");
            console.log(error.request);
          }
        });
    },
  },
};
</script>
