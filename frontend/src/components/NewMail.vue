<template>
    <div class="container-fluid">
    <div class="row">
    <div class="col">
        <form @submit.prevent="handleSubmit">
          <div class="form-group">
            <label for="">From Email</label>
            <input type="email" v-model="from" class="form-control" placeholder="From email" required>
          </div>
          <div class="form-group">
            <label for="">To Email</label>
            <input type="email" v-model="to" class="form-control" placeholder="To email" required>
          </div>
          <div class="form-group">
            <label for="">Subject</label>
            <input type="text"  v-model="subject" class="form-control" placeholder="Subject" required>
          </div>
          <div class="form-group">
            <label for="">Message</label>
            <froala :tag="'textarea'" :config="config" v-model="htmlContent"></froala>
          </div>
          <div class="form-group">
            <label for="">Attachments</label>
            <input type="file" id="files" ref="files" class="form-control" multiple @change="handleFileUploads"/>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    </div>
    </div>
</template>
<script>
import VueFroala from 'vue-froala-wysiwyg'
import { mapGetters, mapActions, mapMutations } from 'vuex';
export default {
    name: 'NewMail',
    data: () => {
        return {
            from: '',
            to: '',
            subject: '',
            htmlContent: '',
            attachments: null,

            config: {
                events: {
                  'froalaEditor.initialized': function () {
                    console.log('initialized')
                  }
                },
                height:'230px'
              }
        }
    },
    components:{
        
    },
    methods: {
        ...mapActions({
            submitMailAction:'miniMail/submitMailAction',
        }),
        handleFileUploads(){
          this.attachments = this.$refs.files.files;
        },
        handleSubmit() {
            /*
              Initialize the form data
            */
            let formData = new FormData();

            /*
              Iteate over any file sent over appending the files
              to the form data.
            */
            for( var i = 0; i < this.attachments.length; i++ ){
              let file = this.attachments[i];
              console.log(file)

              formData.append('attachments[' + i + ']', file);
            }
            formData.append('to', this.to);
            formData.append('from', this.from);
            formData.append('subject', this.subject);
            formData.append('htmlContent', this.htmlContent);
            // console.log(formData)
            // return;
            this.submitMailAction(formData)
            .then(resp => {
                alert("Mail submitted successfully.");
                this.$router.push('/list')
            });
        }
    }
}
</script>