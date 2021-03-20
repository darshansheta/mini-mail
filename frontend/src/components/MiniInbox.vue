<template>
    <div class="container-fluid">
      <div class="row">
        <div class="col-2 w-100  m-0 p-0 border-right border-top bg-light"> <h5 class="text-center">Recipients</h5> </div>
        <div class="col-3 w-100  m-0 p-0 border-right border-top bg-light"> <h5 class="text-center">Recipient's Mails</h5> </div>
        <div class="col-7 w-100  m-0 p-0 border-right border-top bg-light"> <h5 class="text-center">Mail</h5> </div>
      </div>
      <div class="row">
        <div class="col-2 w-100  m-0 p-0">
          <ul class="list-group">
            <li 
                :class="{active: recipient === activeRecipient}"
                class="list-group-item rounded-0"
                v-for="recipient in recipients"
                @click="selectRecipient(recipient)"
            >
                {{recipient}}  <span class="float-right text-bold">  >> </span>
            </li>
          </ul>
        </div>
        <div class="col-3 w-100 border-right m-0 p-0 " :class="{'border-top': recipientMails.length === 0 }">
        <div class="list-group">
            <!-- <li 
                :class="{active: mail.id === activeMailId}"
                class="list-group-item rounded-0"
                v-for="mail in recipientMails"
                @click="getMail(mail.id)"
            >
                {{recipient}}  <span class="float-right text-bold">  >> </span>
            </li> -->
            <a 
                v-for="mail in recipientMails"
                href="#" 
                class="list-group-item list-group-item-action flex-column align-items-start rounded-0"
                :class="{active: mail.id === activeMailId}"
                @click.prevent="getMail(mail.id)"
            >
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{mail.subject}}</h5>
                  <small>{{ mail.sentAt | moment("from", "now", true) }}</small>
                </div>
                <small>{{mail.from}}</small>
              </a>
          </div>
        </div>
        <div class="col-7 w-100 border-right m-0 p-0"  :class="{'border-top': miniMail === null }">
          <mini-mail-table :miniMail="miniMail" v-if="miniMail"></mini-mail-table>
        </div>
      </div>
    </div>
</template>
<script>
import { mapGetters, mapActions,mapMutations } from 'vuex';
import MiniMailTable from './MiniMailTable'
export default {
    name: 'MiniInbox',
    data: () => {
        return {
            activeRecipient: null,
            activeMailId: null
        }
    },
    components: {
        MiniMailTable
    },
    mounted() {
        this.getRecipientsAction()
    },
    methods: {
        ...mapActions({
            getRecipientsAction: 'miniMail/getRecipientsAction',
            getRecipientMailsAction: 'miniMail/getRecipientMailsAction',
            getMiniMailAction: 'miniMail/getMiniMailAction'
        }),
        selectRecipient(rec) {
            this.activeRecipient = rec
            this.getRecipientMailsAction(this.activeRecipient);
        },
        getMail(id) {
            this.activeMailId = id
            this.getMiniMailAction({id})
        }
    },
    computed: {
        ...mapGetters({
            recipients: 'miniMail/recipientsGetter',
            recipientMails: 'miniMail/recipientMailsGetter',
            miniMail: 'miniMail/miniMailGetter',
        })
    }
}
</script>