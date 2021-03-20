<template>
    <table  class="table table-sm table-bordered">
         <tr>
             <td>From: {{miniMail.from}}</td>
             <td>To: {{miniMail.to}}</td>
         </tr>
         <tr>
             <td colspan="2">subject: {{miniMail.subject}}</td>
         </tr>
         <tr>
             <td colspan="2" v-html="`Message: ${miniMail.htmlContent}`"></td>
         </tr>
         <tr>
             <td colspan="2">
                    Attachments: <br>
                 <template v-for="att in miniMail.attachments">
                    <a class="btn btn-primary" :href="att.uri">{{att.name}}</a> &nbsp;
                 </template>
             </td>
         </tr>
     </table>
</template>
<script>
export default {
    name: 'MiniMailTable',
    props: {
        miniMail:{
            type:Object,
            default:() => {}
        }
    }
}
</script>