import Vue from 'vue'
import Router from 'vue-router'
import MailList from './components/MailList'
import NewMail from './components/NewMail'
import MiniMail from './components/MiniMail'
import MiniInbox from './components/MiniInbox'

Vue.use(Router)
export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      redirect: '/list'
    },
    {
      path: '/list',
      name: 'home',
      component: MailList
    },
    {
      path: '/min-mail/:id?',
      name: 'min-mail',
      component: MiniMail
    },
    {
      path: '/new',
      name: 'new',
      component: NewMail
    },
    {
      path: '/inbox',
      name: 'inbox',
      component: MiniInbox
    },
    {
      path: '*',
      redirect: '/list'
    }
  ]
})
