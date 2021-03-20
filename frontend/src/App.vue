<template>
  <div id="app">
    <!---->
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
          <h5 class="my-0 mr-md-auto font-weight-normal">MINIMail</h5>
          <nav class="my-2 my-md-0">
            <router-link  class="p-2 text-dark" to="/">Mails</router-link> |
            <router-link  class="p-2 text-dark" to="/new">Send Mail</router-link> |
            <router-link  class="p-2 text-dark" to="/inbox">Inbox</router-link>
          </nav>
        </div>
    <!---->

    <router-view/>
  </div>
</template>