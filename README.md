## Features
- flexible code of BE and FE
- didn't use inbuilt vue setting of laravel
- instead created separate folder of frontend code so that in future easily can move repo and have more access to webpack or vue config

### In Laravel used following things
- rest API to create and list/search mails
- request class to keep validation separate 
- resource class to convert model to proper response
- create command that will batch process 200 mail in loop , I avoided sending mail when storing in db because considering case where app can be used by thousands of clients
- factory to seed data of mail

### In Frontend Vue
- created dashboard to list mail with advance search of from mail, to mail , subject line and status of mail
     - in this I have used my modified VueTable that I developed to handle dynamic data of my case
- used request canceling feature of axios to avoid when user keeps typing in search box that can lead many api call so it can hike database sparks 
- used vuex to handle paginated result , filter, sorting etc...

Other things that I used in vue
- router, vuex, axios, froala editor, bootstrap

- created vue config so that when we build final js bundle it will replace '../resources/views/layouts/vue.blade.php'  


### Steps to run project
- clone repo
- install dependencies, setup virtual host, setup database and run migration
- go to frontend folder,  update PROXY_ROOT_API EVN value in  .env file with your virtual host url
- run `npm run serve` to start development
- to build bundle, run `npm run build`, it will automatically replace/add laravel view, js and css files.
- generate fake data from tinker by running `App\Models\MiniMail::factory()->count(110)->create();` command
