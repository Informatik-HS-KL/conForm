<template>
  <div class="container-fluid bg-main" style="margin-top: 160px !important">
    <PageLoader :loaded="isLoading" />
    <h1 class="mt-4"></h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item">
        <router-link to="/">conForm</router-link>
      </li>
      <li class="breadcrumb-item">
        <router-link to="/conceptPaperCreator"
          >Konzeptpapier Creator</router-link
        >
      </li>
      <li class="breadcrumb-item active">
        {{ $t("conceptPaper.conceptPaper") }}
      </li>
    </ol>
    <div class="container">
      <h1 class="mt-4">
        {{ $t("conceptPaper.conceptPaper") }}: {{ conceptPaperName }}
      </h1>
      <div class="card mb-4">
        <div class="card-header d-flex flex-row-reverse">
          <button
            type="button"
            class="btn btn-invite"
            data-toggle="modal"
            data-target="#inviteModal"
          >
            {{ $t("conceptPaper.inviteTeam") }}
          </button>
          <div style="padding-right: 20px">
            <vue-blob-json-csv
              class="btn btn-json"
              tag-name="div"
              file-type="json"
              :file-name="conceptPaper.name"
              :title="$t('conceptPaper.jsonExport')"
              :data="[editConceptPaperData]"
            >
            </vue-blob-json-csv>
            <button v-if="isLoggedIn" class="btn btn-pdf" @click="exportAsPDF">
              {{ $t("conceptPaper.pdfExport") }}
            </button>
            <button
              v-if="!isLoggedIn"
              class="btn btn-pdf"
              @click="showWatermark = true"
            >
              {{ $t("conceptPaper.pdfExport") }}
            </button>
            <button
              v-if="!isLoggedIn"
              class="btn btn-docx"
              @click="showDocxWatermark = true"
            >
              {{ $t("conceptPaper.exportDocx") }}
            </button>
            <button
              v-if="isLoggedIn"
              class="btn btn-docx"
              @click="exportAsDOCX"
            >
              {{ $t("conceptPaper.exportDocx") }}
            </button>
          </div>
        </div>
        <div class="card-body">
          <div>
            <div class="form-group">
              <table class="table">
                <td>
                  <label for="name">{{ $t("conceptPaper.projectName") }}</label>
                  <input
                    type="text"
                    v-model="conceptPaper.name"
                    class="form-control"
                    id="name"
                    :placeholder="$t('conceptPaper.placeholders.name')"
                  />
                  <div class="invalid-feedback" v-if="errors.name">
                    {{ errors.name[0] }}
                  </div>
                </td>
                <td>
                  <label for="course">{{
                    $t("conceptPaper.courseName")
                  }}</label>
                  <input
                    type="text"
                    v-model="conceptPaper.course"
                    class="form-control"
                    id="course"
                    :placeholder="$t('conceptPaper.placeholders.course')"
                  />
                  <div class="invalid-feedback" v-if="errors.course">
                    {{ errors.course[0] }}
                  </div>
                </td>
                <td>
                  <label for="currentSemester">{{
                    $t("conceptPaper.semester")
                  }}</label>
                  <input
                    type="text"
                    v-model="conceptPaper.currentSemester"
                    class="form-control"
                    id="currentSemester"
                    :placeholder="$t('conceptPaper.placeholders.semester')"
                  />
                  <div class="invalid-feedback" v-if="errors.currentSemester">
                    {{ errors.currentSemester[0] }}
                  </div>
                </td>
              </table>
            </div>
            <div class="form-group">
              <label for="image">{{ $t("conceptPaper.logo") }}</label>
              <div>
                <img
                  v-if="editConceptPaperData.image"
                  :src="`${$store.state.serverPath}/storage/${editConceptPaperData.image}`"
                  id="logo_image"
                  class="image-wd"
                  ref="editConceptPaperImageDisplay"
                />
                <img
                  v-if="!editConceptPaperData.image"
                  id="logo_image"
                  src="../../assets/conForm_logo.png"
                  class="image-wd img-h"
                />
              </div>
              <input
                type="file"
                v-on:change="editAttachedImage"
                ref="editConceptPaperImage"
                class="form-control"
                id="image"
              />
              <div class="invalid-feedback" v-if="errors.image">
                {{ errors.image[1] }}
              </div>
            </div>
            <div class="form-group">
              <label for="idea">{{ $t("conceptPaper.idea") }}</label>
              <textarea
                v-model="conceptPaper.idea"
                class="form-control"
                id="idea"
                :placeholder="$t('conceptPaper.placeholders.idea')"
                rows="6"
              />
              <div class="invalid-feedback" v-if="errors.idea">
                {{ errors.idea[0] }}
              </div>
            </div>
            <div class="form-group">
              <label for="basics">{{ $t("conceptPaper.mustHave") }}</label>
              <textarea
                v-model="conceptPaper.basics"
                class="form-control"
                id="basics"
                :placeholder="$t('conceptPaper.placeholders.basics')"
                rows="8"
              />
              <div class="invalid-feedback" v-if="errors.basics">
                {{ errors.basics[0] }}
              </div>
            </div>
            <div class="form-group">
              <label for="niceToHave">{{
                $t("conceptPaper.niceToHave")
              }}</label>
              <textarea
                v-model="conceptPaper.niceToHave"
                class="form-control"
                id="niceToHave"
                :placeholder="$t('conceptPaper.placeholders.niceToHave')"
                rows="8"
              />
              <div class="invalid-feedback" v-if="errors.niceToHave">
                {{ errors.niceToHave[0] }}
              </div>
            </div>
            <div class="form-group">
              <label for="technologies">{{
                $t("conceptPaper.technologies")
              }}</label>
              <textarea
                v-model="conceptPaper.technologies"
                class="form-control"
                id="technologies"
                :placeholder="$t('conceptPaper.placeholders.tech')"
                rows="5"
              />
              <div class="invalid-feedback" v-if="errors.technologies">
                {{ errors.technologies[0] }}
              </div>
            </div>
            <div class="form-group">
              <label for="team">{{ $t("conceptPaper.team") }}</label>
              <textarea
                v-model="conceptPaper.team"
                class="form-control"
                id="team"
                :placeholder="$t('conceptPaper.placeholders.team')"
                rows="5"
              />
              <div class="invalid-feedback" v-if="errors.team">
                {{ errors.team[0] }}
              </div>
            </div>
            <div class="text-right">
              <button type="button" class="btn btn-default" @click="undoChanges">
                {{ $t("conceptPaper.cancel") }}
              </button>
              <button
                id="notifyBtn"
                class="btn btn-primary"
                @click="loadEditConceptPaperData"
              >
                <span class="fa fa-check"></span>
                {{ $t("conceptPaper.update") }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <InviteTeam :joinCode="conceptPaper.joinCodeDB" />
    <CreateAccountModal v-if="showModal" @close="showModal = false" />
    <PDFWatermark
      v-if="showWatermark"
      @close="showWatermark = false"
      @downloadpdf="exportAsPDFWithWatermark"
    />
    <DOCXWatermark
      v-if="showDocxWatermark"
      @close="showDocxWatermark = false"
      @downloaddocx="exportAsDOCXWithWatermark"
    />
    <img
      src="../../assets/conForm_watermark.png"
      id="watermark"
      style="display: none"
    />
    <img
      src="../../assets/Logo_of_Hochschule_Kaiserslautern.png"
      id="hskl_branding"
      class="image-wd"
      style="display: none"
    />
  </div>
</template>


<script>
import axios from "axios";
import router from "../router";
import PageLoader from "../components/PageLoader/PageLoader.vue";
import * as conceptPaperService from "../services/conceptPaper_service";
import { uuid } from "vue-uuid";
import { http } from "../services/http_service";
import { saveAs } from "file-saver";
import { Packer } from "docx";

import { DocumentCreatorDOCX } from "../services/conceptPaperDOCXGenerator_service";
import { DocumentCreatorDOCXWithWatermark } from "../services/conceptPaperDOCXGeneratorWithWatermark_service";

import { DocumentCreatorPDF } from "../services/conceptPaperPDFGenerator_service";
import { DocumentCreatorPDFWithWatermark } from "../services/conceptPaperPDFGeneratorWithWatermark_service";

import { jsPDF } from "jspdf";
import InviteTeam from "../components/modals/InviteYourTeam.vue";
import CreateAccountModal from "../components/modals/CreateAccountModal.vue";
import PDFWatermark from "../components/modals/PdfWatermark.vue";
import DOCXWatermark from "../components/modals/DocxWatermark.vue";

export default {
  data() {
    return {
      joinCode: this.$route.params.joincode,
      conceptPapers: [],
      conceptPaper: {
        name: "",
        course: "",
        currentSemester: "",
        idea: "",
        basics: "",
        niceToHave: "",
        technologies: "",
        team: "",
        joinCodeDB: "",
        userID: "",
      },
      isLoading: false,
      editConceptPaperData: {},
      errors: {},
      showModal: false,
      showWatermark: false,
      showDocxWatermark: false,
      isLoggedIn: null,
      fields: [
        "name",
        "course",
        "currentSemester",
        "idea",
        "basics",
        "niceToHave",
        "technologies",
        "team",
      ],
      cachedFormData: null,
      conceptPaperName: ''
    };
  },
  components: {
    PageLoader,
    InviteTeam,
    CreateAccountModal,
    PDFWatermark,
    DOCXWatermark,
  },
  created: function () {
    // Create a cache when component/app is created
    document.addEventListener("beforeunload", this.handlerClose);
  },
  computed: {
    // Compares cached user data to live data
    hasChanged() {
      return this.cachedFormData !== this.formDataForComparison();
    },
  },
  mounted() {
    this.loadConceptPaper();
    this.isLoggedIn = localStorage.getItem("jwt");
  },
  methods: {
    // Callback handler
    handlerClose: function () {
      if (this.hasChanged) {
        // Logic when change is detected
        // e.g. you can show a confirm() dialog to ask if user wants to proceed
      } else {
        // Logic when no change is detected
      }
    },
    // Helper method that generates JSON for string comparison
    formDataForComparison: function () {
      return JSON.stringify({
        name : this.conceptPaper.name,
        course : this.conceptPaper.course,
        idea : this.conceptPaper.idea,
        basics : this.conceptPaper.basics,
        niceToHave : this.conceptPaper.niceToHave,
        technologies : this.conceptPaper.technologies,
        team : this.conceptPaper.team,
      });
    },
    loadConceptPaper() {
      this.isLoading = true;
      axios
        .get(`conceptPaper/lobby/${this.joinCode}`)
        .then((response) => {
          this.conceptPaperName = response.data.name;
          this.conceptPaper.name = response.data.name;
          this.conceptPaper.course = response.data.course;
          this.conceptPaper.currentSemester = response.data.currentSemester;
          this.conceptPaper.image = response.data.image;
          this.conceptPaper.idea = response.data.idea;
          this.conceptPaper.basics = response.data.basics;
          this.conceptPaper.niceToHave = response.data.niceToHave;
          this.conceptPaper.technologies = response.data.technologies;
          this.conceptPaper.team = response.data.team;
          this.conceptPaper.joinCodeDB = response.data.join_code;
          this.conceptPaper.userID = response.data.user_id;

          this.conceptPapers = response.data;

          this.editConceptPaperData = { ...response.data };
          console.log(this.editConceptPaperData);

          setTimeout(() => {
            this.isLoading = false;
          }, 500);

          this.cachedFormData = this.formDataForComparison();
        })
        .catch(function (error) {
          if (error.response.status === 404) {
            router.push("/notFound");
          }
        });
    },
    loadEditConceptPaperData() {
      this.editConceptPaperData.name = this.conceptPaper.name;
      this.editConceptPaperData.course = this.conceptPaper.course;
      this.editConceptPaperData.idea = this.conceptPaper.idea;
      this.editConceptPaperData.basics = this.conceptPaper.basics;
      this.editConceptPaperData.niceToHave = this.conceptPaper.niceToHave;
      this.editConceptPaperData.technologies = this.conceptPaper.technologies;
      this.editConceptPaperData.team = this.conceptPaper.team;
      this.updateConceptPaper();
    },
    updateConceptPaper: async function () {
      try {
        const formData = new FormData();
        formData.append("name", this.editConceptPaperData.name);
        formData.append("course", this.editConceptPaperData.course);
        formData.append(
          "currentSemester",
          this.editConceptPaperData.currentSemester
        );
        formData.append("image", this.editConceptPaperData.image);
        formData.append("idea", this.editConceptPaperData.idea);
        formData.append("basics", this.editConceptPaperData.basics);
        formData.append("niceToHave", this.editConceptPaperData.niceToHave);
        formData.append("technologies", this.editConceptPaperData.technologies);
        formData.append("team", this.editConceptPaperData.team);
        formData.append("join_code", this.conceptPaper.joinCodeDB);
        formData.append("user_id", this.conceptPaper.userID);
        formData.append("_method", "put");

        const response = await conceptPaperService.updateConceptPaper(
          this.editConceptPaperData.id,
          formData
        );
        /**
        this.conceptPapers.map((conceptPaper) => {
          if (conceptPaper.id == response.data.id) {
            for (let key in response.data) {
              conceptPaper[key] = response.data[key];
            }
          }
        }); */

        this.flashMessage.success({
          message: "Konzeptpapier wurde erfolgreich geupdated!",
          time: 5000,
        });
      } catch (error) {
        switch (error.response.status) {
          case 401:
            this.showModal = true;
          case 422:
            this.errors = error.response.data.errors;
          default:
            this.flashMessage.error({
              message: error.response.data.message,
              time: 5000,
            });
        }
      }
    },
    editAttachedImage() {
      this.editConceptPaperData.image = this.$refs.editConceptPaperImage.files[0];
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.$refs.editConceptPaperImageDisplay.src = reader.result;
        }.bind(this),
        false
      );

      reader.readAsDataURL(this.editConceptPaperData.image);
    },
    copyTestingCode() {
      let testingCodeToCopy = document.querySelector("#testing-code");
      testingCodeToCopy.setAttribute("type", "text");
      testingCodeToCopy.select();
      try {
        var successful = document.execCommand("copy");
        var msg = successful
          ? this.flashMessage.success({
              message: "Join Code erfolgreich generiert",
              time: 5000,
            })
          : this.flashMessage.error({
              message: "Oops, etwas ist schiefgelaufen",
              time: 5000,
            });
      } catch (err) {
        alert("Oops, kopieren nicht möglich");
      }

      /* unselect the range */
      testingCodeToCopy.setAttribute("type", "hidden");
      window.getSelection().removeAllRanges();
    },
    exportAsDOCX: async function () {
      var img = document.getElementById("logo_image");
      function calculateAspectRatioFit(
        srcWidth,
        srcHeight,
        maxWidth,
        maxHeight
      ) {
        var ratio = Math.min(maxWidth / srcWidth, maxHeight / srcHeight);

        return { widthImg: srcWidth * ratio, heightImg: srcHeight * ratio };
      }
      const { widthImg, heightImg } = calculateAspectRatioFit(
        img.naturalWidth || img.width,
        img.naturalHeight || img.height,
        540,
        120
      );

      var hskl_branding = document.getElementById("hskl_branding");

      console.log(widthImg, heightImg, img.naturalWidth, img.naturalHeight);
      function calculateAspectRatioFitHSKLBranding(
        srcWidth,
        srcHeight,
        maxWidth,
        maxHeight
      ) {
        var ratio = Math.min(maxWidth / srcWidth, maxHeight / srcHeight);

        return { widthHSKL: srcWidth * ratio, heightHSKL: srcHeight * ratio };
      }
      const { widthHSKL, heightHSKL } = calculateAspectRatioFitHSKLBranding(
        hskl_branding.naturalWidth || hskl_branding.width,
        hskl_branding.naturalHeight || hskl_branding.height,
        540,
        100
      );

      async function imageToUint8Array(image, width, height) {
        const canvas = document.createElement("canvas");
        const context = canvas.getContext("2d");

        return new Promise((resolve, reject) => {
          canvas.width = width;
          canvas.height = height;
          context.width = width;
          context.height = height;
          context.drawImage(image, 0, 0, width, height);
          context.canvas.toBlob((blob) =>
            blob
              .arrayBuffer()
              .then((buffer) => resolve(new Uint8Array(buffer)))
              .catch(reject)
          );
        });
      }

      const logo = await imageToUint8Array(img, widthImg, heightImg);
      const hskl_branding_logo = await imageToUint8Array(
        hskl_branding,
        widthHSKL,
        heightHSKL
      );

      const documentCreator = new DocumentCreatorDOCX();
      const {
        name,
        course,
        currentSemester,
        idea,
        basics,
        niceToHave,
        technologies,
        team,
      } = this.editConceptPaperData;
      const doc = documentCreator.create([
        name,
        course,
        currentSemester,
        logo,
        widthImg,
        heightImg,
        idea,
        basics,
        niceToHave,
        technologies,
        team,
        hskl_branding_logo,
        widthHSKL,
        heightHSKL,
      ]);

      Packer.toBlob(doc).then((blob) => {
        console.log(blob);
        saveAs(
          blob,
          "Konzeptpapier_" + this.editConceptPaperData.name + ".docx"
        );
        this.flashMessage.success({
          message: "DOCX Document created successfully",
          time: 5000,
        });
      });
    },
    exportAsPDF: function () {
      var logo = document.getElementById("logo_image");
      var hskl_branding = document.getElementById("hskl_branding");

      const documentCreatorPDF = new DocumentCreatorPDF();
      const {
        name,
        course,
        currentSemester,
        image,
        idea,
        basics,
        niceToHave,
        technologies,
        team,
      } = this.editConceptPaperData;
      const doc = documentCreatorPDF.create([
        name,
        course,
        currentSemester,
        logo,
        idea,
        basics,
        niceToHave,
        technologies,
        team,
        hskl_branding,
      ]);
      doc.save("Konzeptpapier_" + name + ".pdf");
      this.flashMessage.success({
        message: "PDF Document created successfully",
        time: 5000,
      });
    },
    exportAsPDFWithWatermark: function () {
      var logo = document.getElementById("logo_image");
      var hskl_branding = document.getElementById("hskl_branding");
      var watermark = document.getElementById("watermark");

      const documentCreatorPDF = new DocumentCreatorPDFWithWatermark();
      const {
        name,
        course,
        currentSemester,
        image,
        idea,
        basics,
        niceToHave,
        technologies,
        team,
      } = this.editConceptPaperData;
      const doc = documentCreatorPDF.create([
        name,
        course,
        currentSemester,
        logo,
        watermark,
        idea,
        basics,
        niceToHave,
        technologies,
        team,
      ]);
      doc.save("Konzeptpapier_" + name + ".pdf");
      this.flashMessage.success({
        message: "PDF Document created successfully",
        time: 5000,
      });
    },
    exportAsDOCXWithWatermark: async function () {
      var img = document.getElementById("logo_image");
      function calculateAspectRatioFit(
        srcWidth,
        srcHeight,
        maxWidth,
        maxHeight
      ) {
        var ratio = Math.min(maxWidth / srcWidth, maxHeight / srcHeight);

        return { widthImg: srcWidth * ratio, heightImg: srcHeight * ratio };
      }
      const { widthImg, heightImg } = calculateAspectRatioFit(
        img.naturalWidth || img.width,
        img.naturalHeight || img.height,
        540,
        120
      );

      var hskl_branding = document.getElementById("hskl_branding");
      function calculateAspectRatioFitHSKLBranding(
        srcWidth,
        srcHeight,
        maxWidth,
        maxHeight
      ) {
        var ratio = Math.min(maxWidth / srcWidth, maxHeight / srcHeight);

        return { widthHSKL: srcWidth * ratio, heightHSKL: srcHeight * ratio };
      }
      const { widthHSKL, heightHSKL } = calculateAspectRatioFitHSKLBranding(
        hskl_branding.naturalWidth || hskl_branding.width,
        hskl_branding.naturalHeight || hskl_branding.height,
        540,
        100
      );

      var wartermark = document.getElementById("watermark");
      console.log(
        widthWatermark,
        heightWatermark,
        watermark.naturalWidth,
        wartermark.naturalHeight
      );
      function calculateAspectRatioFitWatermark(
        srcWidth,
        srcHeight,
        maxWidth,
        maxHeight
      ) {
        var ratio = Math.min(maxWidth / srcWidth, maxHeight / srcHeight);

        return {
          widthWatermark: srcWidth * ratio,
          heightWatermark: srcHeight * ratio,
        };
      }
      const {
        widthWatermark,
        heightWatermark,
      } = calculateAspectRatioFitWatermark(
        watermark.naturalWidth || wartermark.width,
        watermark.naturalHeight || wartermark.height,
        400,
        400
      );

      async function imageToUint8Array(image, width, height) {
        const canvas = document.createElement("canvas");
        const context = canvas.getContext("2d");

        return new Promise((resolve, reject) => {
          canvas.width = width;
          canvas.height = height;
          context.width = width;
          context.height = height;
          context.drawImage(image, 0, 0, width, height);
          context.canvas.toBlob((blob) =>
            blob
              .arrayBuffer()
              .then((buffer) => resolve(new Uint8Array(buffer)))
              .catch(reject)
          );
        });
      }

      const logo = await imageToUint8Array(img, widthImg, heightImg);
      const hskl_branding_logo = await imageToUint8Array(
        hskl_branding,
        widthHSKL,
        heightHSKL
      );
      const watermark_logo = await imageToUint8Array(
        watermark,
        widthWatermark,
        heightWatermark
      );

      const documentCreator = new DocumentCreatorDOCXWithWatermark();
      const {
        name,
        course,
        currentSemester,
        idea,
        basics,
        niceToHave,
        technologies,
        team,
      } = this.editConceptPaperData;
      const doc = documentCreator.create([
        name,
        course,
        currentSemester,
        logo,
        widthImg,
        heightImg,
        idea,
        basics,
        niceToHave,
        technologies,
        team,
        hskl_branding_logo,
        widthHSKL,
        heightHSKL,
        watermark_logo,
        widthWatermark,
        heightWatermark,
      ]);

      Packer.toBlob(doc).then((blob) => {
        console.log(blob);
        saveAs(
          blob,
          "Konzeptpapier_" + this.editConceptPaperData.name + ".docx"
        );
        this.flashMessage.success({
          message: "DOCX Document created successfully",
          time: 5000,
        });
      });
    },
    undoChanges() {
      window.location.reload()
    }
  },
  beforeRouteLeave(to, from, next) {
    if (this.hasChanged) {
      const answer = window.confirm(
        this.$t('conceptPaper.leave')
      );
      if (answer) {
        next();
      } else {
        next(false);
      }
    } else {
      next();
    }
  },
};
</script>

<style lang="scss" scoped>
.btn-invite,
.btn-pdf,
.btn-docx {
  color: #fff;
}

.btn-invite {
  background-color: #5c55ba;
}

.btn-json {
   border: 0.5px solid rgba(0,0,0,0.5);
}

.btn-pdf,
.btn-docx {
  background-color: #ff7e85;
}

.container {
  display: flex;
  justify-content: center;
  align-content: center;
  flex-flow: column;
}

.dark {
  .breadcrumb {
    background-color: #20232a;

    a {
      color: #fff;
    }
  }

  .bg-main {
    background-color: #121212 !important;
  }

  .card {
    background: #20232a !important;
  }

  table {
    td {
      label {
        color: #fff;
      }
    }
  }

  .btn-json {
    color: #fff;
    border: 0.5px solid rgba(#fff,0.5);
  }
  .content {
    background-color: #20232a;
  }

  .form-group {
    label {
      color: #fff;
    }
    
      input {
        background-color: #20232a !important;
        color: #f3f3f3 !important;
      }

      textarea {
        background-color: #20232a !important;
        color: #f3f3f3 !important;
      }
  }

}


.breadcrumb {
  a {
    color: #212529;
  }
}
</style>